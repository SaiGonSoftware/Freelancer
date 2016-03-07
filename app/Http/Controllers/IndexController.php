<?php
namespace App\Http\Controllers;
use App\Job;
use App\Recruit;
use App\User;
use SEO;

class IndexController extends Controller {

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
	public function Home() {
		SEO::setTitle('Cộng đồng freelancer Việt-Trang chủ');
		SEO::setDescription('Cộng đồng freelancer Việt-Nơi khẳng định khả năng của bạn');
		SEO::opengraph()->setUrl('http://localhost:8000');
		$data['content'] = Job::where('id', '>', 0)->orderBy('post_at', 'desc')->take(5)->get();
		$data['totalJob'] = Job::CountJobs();
		$data['totalUser'] = User::CountUser();
		$data['recruit_job'] = Recruit::where('id', '>', 0)->orderBy('post_at', 'desc')->take(1)->first();
		return view('ui.content', $data);
	}

}

?>