<?php

namespace App;
use App\CustomModel;

class Fisica extends CustomModel {

  public $timestamps = true;

  protected $fillable = ['id','cpf','rg','data_nascimento'];

  protected $dates = ['data_nascimento'];

  public function pessoa() {
    return $this->belongsTo('App\Pessoa');
  }

}
