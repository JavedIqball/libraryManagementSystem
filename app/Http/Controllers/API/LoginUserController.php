<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class LoginUserController extends Controller
{
    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'error' => $validator->errors()->toArray()]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
//            dd('sdfg');
            $user = Auth::user();
        $token = $user->createToken('loginToken')->accessToken;

        session(['token' => $token]);

            $role = $user->role;
            session(['role' => $role]);
        if (Auth::user()->role === 'admin') {
            return response()->json(['status' => 200, $token ,'message' => 'successfully', 'role' => $role]);
        }
        if (Auth::user()->role === 'user') {
            return response()->json(['status' => 200,$token, 'message' => 'successfully', 'role' => $role]);
        }
    }
        else
        {
            return response()->json(['status' => 400, 'error' => 'invalid credentials']);
        }



//
//        $user = User::where('email', $request->email)->first();
//
//
//
//        if (!$user) {
//            return response()->json([
//                'status' => 400,
//                'error' => 'invalid email']);
//        }
//        if (Hash::check($request->password, $user->password)) {
//
//            $id = $user->id;
//            session(['id' => $id]);
////           dd(session(['id'=>$id]));
//            $role = $user->role;
//            session(['role' => $role]);
//
//            return response()->json(['status' => 200, 'message' => 'successfully', 'role' => $role]);
//        }
//
//        return response()->json(['status' => 400, 'error' => 'invalid password']);
    }


    public function selectlanguage(Request $req)
    {

        {
            $lang = $req->lang;


            $abc =   session(['myLang' => $lang]);
            return redirect('/');


        }

    }
}


