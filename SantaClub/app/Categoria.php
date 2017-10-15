<?php

namespace App;

use App\CustomModel;
use App\Helper\Traits\DataViewer;

class Categoria extends CustomModel {
use DataViewer;
  protected $fillable = ['label','descricao','color'];
  public $timestamps = true;

  public function movimentos() {
    return $this->hasMany('App\Movimento');
  }

}
