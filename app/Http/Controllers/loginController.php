<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;

class loginController extends Controller
{
    /**
    *
    * Login Controller
    *
    * @return string controller view
    */

    public function getLogin()
    {
        return view( 'login/main' );
    }

    /**
    *
    * Login Post Controller
    *
    * @param object request
    * @return void
    */

    public function postLogin( loginRequest $request )
    {
        return redirect( 'dashboard' );
    }
}
