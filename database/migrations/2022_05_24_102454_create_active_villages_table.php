<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_villages', function (Blueprint $table) {
            $table->id();
            $table->string('village_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->smallInteger('rw')->nullable();
            $table->smallInteger('rt')->nullable();
            $table->string('head_village')->nullable();
            $table->timestamps();
            
            $table->foreign('village_id')->nullOnDelete()->cascadeOnUpdate()->references('id')->on('villages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_villages');
    }
}
