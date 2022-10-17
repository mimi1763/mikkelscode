<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->string('isbn');
            $table->unsignedSmallInteger('series_number')->nullable();
            $table->unsignedSmallInteger('published_year')->nullable();
            $table->unsignedSmallInteger('page_count')->nullable();
            $table->unsignedSmallInteger('series_id')->nullable();
            $table->unsignedSmallInteger('country_id')->nullable();
            $table->unsignedSmallInteger('language_id')->nullable();
            $table->unsignedSmallInteger('translated_language_id')->nullable();
            $table->unsignedSmallInteger('author_id')->nullable();
            $table->unsignedSmallInteger('artist_id')->nullable();
            $table->unsignedSmallInteger('publisher_id')->nullable();
            $table->unsignedSmallInteger('translator_id')->nullable();
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
        Schema::dropIfExists('comics');
    }
}
