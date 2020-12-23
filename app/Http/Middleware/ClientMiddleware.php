<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ClientMiddleware
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
        $clientId = DB::table('oauth_clients')->where('secret', $request->clientId)->first();
        if(!$clientId){
            return response()->json(["data" =>["msg" => "Unauthorized"]], 401);
        }
        return $next($request);
    }
}
