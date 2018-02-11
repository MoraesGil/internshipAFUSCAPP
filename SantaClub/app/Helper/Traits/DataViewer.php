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

trait DataViewer
{
    private $dv_columns           = null;
    private $dv_searchableColumns = [];
    private $rowOptions = ['edit','delete'];
    private $topOptions = ['add'];

    /**
    * [gm - loadQueryColumns]
    * This load coumuns and searchable columns from query first result,
    * and protected dv_config [name:string,label:string,search:boolean]
    *
    * @param  [Illuminate/Database/Query/Builder] $query
    * @return [Boolean]
    */
    private function loadQueryColumns($query, $loadSearchables = true)
    {
        if (!$query) {
            $query = parent::newQuery();
        }
        $first = $query->first();
        if ($first) {
            $dvConfig = [];
            if (isset($this->dv_config) && is_array($this->dv_config)) {
                $dvConfig = $this->dv_config;
            }
            $this->dv_columns = collect($first)->map(function ($val, $key) use ($dvConfig,$loadSearchables) {
                $label = str_replace('_', ' ', title_case($key));
                foreach ($dvConfig as $value) {
                    if (isset($value["name"]) && $value["name"] == $label) {
                        if (isset($value["label"])) {
                            $label = $value["label"];
                        }
                        if ($loadSearchables && isset($value["search"]) && $value["search"] == true && !in_array($key, $this->dv_searchableColumns)) {
                            $this->dv_searchableColumns[]= $key;
                        }
                    }
                }
                return $label;
            })->toArray();
            return $query;
        }
        return false;
    }


    private function loadConfigColumns()
    {
        foreach ($this->dv_config as $config) {
            foreach ($config as $key => $value) {
                if (isset($config['name'])) {
                    $this->dv_columns[$config['name']] = isset($config["label"]) ? $config["label"] : str_replace('_', ' ', title_case($config['name']));
                    if (isset($config["search"]) && $config["search"] == true && !in_array($config['name'], $this->dv_searchableColumns)) {
                        $this->dv_searchableColumns[]= isset($config['prefix']) ? $config['prefix'].'.'.$config['name'] : $config['name'];
                    }
                }
            }
        }
    }

    /**
    * [sort_columns Order result data by config order]
    * @param  [Array] $columns [description]
    * @return [Array]          [FORMATED ARRAY]
    */
    private function sort_columns($columns)
    {
        if (is_array($this->dv_config) && count($this->dv_config)>0) {
            $configColumns = collect($this->dv_config)->pluck('name')->filter(function ($value, $key) {
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
    public function mergeDataViwerExtraColumns($pagination)
    {
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
    public function dataViewerData($request, $query = null, $paginate = 15, $mergeColumns = true)
    {
        if (!isset($this->dv_config) || $this->dv_config === []) {
            $this->loadQueryColumns($query);
        } else {
            $this->loadConfigColumns();
        }
        $plimit = $request->get('plimit');

        $paginate = $plimit ? $plimit : $paginate;

        if (!$query) {
            $query = parent::newQuery();
        }
        $db_driver = $query->getConnection()->getDriverName();

        $searchTerm     = strtolower($request->search_term ? $request->search_term:"");

        if ($searchTerm !="") {
            $query = $query->where(function ($q) use ($searchTerm,$db_driver) {
                foreach ($this->dv_searchableColumns as $searchColumn) {
                    switch ($db_driver) {
                      case 'pgsql':
                        $q->orWhereRaw('LOWER(CAST('.$searchColumn.' as text)) like ?', ['%'.$searchTerm.'%']);
                      break;

                      case 'mysql':
                        $q->orWhereRaw('LOWER('.$searchColumn.') like ?', ['%'.$searchTerm.'%']);
                      break;

                      default:
                      dd('undefined driver');
                      break;
                  }
                }
            });
        }
        if ($request->order_column && $request->order_direction) {
            $query = $query->orderBy($request->order_column, $request->order_direction);
        }
        // dd($query->toSql()); //uncoment this to see sql
        return $paginate && $mergeColumns ? $this->mergeDataViwerExtraColumns($query->paginate($paginate)) : $query;
    }

    public function dataViewerOptions(){
        return [
            'row' => $this->rowOptions,
            'top' => $this->topOptions
        ];
    }

    public function setDataViewerRowOptions($array){
        $this->rowOptions = $array;
    }
    public function setDataViewerTopOptions($array){
        $this->topOptions = $array;
    }



}
