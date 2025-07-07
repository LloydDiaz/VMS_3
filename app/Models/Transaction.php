<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Violation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'violation_id',
        'user_id',

    ];
    public function ticket()
    {

        return $this->belongsTo(Ticket::class);
    }
    public function violation()
    {

        return $this->hasOne(Violation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
