<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OnlineMiddleware
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
        $user_to_offline = User::where('last_activity', '<', now());
        $user_to_online = User::where('last_activity', '>=', now());

        if (isset($user_to_offline)) {
            $user_to_offline->update(['is_online' => false]);
        } else if (isset($user_to_online)) {
            $user_to_online->update(['is_online' => true]);
        }

        if (Auth::check()) {
            $cache_value = Cache::put('user-is-online', Auth::user()->id, \Carbon\Carbon::now()->addMinutes(1));
            $user = User::find(Cache::get('user-is-online'));

            $user->last_activity = now()->addMinute(1);
            $user->is_online = true;
            $user->save();
        } else if (!Auth::check() && filled(Cache::get('user-is-online'))) {
            # code...
            $user = User::find(Cache::get('user-is-online'));
            if (isset($user)) {
                $user->is_online = false;
                $user->save();
            }
        }
        return $next($request);
    }
}
