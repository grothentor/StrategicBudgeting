<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BudgetsValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('budgets_values')) return;
        Schema::create('budget_values', function (Blueprint $table) {
            $table->increments('id');
            $table->float('value');

            /* references */
            $table->integer('budget_id')->unsigned();
            $table->foreign('budget_id')
                ->references('id')
                ->on('budgets')
                ->onDelete('cascade');

            $table->integer('budget_indicator_id')->unsigned();
            $table->foreign('budget_indicator_id')
                ->references('id')
                ->on('budget_indicators');
            /* end of references*/

            $table->enum('periodicity', ['once', 'monthly', 'quarterly', 'annually']);
            $table->integer('offset')->unsigned();
            $table->integer('use_length')->nullable();
            $table->boolean('pay_at_end')
                ->default(false);

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
        //
    }
}
