<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->bigInteger('user_id', false, true)->default(0);
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('paragraphs', function (Blueprint $table) {
            $table->id('paragraph_id');
            $table->foreignId('document_id');
            $table->integer('order');
            $table->text('primary_argument');
            $table->text('supporting_arguments');
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
        Schema::dropIfExists('documents');
        Schema::dropIfExists('paragraphs');
    }
};
