<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
      $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));

      // Ha nincs apikey, akkor egyből mehet.
      if (is_null($cookieUser->apikey)) {
        abort(403);
      }

      $user = User::where([
        ['apikey', '=', $cookieUser->apikey],
        ['id', '=', $cookieUser->userid]
        ])->first();


      if (is_null($user)) {
        abort(403);
      }

      if ($user->role != 2) {
        abort(403);
      }

      // Ha ide eljut, akkor ki lehet szolgálni a következő chainben szereplő function-t.
      return $next($request);
    }
}
