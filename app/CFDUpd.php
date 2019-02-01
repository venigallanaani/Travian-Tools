<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CFDUpd extends Model
{
    //
    //
    
    protected $table='defenseUpdates';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}
