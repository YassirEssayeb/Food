<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('menu_item_name');
            $table->string('user_name');
            $table->text('comment');
            $table->integer('rating')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_reviews');
    }
};
