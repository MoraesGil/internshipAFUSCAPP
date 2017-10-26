<?php
namespace App;
use App\CustomModel;

class Associado extends CustomModel {

  protected $fillable = ['cracha'];

  public function pessoa() {
    return $this->belongsTo('App\Pessoa');
  }

  public function padrinho() {
    return $this->belongsTo('App\Associado');
  }



}
