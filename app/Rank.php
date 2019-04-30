<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $table='rankings';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
