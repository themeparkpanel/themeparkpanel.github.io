<?php
namespace App\Http\Controllers\Panel;

use App\ChangeEmail;
use App\Http\Controllers\Controller;
use App\Mail\EmailChange;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UMSController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @param int $page
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($page = 1)
    {
        $pages = User::count();
        $pages = (int) ceil($pages/10);
        if($pages < 1 && $page == 1)
            $page = 1;

        if($page < 1 || ($pages > 0 && $page > $pages))
            return redirect()->route('panel.ums', [
                'page' => ($pages > 0 ? $pages : 1)
            ]);

        $data = User::select('id', 'uuid', 'last_active', 'is_admin', 'is_root', 'email_verified_at')->get();
        return view('panel.ums.index')->with([
            'users' => $data,
            'page' => $page,
            'pages' => $pages
        ]);
    }

    public function info($id) {
        $user = User::findOrFail($id);
        return view('panel.ums.info')->with([
            'user' => $user
        ]);
    }

    public function edit($id) {
        $user = Auth::user();
        if(!$user->is_root && !$user->is_admin)
            return Redirect::route('panel.ums');

        $user = User::findOrFail($id);
        return view('panel.ums.edit')->with([
            'user' => $user
        ]);
    }

    public function update(Request $request) {
        if(!$request->has('id'))
            return Redirect::back();

        $user = User::findOrFail($request->get('id'));
        if($request->get('email') !== $user->email) {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'unique:users,email', 'max:255']
            ]);

            if(!$validator->passes())
                return Redirect::back()->withErrors($validator);

            $change = ChangeEmail::create([
                'user_id' => $user->id,
                'email' => $request->get('email'),
                'token' => Str::random(12)
            ]);

            Mail::to($request->get('email'))->send(new EmailChange($change));
            die('Send! Email: '.$request->get('email'));
        }

        $validator = Validator::make($request->all(), [
            'verified' => ['required', 'boolean']
        ]);

        if(!$validator->passes())
            return Redirect::back()->withErrors($validator);

        if($request->get('verified')) {
            $user->email_verified_at = empty($user->email_verified_at) ? date('Y-m-d H:i:s') : $user->email_verified_at;
        } else {
            $user->email_verified_at = null;
        }

        if(Auth::user()->is_root) {
            $validator = Validator::make($request->all(), [
                'admin' => ['required', 'numeric', 'min:0', 'max:2'],
            ]);

            if (!$validator->passes())
                return Redirect::back()->withErrors($validator);

            $admin = $request->get('admin');
            if ($admin == 1) {
                $user->is_admin = 1;
                $user->is_root = 0;
            } else if($admin == 2) {
                $user->is_admin = 0;
                $user->is_root = 1;
            } else {
                $user->is_admin = 0;
                $user->is_root = 0;
            }
        }

        if($user->save()) {
            session()->flash('success', 'Successfully edited user: '.$user->username());
        } else {
            session()->flash('error', 'Unable to edit user: '.$user->username());
        }

        return Redirect::route('panel.ums');
    }

    public function delete($id) {
        $auth = Auth::user();
        if(!$auth->is_admin && !$auth->is_root)
            return Redirect::route('panel.home');

        $user = User::findOrFail($id);
        if($user->delete()) {
            session()->flash('success', 'Successfully deleted user: '.$user->firstname);
        } else {
            session()->flash('error', 'Unable to delete user: '.$user->firstname);
        }

        return Redirect::back();
    }

}
