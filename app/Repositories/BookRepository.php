<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class BookRepository
{
    /**
     * Get a book
     * 
     * @param string $match_date
     * @param string $home_team_name
     * @param string $visiting_team_name
     * @return array
     */
    public function getBook($match_date, $home_team_name, $visiting_team_name)
    {
        $book = DB::table('bets')
                ->select('users.username', 'bets.amount', 't.team_name as predicted_winner')
                ->join('users', 'bets.user_id', '=', 'users.id')
                ->join('matches', 'bets.match_id', '=', 'matches.id')
                ->join('teams as t', 'bets.predicted_winner', '=', 't.id')
                ->join('teams as th', 'matches.home_team_id', '=', 'th.id')
                ->join('teams as tv', 'matches.visiting_team_id', '=', 'tv.id')
                ->where('matches.match_date', '=', $match_date)
                ->where('th.team_name', '=', $home_team_name)
                ->where('tv.team_name', '=', $visiting_team_name)
                ->get();
        
        return $book;
    }
}

