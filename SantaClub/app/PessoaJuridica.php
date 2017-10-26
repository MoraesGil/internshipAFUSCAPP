<?php

namespace App;
use App\CustomModel;

class PessoaJuridica extends CustomModel {
  protected $table ='juridicas';

  protected $fillable = ['pessoa_id', 'cnpj', 'insc_estadual', 'insc_municipal'];
 
  public function pessoa() {
    return $this->belongsTo('App\Pessoa');
  }

}
