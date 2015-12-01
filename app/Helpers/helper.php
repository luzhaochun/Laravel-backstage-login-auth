<?php
/**
 * 函数文件
 * Created by PhpStorm.
 * User: lotus
 * Date: 15/11/23
 * Time: 下午5:18
 */

if (! function_exists('show_message'))
{
    /**
     * @param $msg 提示信息
     * @param $url_forward 跳转url ,关闭对话框时该值为容
     * @param int $timeout 等待跳转时间
     * @param int $layer_index  对话框f
     */
    function show_message($msg,$url_forward,$timeout=0,$layer_index=0)
    {
        include(__DIR__.'./../../resources/views/backstage/common/show_message.blade.php');
    }
}


if (! function_exists('log_records'))
{
    /**
     * User: lotus
     * 记录日志
     * @param string $log_info
     * @param string $type 操作类型 '0'、操作 '1'、登录
     */
    function log_records($log_info='',$type='0')
    {
        $data = array(
            'admin_id'    => Session::get('admin_userid'),
            'admin_name'  => Session::get('admin_username'),
            'module'      => \Route::getCurrentRoute()->getPath(),  // 方法：\Request::path() 亦可
            'log_info'    => $log_info,
            'update_time' => date('Y-m-d H:i:s'),
            'type'        => $type,
            'ip'          => \App\Helpers\utils::getClientIp(),
        );

        \App\Models\SystemLog::logWrite($data);

    }
}

if(! function_exists('object2array')){

    /**
     * 对象转数组
     * @param $object
     * @return mixed
     */
    function object2array($object){
        $object =  json_decode( json_encode( $object),true);
        return  $object;
    }
}
