<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plus extends Model
{
    protected $table='plus';
        
    protected $fillable = [
        'id','name','server_id','user','account','plus','leader','defense','offense','artifact','resources','wonder'
    ];
}
