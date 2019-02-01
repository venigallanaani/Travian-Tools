<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alliances extends Model
{
    protected $table='alliances';
    
    protected $fillable = [
        'server_id','aid','alliance','rank','players','villages','population','diffpop','table_id'
    ];
    
    public $timestamps=true;
}
