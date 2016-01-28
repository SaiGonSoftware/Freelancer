<?php 
namespace App\Http\Controllers;
use App\Job;
use App\User;
class IndexController extends Controller
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
	public function Home()
	{
		$data['title']="Cộng đồng freelancer Việt-Trang chủ";
		$data['description']="Cộng đồng freelancer Việt";
		$data['content'] = Job::where('id', '>', 0)->orderBy('post_at')->take(5)->get();
		$data['totalJob']=Job::CountJobs();
		$data['totalUser']=User::CountUser();
		return view('ui.content',$data);
	}
}



?>