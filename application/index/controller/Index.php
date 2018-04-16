<?php
namespace app\index\controller;

require_once (__DIR__.'/../phpcas/CAS.php');

use app\index\hooks\TestHooks;
use phpCAS;
use think\facade\Hook;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }


    /**
     * phpcas 登入
     * @return string
     */
    public function login()
    {
//        phpCAS::setDebug();
        // Initialize phpCAS
        phpCAS::client(
            CAS_VERSION_2_0,
            config('phpcas.cas_host'),
            config('phpcas.cas_port'),
            config('phpcas.cas_context'),
            true
        );

        //login and redirect
        $cas_server_url = config('phpcas.cas_host').':'.config('phpcas.cas_port').config('phpcas.cas_context').'/login?embed=true';
        $own_server_url = request()->domain().request()->baseUrl();
        phpCAS::setServerLoginUrl('http://'.$cas_server_url.'&service='.$own_server_url);

        // automatically log the user when there is a cas session opened
//        phpCAS::setCacheTimesForAuthRecheck(-1);

        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        if( config('phpcas.cert_way') == 'caCert') {
            phpCAS::setCasServerCACert(config('phpcas.ca_cert_path'));
        }
        else {
            // For quick testing you can disable SSL validation of the CAS server.
            // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
            // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
            phpCAS::setNoCasServerValidation();
        }

        // 其他服务器退出时是否通知（如果同时还有java 等其他语言的client）
        if(config('phpcas.log_out_request') == false) {
            phpCAS::handleLogoutRequests(false);
        }
        else {
            phpCAS::handleLogoutRequests(true);
        }

        // force CAS authentication
        if (phpCAS::checkAuthentication()) {
            //获取登陆的用户名
            $username = phpCAS::getUser();
           return $username;
        } else {
            // 访问CAS的验证
            phpCAS::forceAuthentication();
        }
    }


    /**
     * phpcas 登出
     * @return bool
     */
    public function logout()
    {
        // Initialize phpCAS
        phpCAS::client(
            CAS_VERSION_2_0,
            config('phpcas.cas_host'),
            config('phpcas.cas_port'),
            config('phpcas.cas_context'),
            true
        );

        $cas_server_url = config('phpcas.cas_host').':'.config('phpcas.cas_port').config('phpcas.cas_context').'/logout?embed=true';
        $own_server_url = request()->domain();
        phpCAS::setServerLogoutURL('http://'.$cas_server_url.'&service='.$own_server_url.'/');

        //no SSL validation for the CAS server
        phpCAS::setNoCasServerValidation();

        phpCAS::logout();
        return true;
    }


    /**
     * 测试一下钩子的使用
     * 钩子的具体行为函数定义在TestHooks里的run方法，入口方法可以修改，详细见该类
     * 找个地方进行一下钩子的注册行为（比如中间件？？？）
     * 然后，在需要监听的地方listen一下。
     * 这么干貌似可以解耦代码，随时在程序中"+/-"一段新的代码
     */
    public function hooks(){
        Hook::add('hook_test',TestHooks::class);
        Hook::listen('hook_test',['name'=>'wangyg']);
    }
}
