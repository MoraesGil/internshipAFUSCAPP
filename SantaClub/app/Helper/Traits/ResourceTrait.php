<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes
* @copyright Copyright (c) 2017
* @category PHP Trait
* @version [1.0]
* @date     2017-10-10
* @license pt-BR Este software não e LIVRE, foi desenvolvido em 2017, por Gilberto Prudêncio Vaz de Moraes (moraesdev@gmail.com), ao qual pertencem e se resguardam todas as propriedades intelectuais.
*/
namespace App\Helper\Traits;

use Validator;
use Illuminate\Http\Request;

trait ResourceTrait {

  protected $indexView    = null;
  protected $formView     = null;
  protected $pageTitle    = null;
  protected $resourceName = null;


  /**
  * GM - Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request) {

    if ($request->ajax() || $request->isJson() || $request->get("json") !=null) {
      return $this->getData($request);
    }
    else {
      if (!$this->indexView) {
        dd('set index view');
      }
      if (!$this->resourceName) {
        dd('set resource name');
      }
      return view($this->indexView,['pageTitle'=>$this->pageTitle,'resourceName'=>$this->resourceName]);
    }
  }

  /**
  * GM - Retorna json de movimentacoes
  *
  * @return \Illuminate\Http\Response
  */
  private function getData(Request $request){
    return response()->json(
      $this->Model->DataViewerData($request)
      ,200
    );
  }

  /**
  * GM - Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * GM - Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }

  /**
  * GM - Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }

  /**
  * GM - Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }

  /**
  * GM - Update the specified resource in storage.
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
  * GM - Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }

}
