<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_queries', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->string('nameExcelFile');
            $table->timestamps();

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->integer('ws');
            $table->string('query');
            $table->integer('wsk');
            $table->integer('numwords');

            $table->unsignedBigInteger('main_queries_id');

            $table->foreign('main_queries_id')->references('id')->on('main_queries');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_queries');
    }
}
