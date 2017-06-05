<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExperimentBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('experiment_budget')) return;
        Schema::create('experiment_budget', function (Blueprint $table) {
            $table->increments('id');

            /* references */
            $table->integer('experiment_id')->unsigned();
            $table->foreign('experiment_id')
                ->references('id')
                ->on('experiments')
                ->onDelete('cascade');
            $table->integer('budget_id')->unsigned();
            $table->foreign('budget_id')
                ->references('id')
                ->on('budgets')
                ->onDelete('cascade');
            /* end of references */

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
        Schema::dropIfExists('experiment_budget');
    }
}
