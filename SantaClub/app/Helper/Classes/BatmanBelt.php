<?php
/*
* @author Gilberto Prudêncio Vaz de Moraes
* @copyright Copyright (c) 2017
* @category PHP Trait
* @version [1.0]
* @date     2017-25-10
* @license pt-BR Este software não e LIVRE, foi desenvolvido em 2017, por Gilberto Prudêncio Vaz de Moraes (moraesdev@gmail.com), ao qual pertencem e se resguardam todas as propriedades intelectuais.
*/
namespace App\Helper\Classes;

Class BatmanBelt {

  const HEX_PATTERN = "^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$";

 
  // http://blog.clares.com.br/php-mascara-cnpj-cpf-data-e-qualquer-outra-coisa/
  public static function mask($val, $mask) {
    $val = str_replace(".","",$val);
    $val = str_replace("-","",$val);

    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++)
    {
      if($mask[$i] == '#')
      {
        if(isset($val[$k]))
        $maskared .= $val[$k++];
      }
      else
      {
        if(isset($mask[$i]))
        $maskared .= $mask[$i];
      }
    }

    return $maskared;
  }

}
