<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login()
    {
        $model = new User();
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $data['token'] =  $user->createToken('nApp')->accessToken;

            $user_to_online = $model->find($user->id);
            $user_to_online->last_activity = now()->addMinute(1);
            $user_to_online->is_online = true;
            $user_to_online->save();

            return ResponseFormatter::success($data, 'login successfully');
        } else {
            return ResponseFormatter::error(null, 'Unauthorised', 404);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->fails(), 'registration failed', 404);
        }

        $data = $request->except('c_password');
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $data['token'] =  $user->createToken('nApp')->accessToken;
        $data['name'] =  $user->name;

        return ResponseFormatter::success($data, 'registration successfully');
    }

    public function logout(Request $request)
    {
        $model = new User();
        $logout = $request->user()->token()->revoke();

        if ($logout) {

            $user_to_offline = $model->find(Auth::user()->id);
            $user_to_offline->is_online = false;
            $user_to_offline->save();

            return ResponseFormatter::success($logout, 'Logout successfully');
        }
    }

    public function token()
    {
        $user = Auth::user();
        return ResponseFormatter::success($user, 'successfully get token');
    }
}
