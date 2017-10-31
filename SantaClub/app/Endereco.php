<?php

namespace App;
use App\CustomModel;
use App\Helper\Traits\DataViewer;
class Endereco extends CustomModel {
  use DataViewer;

  protected $fillable = ['pessoas_id', 'logradouro', 'bairro', 'cep', 'cidade', 'complemento'];

  // protected $dv_config = [
  //   [
  //     'label' => 'Cód',
  //     'name' => 'id',
  //     'search' => true
  //   ],
  //   [
  //     'label' => 'Descrição',
  //     'name' => 'descricao',
  //     'search' => true
  //   ],
  //   [
  //     'label' => 'Título',
  //     'name' => 'label',
  //     'search' => true
  //   ],
  // ]; 

}
