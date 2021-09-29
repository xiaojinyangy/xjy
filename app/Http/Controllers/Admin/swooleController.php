<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class swooleController extends Controller
{
    private  $address = '127.0.0.1';
    private  $port = 8083l
    private  $_sockets;
    /**
     * socket 测试
     */
    public function service(){
        $tcp = getprotobyname('tcp');
         $sever = socket_create(AF_INET,SOCK_STREAM,$tcp);//套字节
      // $error =  socket_last_error() || socket_strerror();获取错误
        //socket_set_option($sever, SOL_SOCKET, SO_REUSEADDR, 1);
        if($sever < 0)
        {
            //创建一个异常
            throw new \Exception("failed to create socket: ".socket_strerror($sever)."\n");
        }
        socket_bind($sever, $this->address, $this->port);
        socket_listen ($sever,$this->port);//监听
        $this->_sockets = $sever;
    }
}