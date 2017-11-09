<?php
namespace App;
use App\CustomModel;


class Associado extends CustomModel {
  
  protected $fillable = ['cracha'];
  protected $primaryKey = 'pessoa_id';

  public function pessoa() {
    return $this->belongsTo('App\Pessoa','pessoa_id','id');
  }

  public function padrinho() {
    return $this->belongsTo(Associado::class,'padrinho_id','pessoa_id');
  }

  public function vales() {
    return $this->hasMany('App\Vales');
  }

}
