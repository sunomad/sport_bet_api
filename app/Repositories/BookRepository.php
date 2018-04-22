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
     * Saves multiple bets
     * 
     * @param array $data
     * @return boolean
     */
    public function saveMultipleBets($data)
    {
        $statement = "INSERT INTO `bets` (`transaction_id`, `match_id`, `user_id`, `match_date`, `amount`, `predicted_winner`) ";
        
        $params = [];
        $number_of_bets = count($data);
        for ($i = 0; $i < $number_of_bets; $i++) {
            $statement .= "(
                    SELECT :transaction_id{$i}, m.id, u.id, :matchdate1{$i}, :betamount{$i}, t.id from matches m
                    JOIN teams th on m.home_team_id = th.id
                    JOIN teams tv on m.visiting_team_id = tv.id
                    JOIN teams t on t.team_name = :predicted_winner{$i}
                    JOIN users u on u.username = :username{$i}
                    WHERE m.match_date = :matchdate2{$i} AND th.team_name = :home_team_name{$i} AND tv.team_name = :visiting_team_name{$i}
                )";
                    
            $params['transaction_id' . $i]     = $data[$i]['transaction_id'];
            $params['matchdate1' . $i]         = $data[$i]['match_date'];
            $params['betamount' . $i]          = $data[$i]['bet_amount'];
            $params['predicted_winner' . $i]   = $data[$i]['predicted_winner'];
            $params['username' . $i]           = $data[$i]['username'];
            $params['matchdate2' . $i]         = $data[$i]['match_date'];
            $params['home_team_name' . $i]     = $data[$i]['home_team_name'];
            $params['visiting_team_name' . $i] = $data[$i]['visiting_team_name'];
            
            if($i < $number_of_bets - 1) {
                $statement .= ' UNION ';
            }
        }
        
        $result = DB::insert($statement, $params);
        
        return $result;
    }
}

