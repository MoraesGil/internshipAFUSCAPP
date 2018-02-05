<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'movimentos';

    /**
     * Run the migrations.
     * @table movimentos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('conta_id');
            $table->integer('categoria_id');
            $table->boolean('tipo_entrada')->comment('1 =  	entrada
0 = 	saida');
            $table->string('descricao');
            $table->decimal('valor', 7, 2);
            $table->date('dt_vencimento');
            $table->boolean('status')->default('0')->comment('se pago true');
            $table->text('obs')->nullable();
            $table->unsignedInteger('emitente_id');
            $table->integer('transferencia_id')->nullable();
            $table->integer('movimento_id')->nullable();
            $table->dateTime('criado_em')->nullable();
            $table->dateTime('atualizado_em')->nullable();
            $table->dateTime('excluido_em')->nullable();

            $table->index(["conta_id"], 'fk_movimentos_contas1_idx');

            $table->index(["emitente_id"], 'fk_movimentos_users1_idx');

            $table->index(["movimento_id"], 'fk_movimentos_movimentos1_idx');

            $table->index(["categoria_id"], 'fk_movimentos_categorias1_idx');

            $table->index(["transferencia_id"], 'fk_movimentos_transferencias1_idx');


            $table->foreign('emitente_id', 'fk_movimentos_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('conta_id', 'fk_movimentos_contas1_idx')
                ->references('id')->on('contas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('categoria_id', 'fk_movimentos_categorias1_idx')
                ->references('id')->on('categorias')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('transferencia_id', 'fk_movimentos_transferencias1_idx')
                ->references('id')->on('transferencias')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('movimento_id', 'fk_movimentos_movimentos1_idx')
                ->references('id')->on('movimentos')
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
