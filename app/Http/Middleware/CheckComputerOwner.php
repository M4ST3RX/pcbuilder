<?php

namespace App\Http\Middleware;

use App\Computer;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckComputerOwner
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
        if(isset($request->computer_id)) {
            $computer = Computer::find($request->computer_id);
            if($computer->user_id !== Auth::id()) abort(404);
        }

        return $next($request);
    }
}
