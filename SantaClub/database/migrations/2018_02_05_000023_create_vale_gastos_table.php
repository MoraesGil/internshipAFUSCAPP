<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValeGastosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'vale_gastos';

    /**
     * Run the migrations.
     * @table vale_gastos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('convenio_id');
            $table->integer('vale_id');
            $table->decimal('valor', 7, 2);
            $table->date('usado_em');

            $table->index(["convenio_id"], 'fk_convenios_has_vales_convenios1_idx');

            $table->index(["vale_id"], 'fk_convenios_has_vales_vales1_idx');


            $table->foreign('convenio_id', 'fk_convenios_has_vales_convenios1_idx')
                ->references('pessoa_id')->on('convenios')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('vale_id', 'fk_convenios_has_vales_vales1_idx')
                ->references('id')->on('vales')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
