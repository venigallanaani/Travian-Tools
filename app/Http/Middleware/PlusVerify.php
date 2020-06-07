<?php

namespace App\Http\Middleware;

use Closure;
use App\Plus;

class PlusVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('server') && $request->session()->has('plus')){
            return $next($request);
        }else{
            return redirect('/plus');
        }        
    }
}
