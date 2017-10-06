<?php

namespace App;

use App\CustomModel;

class Categoria extends CustomModel {

  protected $fillable = ['label','descricao','color'];
  public $timestamps = true;

  public function movimentos() {
    return $this->hasMany('App\Movimento');
  }

}
