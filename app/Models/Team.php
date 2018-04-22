<?php

namespace App\Models;

use App\Models\Match;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function matches()
    {
        return $this->hasMany(Match::class);
    }
}
