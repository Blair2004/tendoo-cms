<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OptionsRepositoryInterface;

class dashboardController extends Controller
{
    /**
    *
    * Dashboard Main Page
    *
    * @return void
    */

    public function home( OptionsRepositoryInterface $Options )
    {


        return view( 'dashboard/home' );
    }
}
