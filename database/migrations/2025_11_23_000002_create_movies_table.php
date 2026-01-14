<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('director');
            $table->year('release_year');
            $table->unsignedBigInteger('genre_id')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
