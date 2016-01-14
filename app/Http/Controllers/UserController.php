<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Image;
class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/*
	*	Get user info by their name
	*	@param string $name to compare with the source
	*	return manage page for user
	*/
	public function userDetail($name)
	{
		$userDetail=User::where('username', '=', $name)->get();
		return view('ui.userinfo.uinfo',compact('userDetail'));
	}


	/*
	*	Get user info by their name
	*	@param string $name to compare with the source
	*	@var newFileName create uniqe file name base on id
	*  	if directory doesn't exist create directory
	*	return manage page for user
	*/
	public function profileImage($name)
	{
		$user=new User();
		$userDetail=User::where('username', '=', $name)->first();
		$temp=$_FILES['file']['tmp_name'];
		$image=$_FILES['file']['name'];
		$ext=pathinfo($image,PATHINFO_EXTENSION);

		$newFileName=uniqid($userDetail->id);
		if (!is_dir("images/$name/")) {
			mkdir("images/$name",0777);
		}
		$img=Image::make($temp);
		$img->fit(150, 150);
		$src = "images/$name/$newFileName.$ext";

	    $img->save($src);
	    $user=$userDetail;
	    $user->avatar = $src;
	    $user->save();
	    return redirect()->intended('/tai-khoan/thong-tin-ca-nhan/'.$name);
	}
}
