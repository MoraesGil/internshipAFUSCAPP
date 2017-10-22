<?php

namespace App;
use App\CustomModel;

class Pessoa extends CustomModel {


  protected $fillable = ['nome', 'apelido', 'foto', 'ativo'];
  protected $dates = ['criado_em','excluido_em','dt_vencimento'];
  
  public $timestamps = true;

  public function documentos_pf() {
    return $this->hasOne('App\PessoaFisica');
  }


}
