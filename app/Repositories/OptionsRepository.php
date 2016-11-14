<?php
namespace App\Repositories;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;
use App\Options;

class OptionsRepository implements OptionsRepositoryInterface
{
    public function __construct()
    {
        $this->Options      =   new Options;
    }
    /**
    *
    * Set Options
    *
    * @param
    * @return
    */

    public function set( $key, $value, $autoload = true )
    {
        
    }
}
?>
