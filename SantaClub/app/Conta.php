<?php

namespace App;
use App\CustomModel;

class Conta extends CustomModel {

  protected $fillable = ['descricao','label'];
  public $timestamps = true;


  public function movimentos() {
    return $this->hasMany('App\Movimento');
  }

}
