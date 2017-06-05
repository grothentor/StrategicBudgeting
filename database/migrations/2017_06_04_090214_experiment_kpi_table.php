<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExperimentKpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('experiment_kpi')) return;
        Schema::create('experiment_kpi', function (Blueprint $table) {
            $table->increments('id');

            /* references */
            $table->integer('experiment_id')->unsigned();
            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments')
                ->onDelete('cascade');
            $table->integer('kpi_id')->unsigned();
            $table->foreign('kpi_id')
                ->references('id')
                ->on('kpis')
                ->onDelete('cascade');
            /* end of references */

            $table->double('target_value');
            $table->double('result_value')->nullable();
            $table->double('importance')->nullable();
            $table->boolean('use')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experiment_kpi');
    }
}
