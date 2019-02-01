<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResUpd extends Model
{
    protected $table='resourceupdates';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}
