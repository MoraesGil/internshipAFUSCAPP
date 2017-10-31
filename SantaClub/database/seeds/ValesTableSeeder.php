<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Pessoa;

class ValesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()   {
      $faker = Factory::create();
      try {
        foreach (Pessoa::associados() as $index => $pes) {
          $pes->vales()->updateOrCreate(
            [
              'id'=>$index
            ],[
              'id'=>$index,
              'logradouro'=> $faker->streetName.' nº'.$faker->numberBetween(1,5000),
              'bairro'=>$faker->streetName,
              'cep'=>$faker->numerify($string = '########'),
              'complemento'=>$faker->word,
              'cidade_id'=>Cidade::limit(1)->skip($faker->numberBetween(1,Cidade::count()))->pluck('id')[0]
            ]
          );
        }
      } catch (Exception $e) {
        dump('falha ao criar endereços');
        dump($e->getMessage());
      }


    }
}
