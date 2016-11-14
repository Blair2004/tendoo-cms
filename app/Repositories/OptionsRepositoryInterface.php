<?php
namespace App\Repositories;

interface OptionsRepositoryInterface {
    public function set( $key, $value, $autoload = true );
}
