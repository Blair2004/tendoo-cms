<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CMD_Library {

    private $askSurfix   =   '[Q] to exit : ';

    /**
     *  Ask
     *  @param  string question
     *  @return string
    **/

    public function ask( $content, $callback ) {
        prompt( $content . $this->askSurfix, $callback );
    }

    /**
     *  Ask Author
     *  @param string author
     *  @return void
    **/

    public function askAuthor( $authorName = null )
    {
        $this->checkExit( $authorName );

        if( ! empty( trim( $authorName ) ) ){
            $this->module_author    =   $authorName;
            return $this->ask( 'Write a description about that module', [ $this, 'askDescription' ] );
        }
        return $this->ask( 'Incorrect Author. What is the author name ?', [ $this, 'askAuthor' ] );
    }

    /**
     *  Ask Description
     *  @param string module description
     *  @return void
    **/

    public function askDescrition( $description )
    {
        $this->checkExit( $description );

        if( ! $this->isEmpty( $description ) ) {
            $this->module_description   =   $description;
            $module_string      =   '';
            $module_string      .=   'Module Name : ' . $this->module_name . '\n';
            $module_string      .=   'Module Author : ' . $this->module_author . '\n';
            $module_string      .=   'Module Main File : ' . $this->module_namespace . '.php\n';
            $module_string      .=   'Module Namespace : ' . $this->module_namespace . '\n';
            $module_string      .=   'Module Version : 1.0\n';
            $module_string      .=   'Module Description : ' . $this->module_description . '\n';
            return $this->ask(
                'Whould you confirm module creation [Y] for yes [N] for No.\n' .
                $module_string
            );
        }
        return $this->ask( 'Incorrect module description', [ $this, 'askDescription' ] );
    }

    /**
     *  Ask Module version
     *  @param string module version
     *  @return void
    **/

    public function askModuleName( $moduleName )
    {
        $this->checkExit( $moduleName );

        if( ! empty( trim( $moduleName ) ) ){
            $this->module_name  =   $moduleName;
            return $this->ask( 'Who is the author ?', [ $this, 'askAuthor' ] );
        }

        return $this->ask( 'Incorrect Module. What is the module name ?', [ $this, 'askModuleName' ]);
    }

    /**
     *  Create Module
     *  @param string module namespace
     *  @return void
    **/

    public function create( $namespace = null )
    {
        $this->checkExit( $namespace );

        if( ! empty( trim( $namespace ) ) ){
            $this->module_namespace     =   $namespace;
            return $this->ask( 'What is the module name ?', [ $this, 'askModuleName' ] );
        }
        return $this->ask( 'What is the module namespace ?', [ $this, 'create' ] );
    }

    /**
     *  Exit on Quit
     *  @param string
     *  @return void
    **/

    public function checkExit( $string )
    {
        if( in_array( trim( $string ), [ 'q', 'Q' ] ) ) {
            exit;
        }
    }

    /**
     *  Empty
     *  @param string
     *  @return bool
    **/

    public function isEmpty( $string )
    {
        return empty( trim( $string ) );
    }


}
