<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BudgetIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('budget_indicators')) return;
        Schema::create('budget_indicators', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->enum('type', ['income', 'expense']);

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
        Schema::dropIfExists('budgetIndicators');
    }
}
