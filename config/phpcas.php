<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 默认跳转页面对应的模板文件
    'cas_host'  => env('CAS_HOST','localhost'),
    'cas_port'    =>(int) env('CAS_PORT',8888),
    'cas_context'    => env('CAS_CONTEXT','/cas'),
    'cert_way'  => env('CERT_WAY','none'),
    'ca_cert_path'  => env('CA_CERT_PATH',''),
    'log_out_request'  => env('LOG_OUT_REQUEST','true'),
];
