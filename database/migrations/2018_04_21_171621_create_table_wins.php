<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unique();
            $table->integer('match_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('match_date');
            $table->decimal('amount');
            $table->decimal('balance');
            $table->integer('predicted_winner');  // relation to team_id
            $table->tinyInteger('cancelled')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('match_id')->references('id')->on('matches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wins');
    }
}
