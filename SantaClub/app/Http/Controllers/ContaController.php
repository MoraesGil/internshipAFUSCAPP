<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\Helper\Traits\ResourceTrait;

class ContaController extends Controller {
use ResourceTrait;
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(Conta $m) {
    $this->Model        = $m;
    $this->indexView    = 'crud';
    $this->resourceName = 'con.contas';
    $this->pageTitle    = 'Contas';
  }
}
