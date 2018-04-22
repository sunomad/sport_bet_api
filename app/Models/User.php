<?php

namespace App\Models;

use App\Models\Bet;
use App\Models\Win;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['balance', 'active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    
    public function bets()
    {
        return $this->hasMany(Bet::class);
    }
    
    public function wins()
    {
        return $this->hasMany(Win::class);
    }
}
