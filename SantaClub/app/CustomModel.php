<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class CustomModel extends Model {
  public $timestamps = false;

  protected $hidden = [
    'criado_em',
    'atualizado_em',
    'excluido_em',
  ];

  const CREATED_AT = 'criado_em';
  const UPDATED_AT = 'atualizado_em';
  const DELETED_AT = 'excluido_em';

  public $errors;

  public function hasRules(){
    return isset($this->rules) && is_array($this->rules);
  }

  public function validate($data,$id = null) {
    $id = $id ? $id : 'NULL';
    $this->rules = json_encode($this->rules);
    $this->rules = str_replace('@except',$id,$this->rules);
    $this->rules = json_decode($this->rules,true);

    $validator = Validator::make($data, $this->rules);
     if ($validator->fails()) {
      $this->errors = $validator->errors();
      return false;
    }
    return true;
  }

}
