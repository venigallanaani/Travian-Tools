<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    protected $table='profiles';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
