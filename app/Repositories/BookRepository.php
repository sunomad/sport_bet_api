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
    
    /**
     * Save a bet
     * 
     * @param array $data
     * @return boolean
     */
    public function saveBet($data)
    {
        $result = DB::insert("INSERT INTO `bets` (`transaction_id`, `match_id`, `user_id`, `match_date`, `amount`, `predicted_winner`) 
        (
       SELECT :transaction_id, m.id, u.id, :matchdate1, :betamount, t.id from matches m
       JOIN teams th on m.home_team_id = th.id
       JOIN teams tv on m.visiting_team_id = tv.id
       JOIN teams t on t.team_name = :predicted_winner
       JOIN users u on u.username = :username
       WHERE m.match_date = :matchdate2 AND th.team_name = :home_team_name AND tv.team_name = :visiting_team_name
       )", 
       [
            'transaction_id'     => $data['transaction_id'],
            'matchdate1'         => $data['match_date'],
            'betamount'          => $data['bet_amount'],
            'predicted_winner'   => $data['predicted_winner'],           
            'username'           => $data['username'],
            'matchdate2'         => $data['match_date'],
            'home_team_name'     => $data['home_team_name'],
            'visiting_team_name' => $data['visiting_team_name']
        ]);
        
        return $result;
    }
}

