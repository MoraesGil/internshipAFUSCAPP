<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes
*
*/
namespace App\Helper\Traits;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Gate;

trait AcessResourceTrait {
  private function loadDataViewerOptionsAcl($request){
    $permId = Uuid::generate(3, $request->route()->getAction()['controller'], Uuid::NS_OID)->string;
        $rowOptions = [];
        $topOptions = [];
        if ($permId) {
            if (Gate::allows($permId,'insert')) {
                $topOptions[] = 'add';
            }
            if (Gate::allows($permId,'update')) {
                $rowOptions[] = 'edit';
            }
            if (Gate::allows($permId,'delete')) {
                $rowOptions[] = 'delete';
            }
        }
        $this->Model->setDataViewerRowOptions($rowOptions);
        $this->Model->setDataViewerTopOptions($topOptions);
    }
}
