<?php

namespace App\Models;

use App\Models\User;
use App\Models\Match;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    public function match()
    {
        return $this->belongsTo(Match::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
