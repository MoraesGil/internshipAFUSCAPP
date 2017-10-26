<?php

namespace App;
use App\CustomModel;

class PessoaFisica extends CustomModel {
  protected $table ='fisicas';

  protected $fillable = ['pessoa_id','cpf','rg','data_nascimento'];

  protected $dates = ['data_nascimento'];

  public function pessoa() {
    return $this->belongsTo('App\Pessoa');
  }

}
