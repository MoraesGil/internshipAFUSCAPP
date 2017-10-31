<?php

namespace App;
use App\CustomModel;

class Vale extends CustomModel {

  protected $fillable = ['id', 'nome', 'uf'];
  public $timestamps = true;

  protected $dates = ['vencimento_em', 'criado_em', 'atualizado_em', 'excluido_em', 'movimento_id'];

  protected $fillable = ['id', 'associado_id', 'valor', 'fechado', 'vencimento_em', 'criado_em', 'atualizado_em', 'excluido_em', 'movimento_id'];

  public function associado() {
    return $this->belongsTo('App\Associado');
  }

  public function convenios() {
    return $this->belongsToMany('App\Convenio');
  }

}
