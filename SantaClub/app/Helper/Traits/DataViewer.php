<?php
namespace App\Helper\Traits;

use Validator;

trait DataViewer
{
  protected $searchColumns = [];

  protected $paginationLimitDefault = 5;

  private $validator_messages = [
    'column.in' => 'Nome de coluna inválida',
    'direction.in' => 'A direção precisa ser asc ou desc',
  ];

  public function DataViewerData($request){
    return collect(['columns'=>$this->getColumns()])->merge($this->scopeSearchPaginateAndOrder($request));
  }

  public function scopeSearchPaginateAndOrder($request)
  {
    $query = parent::newQuery();
    // dd($request->only([ 'column', 'direction' ]));
    $v =  Validator::make($request->only([
      'column',
      'direction',
      'search_term'
    ]), [
      'order_column' =>'nullable|alpha_dash|in:'.implode(',', $this->getOriginalTableColumns()),
      'order_direction'=>'nullable|in:asc,desc',
      'search_term'=>'nullable',
    ], $this->validator_messages);

    if ($v->fails()) {
      return $v->errors()->all();
    }

    //get exemplo ?order_column=med_id&order_direction=asc&search_term=sobrinho
    //set default
    $orderColumn = $request->order_column ? $request->order_column : head($this->getOriginalTableColumns());
    $orderDirection = $request->order_direction ? $request->order_direction : 'desc';
    $searchTerm = strtolower($request->search_term ? $request->search_term:"");
    $this->dataViewerConfig = isset($this->dataViewerConfig) ?    $this->dataViewerConfig : [];

    return
    $query->orWhere(function ($query) use ($searchTerm) {
      foreach ($this->getSearchableColumns() as $searchColumn) {
        //oracle
        // $query->orWhereRaw('LOWER(cast ('.$searchColumn.' as varchar(255))) like ?', ['%'.$searchTerm.'%']);
        //mysql
        $query->orWhere($searchColumn,'like', '%'.$searchTerm.'%');
      }
    })
    ->orderBy($orderColumn, $orderDirection)
    ->paginate($this->paginationLimitDefault);
    // dd($query->toSql());
  }

  public function getOriginalTableColumns()
  {
    if ($this->columnsCache && is_array($this->columnsCache)) {
      return $this->columnsCache;
    }
    $this->columnsCache = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    return $this->getOriginalTableColumns();
  }

  // [0=>label,1=searcheble]
  private function getSearchableColumns(){
    if (isset($this->dataViewerConfig) && is_array($this->dataViewerConfig)) {
      return array_keys(array_where($this->dataViewerConfig, function ($value, $key) {
        return isset($value[1]) && in_array($key,$this->getOriginalTableColumns())  ? $value[1] : false;
      }));
    }else {
      return [];
    }
  }

  private function getDataViwerColumnsAttribute()
  {
    return $this->getColumns();
  }

  private function getColumns()
  {
    $originalColumns = array_flip($this->getOriginalTableColumns());
    $arrayableItems = $this->getArrayableItems($originalColumns);
    $arrayableItems = array_merge($arrayableItems, $this->getArrayableAppends());

    //pega os labels
    foreach ($arrayableItems as $key => $value) {
      if (array_key_exists($key, $this->dataViewerConfig)) {
        $arrayableItems[$key] = $this->dataViewerConfig[$key][0] ? $this->dataViewerConfig[$key][0] : $key ;
      } else {
        $arrayableItems[$key] = $key;
      }
    }
    return $arrayableItems;
  }
}
