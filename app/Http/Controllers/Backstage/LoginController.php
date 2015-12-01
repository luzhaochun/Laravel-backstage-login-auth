<?php

namespace App\Http\Controllers\Backstage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class LoginController extends \App\Http\Controllers\Backstage\Controller {

    public function getLogin(Request $request) {
        $this->data ['error'] = '';
        if($request->session()->get('admin_userid')){
            return redirect('main');
        }
        return view('backstage.login', $this->data);
    }

    public function postLogin(Request $request) {
        if (empty($request->input('user_name'))) {
            $this->data ['error'] = '用户名为空，请重新确认';
            return view('backstage.login', $this->data);
        }
        if (empty($request->input('password'))) {
            $this->data ['error'] = '密码为空，请重新确认';
            return view('backstage.login', $this->data);
        }
        $adminLogic = new \App\Logics\AdminLogic ();
        $username = trim($request->input('user_name'));
        $password = trim($request->input('password'));
        $res = $adminLogic->getAdminInfoByUsername($username);

        if (!empty($res)) {
            if (md5($password) == $res->password) {
                /*
                 * set session also can do like this
                 * Session::input('key','value');
                 */
                $request->session()->put('admin_userid', $res->id);
                $request->session()->put('admin_username', $res->user_name);
                $request->session()->put('admin_roleid', $res->role_id);

                if (!empty($request->input('remember_me'))) {
                    $response = new \Illuminate\Http\Response('YDD');
                    $response->withCookie(cookie('admin_rememberme', $request->input('remember_me'), 3600 * 24 * 7));
                    $response->withCookie(cookie('admin_userid', $res->id, 3600 * 24 * 7));
                    $response->withCookie(cookie('admin_username', $res->user_name, 3600 * 24 * 7));
                }
                // insert system login records here
                // fix me
                return redirect('main');
            } else {
                $this->data ['error'] = '密码错误，请重新确认';
                return view('backstage.login', $this->data);
            }
        } else {
            $this->data ['error'] = '用户名或密码错误，请重新确认';
            return view('backstage.login', $this->data);
        }
    }

    public function getLogout(Request $request) {
        $request->session()->forget('admin_userid');
        $request->session()->forget('admin_username');
        $request->session()->forget('admin_roleid');
        // also can $request->session->flush(),remove all session info
        // insert system logout records here
        // fix me
        return redirect('login');
    }

}
