<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubdivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('subdivisions')) return;
        Schema::create('subdivisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

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
        Schema::dropIfExists('subdivisions');
    }
}
