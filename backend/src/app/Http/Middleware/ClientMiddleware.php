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
      $userid = $request->query('userid');
      $apikey = $request->query('apikey');

      if (is_null($userid) || is_null($apikey)) {
        abort(403);
      }

      $user = User::find($userid);

      if (is_null($user)) {
        abort(403);
      }

      if ($user->apikey != $apikey) {
        abort(403);
      }

      return $next($request);
    }
}
