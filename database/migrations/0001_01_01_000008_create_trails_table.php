<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->time('time'); // à vérifier et confirmer le type
            $table->text('description');
            $table->string('difficulty'); // Facile, Moyen, Difficile
            $table->boolean('is_accessible');
            $table->string('info_transport')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('img_id')->unsigned();
            $table->integer('location_start_id')->unsigned();
            $table->integer('location_end_id')->unsigned();
            $table->integer('location_parking_id')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('img_id')->references('id')->on('imgs')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('location_start_id')->references('id')->on('locations')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('location_end_id')->references('id')->on('locations')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('location_parking_id')->references('id')->on('locations')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trails');
    }
};
