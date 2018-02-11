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
  
}
