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
        Schema::create('theme_trail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trail_id')->unsigned();
            $table->integer('theme_id')->unsigned();

            $table->foreign('trail_id')->references('id')->on('trails')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('theme_id')->references('id')->on('themes')
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
        Schema::dropIfExists('theme_trail');
    }
};
