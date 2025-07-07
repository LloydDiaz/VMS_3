<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;



class Violation extends Model
{

    use LogsActivity;

    protected static $logAttributes = [
        'violation_type',
        'amount',
    ];


    use HasFactory;
    protected $fillable = [
        'violation_type',
        'amount',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'violation_type',
                'amount',
            ])
            ->logOnlyDirty();
    }
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_violation', 'violation_id', 'ticket_id');
    }
}
