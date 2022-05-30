<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeterCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leter_c_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained('active_villages', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('register_number');
            $table->string('name');
            $table->text('address');
            $table->string('scan');
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
        Schema::dropIfExists('leter_c_s');
    }
}
