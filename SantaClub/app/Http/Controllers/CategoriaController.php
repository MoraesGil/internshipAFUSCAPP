<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Helper\Traits\ResourceTrait;

class CategoriaController extends Controller {
use ResourceTrait;
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct(Categoria $m) {
    $this->Model = $m;
  }



}
