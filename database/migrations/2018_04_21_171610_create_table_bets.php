<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unique();
            $table->integer('match_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->date('match_date');
            $table->decimal('amount');
            $table->integer('predicted_winner')->unsigned();  // relation to team_id
            $table->tinyInteger('cancelled')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('match_id')->references('id')->on('matches');
            $table->foreign('predicted_winner')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bets');
    }
}
