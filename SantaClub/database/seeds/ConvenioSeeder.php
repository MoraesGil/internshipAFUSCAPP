<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Pessoa;
use App\Convenio;

class ConvenioSeeder extends Seeder {
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()   {

    $faker = Factory::create();

    // $filepath = storage_path('avatars');
    //
    // if(!File::exists($filepath)){
    //   File::makeDirectory($filepath);
    // }

    $model = new Pessoa();




    foreach (range(1,50) as $i) {
      DB::beginTransaction();
      try {

        $pes = $model->create([
          'nome'    => $faker->name,
          'apelido' => $faker->firstName,
          'ativo'   => $faker->boolean(98),
          ])->pessoaJuridica()->create([
            'cnpj'=>$faker->numerify($string = '##############'),
            'insc_estadual'=>$faker->numerify($string = '############'),
            'insc_municipal'=>$faker->numerify($string = '############')
            ])->pessoa;

            $pes->convenio()->create([]);

            DB::commit();
          } catch (Exception $e) {
            dump('rollback');
            DB::rollback();
          }

        }
      }

    }
