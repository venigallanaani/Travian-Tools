<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    protected $table='players';
    
    protected $fillable = [
        'server_id','uid','player','rank','tribe','villages','population','diffpop','aid','alliance','table_id'
    ];
    
    public $timestamps=true;
}
