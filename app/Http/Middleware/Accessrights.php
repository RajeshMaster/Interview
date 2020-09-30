<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use App\Model\AccessRight;

class Accessrights
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
        $roles = array_slice(func_get_args(), 2);
            foreach ($roles as $role) {
                try {
                    $roleInformation = AccessRight::fnGetRoleTypes($role);
                    if($roleInformation == Auth::user()->identFlag && Auth::user()->userType == 1) {
                        return $next($request);
                    } else if($roleInformation == Auth::user()->identFlag && $role == "user") {
                        return $next($request);
                    } else if($roleInformation == Auth::user()->identFlag && $role == "company") {
                        return $next($request);
                    } else if($roleInformation == Auth::user()->identFlag && $role == "recruiter") {
                        return $next($request);
                    }
                } catch (ModelNotFoundException $exception) {
                    dd('Could not find role ' . $role);
                }
            }
        return redirect('/');
    }
}
