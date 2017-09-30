<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Produto;

class ProdutosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
         $p = new Produto();

        foreach (range(1,100) as $i) {
          $p->create([
            'nome'=>$faker->word,
            'descricao'=>$faker->text(100),
            'preco'=>$faker->randomFloat(null,0.1,5000),
          ]);
        }
    }
}
