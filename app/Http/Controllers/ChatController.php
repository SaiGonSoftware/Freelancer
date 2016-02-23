<?php
namespace App\Http\Controllers;
use SEO;
use Auth;
use Input;
use App\User;
use App\Chat;

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

    public function insertMessage()
    {
      $chat_message=new Chat();
      $chat_message->content=Input::get('message');
      $chat_message->user1=Input::get('name');
      $chat_message->save();
      return response ()->json ( array ('mess' => 'Success' ) );
    }

 }


 ?>