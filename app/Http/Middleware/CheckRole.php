<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class CheckRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  $roles
   * @return mixed
   */
  public function handle($request, Closure $next, ...$roles)
  {
    // $finded = false;
    // $total = count($roles);
    // $i = 0;

    // while(!$finded && ($i < $total)) {
    //   if($request->user()->isRol($roles[$i])) {
    //     $finded = true;
    //   }

    //   $i++;
    // }

    // if($finded) {
    //   return $next($request);
    // }

    if($request->user()->admin) {
      return $next($request);
    }

    throw new AuthorizationException;
  }
}
