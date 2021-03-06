<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
* @copyright Copyright (c) 2017
* @category PHP Trait
* @version [1.0]
* @date     2017-10-10
* @license pt-BR Este software não e LIVRE, foi desenvolvido em 2017, por Gilberto Prudêncio Vaz de Moraes (moraesdev@gmail.com), ao qual pertencem e se resguardam todas as propriedades intelectuais.
*/
namespace App\Helper\Traits;

use Validator;
use Session;
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
    if ($request->expectsJson() || $request->get("json") !=null) {
      return $this->getData($request);
    }
    else {
      if (!$this->indexView) {
        dd('set index view');
      }
      if (!$this->resourceName) {
        dd('set resource name');
      }
      return view($this->indexView,[
        'pageTitle'         => $this->pageTitle,
        'resourceName'      => $this->resourceName,
        'dataViewerOptions' => $this->Model->dataViewerOptions(),
      ]);
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
  public function store(Request $request) {
    if ($this->Model->hasRules()) {
      if (!$this->Model->validate($request->all())) {
        if ($request->expectsJson()) {
          return response()->json($this->Model->errors, 400);
        }
        return redirect()->route($this->resourceName.'.index')->withErrors($this->Model->errors);
      }
    }
    $new = $this->Model->create($request->all());

    if ($request->expectsJson()) {
      return response()->json($new, 201);
    }else {
      Session::flash('success_message','Cadastrado realizado!');
      return redirect()->route($this->resourceName.'.index');
    }
  }

  /**
  * GM - Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id) {
    $model = $this->Model->findOrFail($id);
    return  $model;
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
  public function update(Request $request, $id) {
    if ($this->Model->hasRules()) {
       if (!$this->Model->validate($request->all(),$id)) {
         if ($request->expectsJson()) {
           return response()->json($this->Model->errors, 400);
         }
         return redirect()->route($this->resourceName.'.index')->withErrors($this->Model->errors);
       }
    }

    $model = $this->Model->findOrFail($id)->update($request->all());

    if ($request->expectsJson()) {
      return response()->json($model, 200);
    }else {
      Session::flash('success_message','Atualizado!');
      return redirect()->route($this->resourceName.'.index');
    }

  }

  /**
  * GM - Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request,$id) {
    $model = $this->Model->findOrFail($id)->delete();
    if ($request->expectsJson()) {
      return response()->json(null, 204);
    }else {
      Session::flash('success_message','Excluido!');
      return redirect()->route($this->resourceName.'.index');
    }
  }


}
