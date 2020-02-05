<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlusReports extends Model
{
    protected $table='plus_reports';
    
    protected $fillable = ['*'];
    
    public $timestamps=true;
}
