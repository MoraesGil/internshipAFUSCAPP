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
    return $this->hasOne('App\Convenio');
  }

  public function endereco() {
    return $this->hasOne('App\Endereco');
  }

  


  public static function associados($builder = false, $internos = null){
    if ($internos === null) {
      return $builder ? self::has('associado') : self::has('associado')->get();
    }
    $q = $internos ? self::whereHas('associado', function($q){ $q->where('cracha', '!=',null); }) :
    self::whereHas('associado', function($q){ $q->where('cracha',null); });
    return $builder ? $q : $q->get();
  }

  public static function convenios($builder = false){
    return $builder ? self::has('convenio') : self::has('convenio')->get();
  }

}
