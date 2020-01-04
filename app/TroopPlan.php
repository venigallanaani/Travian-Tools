<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TroopPlan extends Model
{
    protected $table='troopsplan';
    
    protected $fillable = ['*'];
    
    public $timestamps=false;
}
