<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
      
        $user = UserModel::where('username', 'manager')->firstOrFail();
        
        return view('user', ['data' => $user]);
    }
}
