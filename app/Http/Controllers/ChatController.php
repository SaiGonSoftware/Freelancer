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
    	  SEO::setTitle('Tin nhắn');
        SEO::setDescription('Cộng đồng freelancer Việt-Nơi khẳng định khả năng của bạn');
        SEO::opengraph()->setUrl('http://localhost:8000/gui-tin-nhan');
        return view('ui.chat.chat');
    }

/*
    public function sendMessage()
    {
       $username=Auth::user()->username;
       $message=Input::get('text');
       $chat_messages=new ChatMessage();
       $chat_messages->username=$username;
       $chat_messages->message=$message;
       $chat_messages->user_id=Auth::user()->id;
       $chat_messages->save();
    }

    public function isTyping()
    {
       $username=Auth::user()->username;
       $chat=Chats::find(1);
       if($chat->user1==$username){
          $chat->user1_typing=true;
       }
       else
          $chat->user2_typing=true;
       $chat->save();
    }

    public function notTyping()
    {
       $username=Auth::user()->username;
       $chat=Chats::find(1);
       if($chat->user1==$username){
          $chat->user1_typing=false;
       }
       else
          $chat->user2_typing=false;
       $chat->save();
    }

    public function retriveMessage()
    {
       $username=Auth::user()->username;
       $message=ChatMessage::where('username','!=',$username)->where('read','=',false)->first();
       if(count($message)>0){
        $message->read=true;
        $message->save();
        return $message->message;
       }
    }

    public function retriveTypingStatus()
    {
       $username=Auth::user()->username;
       $chat=Chats::find(1);
       if($chat->user1==$username){
          if($chat->user2_typing)
            return $chat->user2;
       }
       else{
            if($chat->user1_typing)
            return $chat->user1;
       }
    }*/
}


?>