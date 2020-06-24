<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timings extends Model
{
    protected $table='timings';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
