<?php
/**
 * Created by PhpStorm.
 * User: wangyg
 * Date: 2018/4/13
 * Time: 14:27
 */

namespace app\index\hooks;


class TestHooks
{


    /**
     * 钩子的默认入口是run，如果需要修改，
     * 调用Hook::portal('portal');方法可以把钩子文件的入口改成你想要的名字
     * @param $params
     */
    public function run($params)
    {
        // 行为逻辑
        var_dump($params);
        return;
    }
}