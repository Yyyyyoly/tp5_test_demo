<?php

namespace app\http\middleware;

class LoginCheck
{

    /**
     * 中间件拦截
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\response\Redirect
     */
    public function handle($request, \Closure $next)
    {
        if ($request->param('name') == 'think') {
            return redirect('/login');
        }

        return $next($request);
    }
}
