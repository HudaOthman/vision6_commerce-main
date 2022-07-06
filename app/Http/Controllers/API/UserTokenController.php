<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTokenController extends Controller
{
    public function get_token(Request $request)
    {
        if(Auth::attempt($request->all())) {
            if(Auth::user()->type == 'super-admin') {
                $token = Auth::user()->createToken('dev-token');

                return ['token' => $token->plainTextToken];
            }
        }

        return 'Error';
    }
}
