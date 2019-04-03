<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     *  Get all users except the auth one
     *  @param Request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::where('id','!=',$request->user()->id)->get();                                              
        return response()->json([
            'users' => $users
        ]);
    }
}
