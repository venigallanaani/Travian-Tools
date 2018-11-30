<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $table='servers';
    
    protected $guarded = [
        'id',
    ];
    
    protected $fillable = [
        'url','country','status','start_date','days','maps_table','diff_table','timezone','table_id'
    ];
}
