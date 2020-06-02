<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raid extends Model
{
    protected $table='raids';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
