<?php

namespace App;
use App\CustomModel;
use App\Helper\Classes\BatmanBelt;
use Carbon\Carbon;

class PessoaFisica extends CustomModel {
  protected $table ='fisicas';

  protected $fillable = ['pessoa_id','cpf','rg','data_nascimento'];

  protected $dates = ['data_nascimento'];

  public function pessoa() {
    return $this->belongsTo('App\Pessoa');
  }

  public function setCpfAttribute($value) {
    $this->attributes['cpf'] = BatmanBelt::mask($value,'###.###.###-##');
  }


  public function getDataNascimentoAttribute($value) {
    $this->attributes['data_nascimento'] = Carbon::parse($value)->format('d/m/Y');
  }
   
  public function setDataNascimentoAttribute($value) {
    $this->attributes['data_nascimento'] = Carbon::createFromFormat('Y-m-d', $value)->toDateString();
  }



}
