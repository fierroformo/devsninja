<?php namespace App\Http\Controllers\Auth;

use Mail;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\User;


class AuthController extends Controller
{
    protected $loginPath = '/login';
    protected $homePath = '/';
    protected $redirectPath = '/successfull';
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'getLogout']);
    }


    public function activate(Request $request, $username, $code) {
        $user = User::where('username', '=', $username)
            ->where('code', '=', $code)->count();
        if($user) {
            User::where('username', '=', $username)->update(['is_active' => 1]);
			return view('activate');
		}
		abort(404);
    }


    public function login(Request $request) {
        if($request->isMethod('get')) {
            return view('auth/login');
        }

        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
        $credentials = [
            'email' => $request->email, 'password' => $request->password,
            'is_active' => 1
        ];
        $credentials_username = [
            'username' => $request->email, 'password' => $request->password,
            'is_active' => 1
        ];
        $remember = $request->has('remember');
        if(Auth::attempt($credentials, $remember) || Auth::attempt($credentials_username, $remember)) {
            return redirect($this->homePath);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }


    public function signup(Request $request) {
        if($request->isMethod('get')) {
            return view('auth/signup');
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|min:2|max:25|unique:users',
            'email' => 'required|email|max:65|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $code = str_random(60);
	    $user->code = $code;
        $user->save();

        $data = array('username' => $user->username, 'code' => $code);
        $to = $user->email;
        Mail::queue('emails.confirmation', $data, function ($message) use ($to) {
            $message->subject('Activa tú cuenta devsninja');
            $message->from('app@devsninja.com', 'devsninja');
            $message->to($to);
        });

        return redirect('successfull')->with('email', $user->email);
    }

    public function successfull(Request $request) {
        $email = $request->session()->get('email');
        if(!$email) return redirect('login');
		return view('successfull', ['email' => $email]);
	}

}
