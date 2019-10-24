<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table='hero';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
