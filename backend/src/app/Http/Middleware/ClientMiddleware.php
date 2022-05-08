<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;

class ClientMiddleware
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

      if (is_null($cookieUser->userid) || is_null($cookieUser->apikey)) {
        abort(403);
      }

      $user = User::find($cookieUser->userid);

      if (is_null($user)) {
        abort(403);
      }

      if ($user->apikey != $cookieUser->apikey) {
        abort(403);
      }

      return $next($request);
    }
}
