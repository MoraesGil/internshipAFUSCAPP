<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimento;
use Validator;
use Carbon\Carbon;

class MovimentacoesController extends Controller {

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(Movimento $m) {
    $this->middleware('auth');
    $this->Model = $m;
  }

  /**
  * Abre a pagina de movimentações.
  *
  * @return \Illuminate\Http\Response
  */
  public function index() {
    return view('home');
  }

  /**
  * Retorna json de movimentacoes
  *
  * @return \Illuminate\Http\Response
  */
  public function getData(Request $request){ 
    return response()->json(
      $this->Model->DataViewerData($request,$this->Model->movimentacoes()->with('categoria'),null,false)
      ,200
    );
  }
}
