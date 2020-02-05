<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackTroops extends Model
{
    protected $table='trackTroops';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
