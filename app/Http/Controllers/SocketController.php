<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use LRedis;

class SocketController extends  Controller {

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('ui.chat.socket');
    }
    public function writemessage()
    {
        return view('ui.chat.writemessage');
    }
    /**
     * [sendMessage use Redis to publish the form input message to the queue
     *  and then redirect the application again to the form]
     * @return [type] [description]
     */
    public function sendMessage(){
        $redis = LRedis::connection();
        $redis->publish('message', Request::input('message'));
        return redirect('writemessage');
    }
    
}
