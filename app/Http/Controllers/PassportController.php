<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use User;
use DB;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller; 
use App\Http\Controllers\Category; 


class PassportController extends Controller
{
    public $successStatus = 200;

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('bukabuku')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    public function books(){
        $books = DB::select('select * from books');
        return $books;
    }
}
