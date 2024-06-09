<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Img;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('img_path'); // surement pas nécessaire
            // $table->file('img');
            $table->string('source')->default('');
            $table->integer('interest_point_id')->unsigned()->nullable();

            $table->foreign('interest_point_id')->references('id')->on('interest_points')
                ->restrictOnDelete()
                ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // remove images from a folder
        $imgs = Img::all();
        foreach ($imgs as $img) {
            unlink(public_path($img->img_path));
        }
        Schema::dropIfExists('imgs');
    }
};
