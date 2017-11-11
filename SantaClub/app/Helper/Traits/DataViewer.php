<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes
* @copyright Copyright (c) 2017
* @category PHP Trait
* @version [1.2.2]
* @date     2017-10-05
* @license Este software não e LIVRE, foi desenvolvido em 2017, por Gilberto Prudêncio Vaz de Moraes (moraesdev@gmail.com), ao qual pertencem e se resguardam todas as propriedades intelectuais.
*/
namespace App\Helper\Traits;

use Validator;

trait DataViewer {

  private $dv_columns           = null;
  private $dv_searchableColumns = [];
  private $dv_indentity         = '';
  // $dv_title_column set this for delete confirmation, this column will be label for message row will be delete

  private $validator_messages     = [
    'column.in' => 'Nome de coluna inválida',
    'direction.in' => 'A direção precisa ser asc ou desc',
  ];

  /**
  * [gm - loadQueryColumns]
  * This load coumuns and searchable columns from query first result,
  * and protected dv_config [name:string,label:string,search:boolean]
  *
  * @param  [Illuminate/Database/Query/Builder] $query
  * @return [Boolean]
  */
  private function loadQueryColumns($query, $loadSearchables = true){
    if (!$query)
    $query = parent::newQuery();
    $first = $query->first();
    if ($first) {
      $dvConfig = [];
      if (isset($this->dv_config) && is_array($this->dv_config))
      $dvConfig = $this->dv_config;
      $this->dv_columns = collect($first)->map(function($val,$key) use ($dvConfig,$loadSearchables) {
        $label = str_replace('_',' ', title_case($key));
        foreach ($dvConfig as $value) {
          if (isset($value["name"]) && $value["name"] == $label) {
            if (isset($value["label"]))
            $label = $value["label"];
            if ($loadSearchables && isset($value["search"]) && $value["search"] == true && !in_array($key, $this->dv_searchableColumns))
            $this->dv_searchableColumns[]= $key;
          }
        }
        return $label;
      })->toArray();
      return $query;
    }
    return false;
  }


  private function loadConfigColumns(){
    foreach ($this->dv_config as $config) {
      foreach ($config as $key => $value) {
        if (isset($config['name'])) {
          $this->dv_columns[$config['name']] = isset($config["label"]) ? $config["label"] : str_replace('_',' ', title_case($config['name']));
          if (isset($config["search"]) && $config["search"] == true && !in_array($config['name'], $this->dv_searchableColumns))
          $this->dv_searchableColumns[]= $config['name'];
        }
      }
    }
  }

  /**
   * [sort_columns Order result data by config order]
   * @param  [Array] $columns [description]
   * @return [Array]          [FORMATED ARRAY]
   */
  private function sort_columns($columns){
    if (is_array($this->dv_config) && count($this->dv_config)>0) {
      $configColumns = collect($this->dv_config)->pluck('name')->filter(function($value, $key){
        return  $value != null ;
      })->toArray();
      if (is_object($columns)) { 
        $columns = collect($columns)->toArray();
      }
      $columns = array_merge(array_flip($configColumns), $columns);
    }
    return $columns;
  }

  /**
  * [gm - mergeDataViwerExtraColumns description]
  * @param  [Illuminate/Database/Query/Builder] $pagination [required]
  * @return [array]
  */
  public function mergeDataViwerExtraColumns($pagination){
    $pagination = $pagination->toArray();
    foreach ($pagination['data'] as $key => $value) {
      $pagination['data'][$key] = $this->sort_columns($value);
    }
    return collect(['columns'=>$this->sort_columns($this->dv_columns),'primary'=>$this->primaryKey,'title_column'=>$this->dv_title_column,'hidden_columns'=> $this->dv_hidden])->merge($pagination);
  }

  /**
  * [gm - DataViewerData description]
  * @param [Illuminate\Http\Request]  $request  [required]
  * @param [Illuminate/Database/Query/Builder]  $query    [optional custom querybuilder]
  * @param boolean $paginate [default true]
  */
  public function DataViewerData($request, $query = null,$paginate = 15, $mergeColumns = true) {
    if(!isset($this->dv_config) || $this->dv_config === [])
    $this->loadQueryColumns($query);
    else
    $this->loadConfigColumns();
    $plimit = $request->get('plimit');

    $paginate = $plimit ? $plimit : $paginate;

    if (!$query)
    $query = parent::newQuery();

    $v =  Validator::make($request->only([
      'column',
      'direction',
      'search_term'
    ]),[
      'order_column' =>'nullable|alpha_dash|in:'.implode(',',$this->dv_columns),
      'order_direction'=>'nullable|in:asc,desc',
      'search_term'=>'nullable',
    ], $this->validator_messages);

    if ($v->fails())
    return $v->errors()->all();

    $searchTerm     = strtolower($request->search_term ? $request->search_term:"");

    if ($searchTerm !="")
    $query = $query->where(function ($q) use ($searchTerm) {
      foreach ($this->dv_searchableColumns as $searchColumn) {
        //mysql
        $q->orWhereRaw('LOWER('.$searchColumn.') like ?', ['%'.$searchTerm.'%']);
        //oracle
        // $query->orWhere($searchColumn,'ilike', '%'.$searchTerm.'%');
      }
    });
    if ($request->order_column && $request->order_direction)
    $query = $query->orderBy($request->order_column, $request->order_direction);
    // dd($query->toSql()); //if want see sql uncomment this line
    if ($paginate && $mergeColumns)
    return $this->mergeDataViwerExtraColumns($query->paginate($paginate));

    return $paginate ? $query->paginate($paginate) : $query;
  }
}
