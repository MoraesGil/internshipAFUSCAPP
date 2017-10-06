<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()   {
        $faker = Factory::create();
         $model = new Categoria();

         foreach (range(1,10) as $i) {
           $model->create([
             'label'=>$faker->word,
             'descricao'=>$faker->text(20),
             'color'=>$faker->hexcolor,
           ]);
         }
    }
}
