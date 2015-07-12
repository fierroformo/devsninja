<?php namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;


class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth', ['except' => ['successfull']]);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index() {
		return view('home');
	}


    public function home() {
		return redirect('/');
	}


    public function successfull(Request $request) {
        $email = $request->session()->get('email');
        if(!$email) return redirect('login');
		return view('successfull', ['email' => $email]);
	}

}
