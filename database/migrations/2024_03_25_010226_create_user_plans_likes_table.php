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
        Schema::create('user_plans_likes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('product_id');
            $table->tinyInteger('like')->comment('1=lik 0=dislike');
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
        Schema::dropIfExists('user_plans_likes');
    }
};
