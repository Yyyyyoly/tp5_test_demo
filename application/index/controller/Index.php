<?php
namespace app\index\controller;

require_once (__DIR__.'/../phpcas/CAS.php');

use phpCAS;

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

    public function login()
    {
        // Initialize phpCAS
        phpCAS::client(
            CAS_VERSION_2_0,
            config('phpcas.cas_host'),
            config('phpcas.cas_port'),
            config('phpcas.cas_context'),
            true
        );

        //登陆成功后跳转的地址 -- 登陆方法中加此句
        $cas_server_url = config('phpcas.cas_host').':'.config('phpcas.cas_port').config('phpcas.cas_context').'/login?embed=true';
        $own_server_url = request()->domain().request()->baseUrl();
        phpCAS::setServerLoginUrl('http://'.$cas_server_url.'&service='.$own_server_url);

        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        // phpCAS::setCasServerCACert($cas_server_ca_cert_path);

        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        phpCAS::setNoCasServerValidation();

        //这里会检测服务器端的退出的通知，就能实现php和其他语言平台间同步登出了
        phpCAS::handleLogoutRequests(true,array());

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
}
