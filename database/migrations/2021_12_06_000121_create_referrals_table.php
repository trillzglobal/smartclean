<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ref1');
            $table->unsignedBigInteger('ref2')->nullable();
            $table->unsignedBigInteger('ref3')->nullable();
            $table->unsignedBigInteger('ref4')->nullable();
            $table->unsignedBigInteger('ref5')->nullable();
            $table->unsignedBigInteger('ref6')->nullable();
            $table->unsignedBigInteger('ref7')->nullable();
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
        Schema::dropIfExists('referrals');
    }
}
