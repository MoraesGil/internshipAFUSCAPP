<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
* @copyright Copyright (c) 2017
* @category PHP Trait
* @version [1.0]
* @date     2017-10-10
* @license pt-BR Este software não e LIVRE, foi desenvolvido em 2017, por Gilberto Prudêncio Vaz de Moraes (moraesdev@gmail.com), ao qual pertencem e se resguardam todas as propriedades intelectuais.
*/
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

  /**
  * GM - Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request,$id) {
    $model = $this->Model->findOrFail($id)->pessoa()->delete();
    if ($request->expectsJson()) {
      return response()->json(null, 204);
    }else {
      Session::flash('success_message','Excluido!');
      return redirect()->route($this->resourceName.'.index');
    }
  }

}
