<?php
namespace App\Http\Controllers;
use App\Chat;
use App\User;
use Auth;
use Input;
use SEO;

class ChatController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	/**
	 * Create a new controller instance.
	 * @return home page
	 * show job post information with $content
	 * show username post that job
	 */
	public function index($username) {
		SEO::setTitle('Tin nhắn ' . $username);
		SEO::setDescription('Cộng đồng freelancer Việt-Nơi khẳng định khả năng của bạn');
		SEO::opengraph()->setUrl('http://localhost:8000/tin-nhan');
		$chat_message = Chat::where('to_user', Auth::user()->username)->get();
		return view('ui.chat.chat', compact('chat_message'));
	}

	public function insertMessage() {
		$chat_message = new Chat();
		$chat_message->content = Input::get('message');
		$chat_message->from_user = Input::get('from_user');
		$chat_message->to_user = Input::get('to_user');
		$chat_message->created_at = date('Y-m-d H:i:s');
		$chat_message->save();
		return response()->json(array('mess' => 'Success'));
	}

}

?>