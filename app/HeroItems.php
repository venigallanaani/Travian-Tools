<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeroItems extends Model
{
    protected $table='hero_items';
    
    protected $guarded = ['*'];   
    
}
