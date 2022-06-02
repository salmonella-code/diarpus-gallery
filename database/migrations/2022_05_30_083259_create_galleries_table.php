<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->constrained('users', 'id')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreignId('field_id')
                    ->nullable()
                    ->constrained('fields', 'id')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreignId('active_village_id')
                    ->nullable()
                    ->constrained('active_villages', 'id')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->enum('category', ['photo','video']);
            $table->text('description');
            $table->date('activity');
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
        Schema::dropIfExists('galleries');
    }
}
