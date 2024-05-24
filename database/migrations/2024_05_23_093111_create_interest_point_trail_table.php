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
        Schema::create('interest_point_trail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interest_point_id')->unsigned();
            $table->integer('trail_id')->unsigned();

            $table->foreign('interest_point_id')->references('id')->on('interest_points')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('trail_id')->references('id')->on('trails')
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
        Schema::dropIfExists('interest_point_trail');
    }
};
