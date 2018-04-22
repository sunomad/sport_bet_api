<?php

namespace App\Models;

use App\Models\Bet;
use App\Models\Win;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matches';
    
    public function bets()
    {
        return $this->hasMany(Bet::class);
    }
    
    public function wins()
    {
        return $this->hasMany(Win::class);
    }
}

