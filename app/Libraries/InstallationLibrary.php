<?php
namespace App\Libraries;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;

class InstallationLibrary
{
    /**
    *
    * Check database details
    *
    * @param  string host name
    * @param string user name
    * @param string user password
    * @param string database
    * @return
    */

    public function testDb( $hostName, $userName, $password, $databaseName, $dbPrefix )
    {
        $Capsule        =   new Capsule;

        $connexions     =   config( 'database.connections' );
        $connexions[ 'testDb' ] =   array(
            'driver'    => 'mysql',
            'host'      => $hostName,
            'database'  => $databaseName,
            'username'  => $userName,
            'password'  => $password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => $dbPrefix,
        );

        config( [ 'database.connections' => $connexions ] );

        $Database       =   DB::connection( 'testDb' );

        try {
            # your code should be here
            $PDO        =   $Database->getPdo();
            return [ 'status' => true, 'message'    => 'success' ];
        } catch (\PDOException $e) {
            # do something or render a custom error page
            return [ 'status' => false, 'message' => $e->getMessage() ];
        }
    }
}
?>
