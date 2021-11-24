<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaintingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paintings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('direction_id')->constrained('directions');
            $table->foreignId('type_id')->constrained('types');
            $table->foreignId('author_id')->constrained('authors');
            $table->foreignId('owner_id')->constrained('owners');
            $table->foreignId('exposition_id')->constrained('expositions');
            $table->string('year')->nullable();
            $table->decimal('price')->nullable();
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
        Schema::dropIfExists('paintings');
    }
}
