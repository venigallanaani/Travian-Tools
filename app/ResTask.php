<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ResTask extends Model
{
    protected $table='resourcetasks';
    
    protected $fillable = [
        '*'
    ];
    
    public $timestamps=true;
}