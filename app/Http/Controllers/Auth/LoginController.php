<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Models\Jeebika\Project\JProject;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        \request()->session()->forget('s_project_id');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->authenticate($request)) {
            $user = $this->guard()->getLastAttempted();
            if ($user->status == UserStatus::Inactive) {
                $this->guard()->logout();
                $this->incrementLoginAttempts($request);
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(["email" => " This user currently inactive. Please contact your administrator."]);
            } elseif ($user->status == UserStatus::Blocked) {
                $this->guard()->logout();
                $this->incrementLoginAttempts($request);
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(["email" => " This user is blocked. Please contact your administrator."]);
            } else {
                if ($user->manager) {
                    $request->session()->put('s_j_project_id', $user->manager->id);
                    $request->session()->put('s_j_project', JProject::find($user->manager->id));
                }
                $this->attemptLogin($request);
                return $this->sendLoginResponse($request);
            }
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'email', 'max:30', Rule::exists(User::getTableName(), 'email')],
            'password' => ['required', 'string', 'max:30'],
        ]);
    }

    public function username()
    {
        return 'email';
    }

    private function authenticate(Request $request): bool
    {
        $username = $request->post($this->username());
        $password = $request->post('password');
        /*$user = User::where($this->username(), $username)->first();
        if ($user) {
            $request->merge([$this->username() => $username]);
        }*/
        return Auth::attempt(["email" => $username, "password" => $password]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
