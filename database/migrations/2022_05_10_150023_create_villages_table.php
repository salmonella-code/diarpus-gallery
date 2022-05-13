<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->string('regency');
            $table->string('district');
            $table->string('village');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->smallInteger('rw')->nullable();
            $table->smallInteger('rt')->nullable();
            $table->string('head_village')->nullable();
            $table->string('slug')->unique();
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
        Schema::dropIfExists('villages');
    }
}
