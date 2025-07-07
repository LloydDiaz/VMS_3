<?php

namespace App\Models;



use App\Models\Transaction;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ticket extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    use LogsActivity;

    protected static $logAttributes = [
        'tct_number',
        'tct_date',
        'tct_time',
        'fname',
        'lname',
        'mname',
        'xname',
        'dob',
        'house_number',
        'street',
        'region',
        'municipality',
        'province',
        'barangay',
        'description',
        'violation_details',

        // 'plate_number',
        // 'place_of_citation',
        // 'mv_reg_number',
        // 'mv_type',
        // 'engine_number',
        // 'chasis_number',
        // 'con_item',
        // 'status',
        // 'is_canceled',
        // 'license_number',
        
        'ticket_by',
        'place_of_citation',
        'owner_vehicle',
        'date_pay',
        'or_number',
        'amount_pay',
        'deleted_at',
    ];


     protected $casts = [
        'fname' => "encrypted",
        'lname' => "encrypted",
        'mname' => "encrypted",
        'xname' => "encrypted",
        'violation_details' => 'encrypted:array',
    ];


    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
        'tct_number',
        'tct_date',
        'tct_time',
        'fname',
        'lname',
        'mname',
        'xname',
        'dob',
        'house_number',
        'street',
        'region',
        'municipality',
        'province',
        'barangay',
        'description',
        'vioaltion_details',
        'status',

        // 'plate_number',
        // 'place_of_citation',
        // 'mv_reg_number',
        // 'mv_type',
        // 'engine_number',
        // 'chasis_number',
        // 'con_item',
        // 'status',
        // 'is_canceled',
        // 'license_number',
        
        'ticket_by',
        'place_of_citation',
        'owner_vehicle',
        'date_pay',
        'or_number',
        'amount_pay',
        'deleted_at',

    ];

    public function getActivitylogOptions(): LogOptions

    {
        return LogOptions::defaults()

            ->logOnly([
                'tct_number',
                'tct_date',
                'tct_time',
                'fname',
                'lname',
                'mname',
                'xname',
                'dob',
                'house_number',
                'street',
                'region',
                'municipality',
                'province',
                'barangay',
                'description',
                'vioaltion_details',

            // 'plate_number',
            // 'place_of_citation',
            // 'mv_reg_number',
            // 'mv_type',
            // 'engine_number',
            // 'chasis_number',
            // 'con_item',
            // 'status',
            // 'is_canceled',
            // 'license_number',
        
                'ticket_by',
                'place_of_citation',
                'owner_vehicle',
                'date_pay',
                'or_number',
                'amount_pay',
                'deleted_at',
            ])
            ->logOnlyDirty();
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'ticket_id');
    }

    public function violations()
    {
        return $this->hasManyThrough(
            Violation::class,
            Transaction::class,
            'ticket_id',    // Foreign key on transactions
            'id',           // Foreign key on violations
            'id',           // Local key on tickets
            'violation_id'  // Local key on transactions
        );
    }
    public function ticketedBy()
    {
        return $this->belongsTo(User::class, 'ticket_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function enforcer()
{
    return $this->belongsTo(User::class, 'id'); 
}

    
}           
    


