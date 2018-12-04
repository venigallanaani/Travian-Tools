<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alliances extends Model
{
    protected $table='alliances';
    
    protected $fillable = [
        'server_id','aid','alliance','rank','player','villages','population','diffpop'
    ];
    
    public $timestamps=true;
}
