<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scouts extends Model
{
    protected $table='scouts';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
