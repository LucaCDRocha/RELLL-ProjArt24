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
        Schema::create('interest_points', function (Blueprint $table) {
            $table->increments('id');
            // $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'));
            $table->string('name');
            $table->text('description');
            $table->text('url');
            $table->string('open_season');
            $table->integer('location_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->foreign('location_id')->references('id')->on('locations')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('tag_id')->references('id')->on('tags')
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
        Schema::dropIfExists('interest_points');
    }
};
