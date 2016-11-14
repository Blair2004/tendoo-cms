<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Requests\appConfigRequest;
use App\Http\Requests\databaseConfigRequest;
use App\Libraries\InstallationLibrary;

class setupController extends Controller
{
    /**
    *
    * Setup Header
    *
    * @param  int page id
    * @return void
    */

    public function getPages( $page_id = '' )
    {
        if( $page_id == '' ) {
            return view( 'setup/main' );
        } else if( is_numeric( $page_id ) ) {
            return view( 'setup/view-' . $page_id );
        }
    }

    /**
    *
    * Post App details
    *
    * @param object Request
    * @return void
    */

    public function postAppDetails( appConfigRequest $request )
    {
        // check app details and redirect to login page
        return redirect( 'login' );
    }

    /**
    *
    * Post Pages
    *
    * @param object Request
    * @return void
    */

    public function postDatabaseDetails( databaseConfigRequest $request, InstallationLibrary $InstallationLibrary )
    {
        $result     =   $InstallationLibrary->testDb(
            $request->input( 'host_name' ),
            $request->input( 'user_name' ),
            $request->input( 'user_pwd' ),
            $request->input( 'db_name' ),
            $request->input( 'db_prefix' )
        );

        if( $result['status'] == false ) {
            return redirect( 'setup/1?go' )->with( $result );
        } else {
            return redirect( 'setup/2' )->with( $result );
        }
        // Create database stuff here and redirect if there is any issue
        // return redirect( '/setup/2' );
    }


}
