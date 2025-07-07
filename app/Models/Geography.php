<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geography extends Model
{
    protected $table = 'geography'; // Specify the correct table name
    protected $fillable = [
        "psgccode",
        "name",
        "level",
        "islandgroup",
        "status",
        "enteredby",
        "timestamp",
    ];


    protected $primaryKey = 'psgccode';
    public $incrementing = false;
    protected $keyType = 'string';
}
