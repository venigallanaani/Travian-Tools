<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diff extends Model
{
    protected $table='diff_details';
    
    protected $fillable = ['server_id','x','y','id','vid','village','uid','player','aid','alliance','population','status','table_id','diffPop','pop1','pop2','pop3','pop4','pop5','pop6','pop7'];
    
    public $timestamps=true;
    
}
