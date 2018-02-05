<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'vales';

    /**
     * Run the migrations.
     * @table vales
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('	');
            $table->integer('associado_id');
            $table->decimal('valor', 7, 2);
            $table->boolean('fechado')->default('0');
            $table->date('vencimento_em')->nullable();
            $table->dateTime('criado_em')->nullable();
            $table->dateTime('atualizado_em')->nullable();
            $table->dateTime('excluido_em')->nullable();

            $table->index(["associado_id"], 'fk_vales_associados1_idx');


            $table->foreign('associado_id', 'fk_vales_associados1_idx')
                ->references('pessoa_id')->on('associados')
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
