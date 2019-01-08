<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incomings extends Model
{
    protected $table='incomings';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
