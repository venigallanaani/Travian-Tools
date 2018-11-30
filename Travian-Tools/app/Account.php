<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    
    protected $table='accounts';
    
    protected $guarded = [
        'account_id',
    ];
    
    protected $fillable = [
        'uid','account_name','user_id','user_name','server_id','tribe','status','sitter1','sitter2'
    ];
    
}