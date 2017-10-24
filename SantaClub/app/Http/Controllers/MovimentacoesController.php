<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimento;
use Validator;
use Carbon\Carbon;
use App\Helper\Traits\ResourceTrait;

class MovimentacoesController extends Controller {
  use ResourceTrait;

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(Movimento $m) {
    $this->Model = $m;
    $this->indexView = 'movimentacoes';
    $this->resourceName = 'mov.movimentacoes';
    $this->pageTitle    = 'Movimentações';
  }

  /**
   * gm - Override default dataviwer paginate Resource trait
   *
   * @return \Illuminate\Http\Response
   */
  private function getData(Request $request){
    return response()->json(
      $this->Model->DataViewerData($request,$this->Model->movimentacoes()->with('categoria'),50,false)
      ,200
    );
  }

}
