<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Troops extends Model
{
    protected $table='troops';
    
    protected $guarded = ['*'];
}
