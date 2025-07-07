<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Ticket;
use App\Models\TicketRange;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;




use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasFactory;
    use Notifiable;



    use LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'xname',
        'username',
        'email',
        'user_role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }



    protected static $logAttributes = [
        'lastname',
        'firstname',
        'middlename',
        'user_role',
        'user_name',
        'xname',
        'email',
        'password',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'lastname',
                'firstname',
                'middlename',
                'user_role',
                'user_name',
                'xname',
                'email',
                'password',
            ])
            ->logOnlyDirty();
    }
    public function scopeEnforcers($query)
    {
        return $query->where('user_role', 'enforcer');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_by', 'id');
    }
    public function ticketRanges()
    {
        return $this->hasMany(TicketRange::class, 'user_id', 'id');
    }

    public function issueTicketNumber(): int
    {
        $year = now()->year;

        // Only get ranges that are assigned to this user AND still have tickets left
        $range = $this->ticketRanges()
            ->where('year', $year)
            ->orderBy('start_number')
            ->get()
            ->first(function ($r) {
                return is_null($r->current_number) || $r->current_number < $r->end_number;
            });

        // If no available (not yet fully used) range, throw an error or handle accordingly
        if (!$range) {
            throw new \Exception("You must use all tickets in the current bundle before receiving a new one.");
        }

        $nextRaw = $range->current_number ? $range->current_number + 1 : $range->start_number;

        // Format ticket number: 202600001, 202600002, etc.
        $ticketNumber = (int)($year . str_pad($nextRaw, 5, '0', STR_PAD_LEFT));

        if (\App\Models\Ticket::where('tct_number', $ticketNumber)->exists()) {
            throw new \Exception("Ticket number {$ticketNumber} already used.");
        }

        $range->current_number = $nextRaw;
        $range->save();

        return $ticketNumber;
    }


    public function ticketRangeRequests()
    {
        return $this->hasMany(\App\Models\TicketRangeRequest::class);
    }
}
