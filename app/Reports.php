<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $table='reports';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
