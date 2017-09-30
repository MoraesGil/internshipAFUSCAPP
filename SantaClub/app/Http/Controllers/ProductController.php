<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use Exception;
class ProductController extends Controller
{
  public function __construct(Produto $produto){
    $this->produtoModel = $produto;
  }

  public function index() {
    $title = 'Cadastro de Produtos';
    $source = route('api.produto.index');

    return view('crud',compact(['title','source']));
  }

  public function getData(Request $request) {
       try {
         return response()->json([
           'pagination'   => $this->produtoModel->DataViewerData($request),
         ],200);
       } catch (Exception $e) {
         return response()->json([
           'message' => 'Informe o administrador do sistema',
           'errors'  => [encrypt(get_called_class().'-getData-'.$e->getMessage())]
         ], 500);
       }
  }


  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }


  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }
}
