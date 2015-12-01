<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Route;
class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //check allowed Ip
        if(config('auth.ADMIN_ALLOW_IP')){
            if(!in_array(\App\Helpers\utils::getClientIp(),explode(',',config('auth.ADMIN_ALLOW_IP')))){
                return view('backstage.error');
            }
        }
        $route = '/'.Route::getCurrentRoute()->getpath();
        //get route,then check
        if(!in_array(strtolower($route), config('auth.NOT_ALLOW_LOGIN_CHECK'))) {
            if (empty($request->session()->get('admin_userid'))) {
                 return redirect()->guest('login');
            }
            $menuLogic = new \App\Logics\MenuLogic();
            if(!$menuLogic->checkMenuExist(ltrim(strtolower($route),'/'))){
                return view('backstage.error');
            }
        }
        $uid = $request->session()->get('admin_userid');
        //check route if authorized
        if(!in_array(strtolower($route), config('auth.NOT_ALLOW_AUTH_CHECK'))) {
            $authService = new \App\Services\Auth();
            if(!$authService->check(ltrim(strtolower($route),'/'), $uid)) {
                return view('backstage.unauthorize');
            }
        }
        return $next($request);
    }
    
    
}
