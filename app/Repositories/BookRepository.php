<?php

namespace App\Repositories;

use App\Models\Bet;
use App\Models\User;
use App\Models\Team;
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
    
    /**
     * Save a bet
     * 
     * @param array $data
     * @return boolean
     */
    public function saveBet($data)
    {
        $match = Db::table('matches')->select('matches.id')->where('match_date', $data['match_date'])
                ->join('teams as th', 'matches.home_team_id', '=', 'th.id')
                ->join('teams as tv', 'matches.visiting_team_id', '=', 'tv.id')
                ->where('th.team_name', $data['home_team_name'])
                ->where('tv.team_name', $data['visiting_team_name'])
                ->first();
        
        $bet = new Bet();
        $bet->match_id         = $match->id;
        $bet->user_id          = User::where('username', $data['username'])->first()->id;
        $bet->match_date       = $data['match_date'];
        $bet->amount           = $data['bet_amount'];
        $bet->predicted_winner = Team::where('team_name', $data['predicted_winner'])->first()->id;
        
        return $bet->save();
    }
}

