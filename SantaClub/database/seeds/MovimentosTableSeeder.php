<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Conta;
use App\Categoria;
use App\Movimento;
use App\User;
use App\Transferencia;

use Carbon\Carbon;

class MovimentosTableSeeder extends Seeder {
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()   {
    $faker         = Factory::create();
    $model         = new Movimento();
    $transferencia = new Transferencia;

    $usuario       = User::first();
    $contas        = Conta::all();
    $conLen        = count($contas)-1;
    $categorias    = Categoria::all();
    $catLen        = count($categorias)-1;

    Carbon::setLocale('pt_BR'); // Ajusta o idioma para português do Brasil

    $date       = Carbon::now();
    $vencimento = $faker->boolean($faker->numberBetween(0,100)) ? $date->addDays(rand(1, 300)) : $date->subDays(rand(1, 50));

    foreach (range(1,5000) as $i) {
      if ($faker->boolean(30)) {
        $vencimento = $faker->boolean($faker->numberBetween(0,100)) ? $date->addDays(rand(1, 300)) : $date->subDays(rand(1, 50));
      }

      $data = [
        'conta_id'         => $contas[$faker->numberBetween(0,$conLen)]->id,
        'categoria_id'     => $categorias[$faker->numberBetween(0,$catLen)]->id,
        'emitente_id'      => $usuario->id,
        'tipo_entrada'     => $faker->boolean(50),
        'descricao'        => $faker->text(20),
        'valor'            => $faker->randomFloat(2,0.1,5000),
        'dt_vencimento'    => $vencimento,
        'status'           => $faker->boolean(50),
        'obs'              => $faker->text(20),

        // 'transferencia_id'  => $faker,
        // 'movimento_id'     => $faker,
      ];

      if ($faker->boolean(95)) {

        $mov = $model->create($data);

        if (!$mov->status && $faker->boolean(95)) { //parcial re
          $data["status"] = true;
          foreach (range(1,3) as $b) {
            $limit =  ($mov->valor*0.9) - $mov->total_parcial; // limit 80%
            $parcialValue = $faker->randomFloat(2,0.01,$limit); //get random parcial value by limit
            $data["valor"] = $parcialValue;
            $data["descricao"] = "Parcial ".$b." - ".$mov->descricao;
            $mov->parciais()->create($data);
          }
        }
      }else {
        // trasnferencia
        $data["transferencia_id"] = $transferencia::create()->id;
        $data["descricao"] = "Transf".$data["transferencia_id"]." - ".$data["descricao"];
        $data["status"] = true;

        $destino;
        //saida
        $data["tipo_entrada"] = true;
        $model->create($data);

        do {
          $destino = $contas[$faker->numberBetween(0,$conLen)]->id;
        } while ($destino == $data["conta_id"]);

        //entrada
        $data["categoria_id"] = $destino;
        $data["tipo_entrada"] = false;
        $model->create($data);
      }

    }
  }
}
