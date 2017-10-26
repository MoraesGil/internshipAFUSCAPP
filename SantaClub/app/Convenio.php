<?php
namespace App;
use App\CustomModel;

class Convenio extends CustomModel {

  public function pessoa() {
    return $this->belongsTo('App\Pessoa');
  } 

}
