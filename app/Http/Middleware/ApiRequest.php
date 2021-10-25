<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if(ir_st){
        //     if(interim){
        //         total - total interim 
        //     }
        // }
        // return response()->json($request->ajax());
        // if(!$request->ajax()){
        //     abort(403);
        // }
        return $next($request);
    }
}
