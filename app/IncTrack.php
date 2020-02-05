<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncTrack extends Model
{
    protected $table='incomings_tracker';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}
