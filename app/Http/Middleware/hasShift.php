<?php

namespace App\Http\Middleware;

use App\Models\Shift;
use Closure;
use Illuminate\Http\Request;

class hasShift
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->user()->active_shift)
            return redirect()->route('pos.shift.index')->with('error', 'يرجي فتح الورديه أولا');
        $shift = Shift::where('end_time', null)
            ->where('user_id', auth()->id())
            ->first();
        if (!$shift) {
            return redirect()->route('pos.shift.index');
        }
        return $next($request);
    }
}
