<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('home_team_id')->unsigned();
            $table->integer('visiting_team_id')->unsigned();
            $table->date('match_date');
            $table->tinyInteger('cancelled')->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('home_team_id')->references('id')->on('teams');
            $table->foreign('visiting_team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matches');
    }
}
