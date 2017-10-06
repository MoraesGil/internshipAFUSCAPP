<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes
* @copyright Copyright (c) 2017
* @license MIT
* @category PHP Trait
* @version [1.2]
* @date     2017-10-55
*/
namespace App\Helper\Traits;

use Validator;

trait DataViewer {

  protected $dv_columns           = null;
  protected $dv_searchableColumns = [];

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
        $label = $key;
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

  /**
   * [mergeColumnsPaginate description]
   * @param  [type] $pagination [description]
   * @return [type]             [description]
   */
  private function mergeColumnsPaginate($pagination){
    return collect(['columns'=>$this->dv_columns])->merge($pagination);
  }

 /**
  * [gm - DataViewerData description]
  * @param [Illuminate\Http\Request]  $request  [required]
  * @param [Illuminate/Database/Query/Builder]  $query    [optional custom querybuilder]
  * @param boolean $paginate [default true]
  */
  public function DataViewerData($request, $query = null,$paginate = true) {
    $query = $this->loadQueryColumns($query);
    if (!$query)
    return null;
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

    $orderColumn    = $request->order_column ? $request->order_column : key($this->dv_columns);
    $orderDirection = $request->order_direction ? $request->order_direction : 'desc';
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

    // dd($query->toSql()); //if want see sql uncomment this line
    $query = $query->orderBy($orderColumn, $orderDirection);
    return $paginate ? $this->mergeColumnsPaginate($query->paginate($this->dv_pagination_limit ? $this->dv_pagination_limit : 5)) : $query;
  }
}
