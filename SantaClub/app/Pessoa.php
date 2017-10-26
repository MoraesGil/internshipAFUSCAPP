<?php

namespace App;
use App\CustomModel;

class Pessoa extends CustomModel {

  protected $fillable = ['nome', 'apelido', 'foto', 'ativo'];
  protected $dates = ['criado_em','excluido_em','dt_vencimento'];

  public $timestamps = true;

  public function pessoaFisica() {
    return $this->hasOne('App\PessoaFisica');
  }

  public function pessoaJuridica() {
    return $this->hasOne('App\PessoaJuridica');
  }

  public function associado() {
    return $this->hasOne('App\Associado');
  }

  public function convenio() {
    return $this->hasOne('App\Associado');
  }

  public static function associados($builder = false){
    return $builder ? self::has('associado') : self::has('associado')->get();
  }

  public static function convenios($builder = false){
    return $builder ? self::has('convenio') : self::has('convenio')->get();
  }

}
