<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Associado;
use App\Helper\Traits\ResourceTrait;

class AssociadoController extends Controller {
  use ResourceTrait;

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(Associado $m) {
    $this->Model        = $m;
    $this->indexView    = 'crud';
    $this->resourceName = 'ass.associados';
    $this->pageTitle    = 'Associados';
  }

  /**
  * gm - Override default dataviwer paginate Resource trait
  *
  * @return \Illuminate\Http\Response
  */
  private function getData(Request $request){
    $data = $this->Model->DataViewerData($request,$this->Model->tableData()); 
    return response()->json(
      $data
      ,200
    );
  }

}
