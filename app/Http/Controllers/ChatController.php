<?php
namespace App\Http\Controllers;
use SEO;
use Auth;
use Input;
use App\User;
use App\Chats;
use App\ChatMessage;
class ChatController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest');
    }

    /**
     * Create a new controller instance.
     * @return home page
     * show job post information with $content
     * show username post that job
     */
    public function index()
    {
       $name=Auth::user()->username;
       SEO::setTitle('Tin nhắn '.$name);
       SEO::setDescription('Cộng đồng freelancer Việt-Nơi khẳng định khả năng của bạn');
       SEO::opengraph()->setUrl('http://localhost:8000/tin-nhan');
       return view('ui.chat.chat');
    }


 }


 ?>