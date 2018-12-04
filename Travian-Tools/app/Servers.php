<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $table='servers';
    
    protected $guarded = [
        'server_id','url','country','status','start_date','maps_table','diff_table','timezone',
    ];
    
    protected $fillable = [
        'days','table_id'
    ];
    
    public $timestamps=true;
}
