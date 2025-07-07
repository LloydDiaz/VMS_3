<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TicketRange extends Model
{
    protected $fillable = [
        'user_id',
        'year',
        'start_number',
        'end_number',
        'current_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
