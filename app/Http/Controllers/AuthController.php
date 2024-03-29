<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request){
    	$this->validate($request,[
    		'email' => 'required',
    		'password' => 'required',
    	]);
    	$user = User::where('email','=', $request->email)->first();
    	$status = "error";
    	$message = "";
    	$data = null;
    	$code = 401;
    	if($user){
    		if(Hash::check($request->password, $user->password)){
    			$user->generateToken();
    			$status = 'success';
    			$message = 'login success';
    			$data = $user->toArray();
    			$code = 200;
    		}
    		else{
    			$message = "Login gagal, password salah";
    		}
    	}
    	else{
    		$message = "Login gagal, username salah"; 
    	}

    	return response()->json([
    		'status' => $status,
    		'message' => $message,
    		'data' => $data
    	], $code);
    }

    public function register(Request $request){
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|string|max:255',
    		'email' => 'required|string|email|max:255|unique:users',
    		'password' => 'required|string|min:6',
    	]);

    	$status = "error";
		$message = "";
		$data = null;
		$code = 400;
		$avatardefault = "avatars/default.png";

    	if($validator->fails()){
    		$errors = $validator->errors();
    		return response()->json([
    			'data' => [
    				'message' => $errors,
    			]
    		],400);
    	}else{
	    	$user = User::create([
	    		'username' => $request->username,
		        'name' => $request->name,
		        'email' => $request->email,
		        'password' => Hash::make($request->password),
		        'roles'    => json_encode(['CUSTOMER']),
		        'avatar' => $avatardefault,
	    	]);
	    	if($user){
		        Auth::login($user);
		        $user->generateToken();
		        $status = "success";
		        $message = "register successfully";
		        $data = $user->toArray();
		        $code = 200;
		    }
		    else{
		        $message = 'register failed';
		    }
    	}
    	return response()->json([
		    'status' => $status,
		    'message' => $message,
		    'data' => $data
		], $code);

    }
    public function logout(Request $request){
	  $user = Auth::user();
	    if ($user) {
	        $user->api_token = null;
	        $user->save();
	    }
	    return response()->json([
	        'status' => 'success',
	        'message' => 'logout berhasil',
	        'data' => null
	    ], 200); 
    }
}
