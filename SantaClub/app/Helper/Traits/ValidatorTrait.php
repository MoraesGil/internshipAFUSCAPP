<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
* @copyright Copyright (c) 2017
* @category PHP Trait
* @version [1.0]
* @date     2017-01-22
* @license pt-BR Este software não e LIVRE, foi desenvolvido em 2017, por Gilberto Prudêncio Vaz de Moraes (moraesdev@gmail.com), ao qual pertencem e se resguardam todas as propriedades intelectuais.
*/
namespace App\Helper\Traits;

use Validator;

trait ValidatorTrait {
  public $errors;

  public function hasRules(){
    return isset($this->rules) && is_array($this->rules);
  }

  public function validate($data, $id = null) {
    #this section is for except update rule dinamicly.
    $id = $id ? $id : 'NULL';
    $this->rules = json_encode($this->rules);
    $this->rules = str_replace('@except',$id,$this->rules);
    $this->rules = json_decode($this->rules,true);
    #end secion

    $this->custom_messages = isset($this->custom_messages) ? $this->custom_messages : [];
    $this->attributeNames = isset($this->attributeNames) ? $this->attributeNames : [];

    $validator = Validator::make($data, $this->rules, $this->custom_messages);

    $validator->setAttributeNames($this->attributeNames);

     if ($validator->fails()) {
      $this->errors = $validator->errors();
      return false;
    }
    return true;
  }
}
