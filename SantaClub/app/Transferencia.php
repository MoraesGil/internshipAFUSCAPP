<?php

namespace App;
use App\CustomModel;

class Transferencia extends CustomModel {

  public function movimentos() {
    return $this->hasMany('App\Movimento');
  }

}
