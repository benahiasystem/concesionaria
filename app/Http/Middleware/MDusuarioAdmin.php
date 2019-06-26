<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MDusuarioAdmin
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
        if(Auth::check()){
            $usuarioActual = \Auth::user()->typeUser;
            if ($usuarioActual==0){
               return abort(404);
            }
        }else{
            return abort(404);
        }
      
        return $next($request);
    }
}
