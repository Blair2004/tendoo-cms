<?php
global $tendoo_cmd;

include_once( APPPATH . 'libraries/cmd_library.php' );

if( $tendoo_cmd[1] == 'module' ) {
    $Module         =   new CMD_Library;
    $Module->create( @$argv[2] );
}

// exit;
//
// AksModuleName:
// prompt( "What is the name of the module ?", function( $name ){
//     if( $name != '' ) {
//         global $module;
//         $module[ 'application' ][ 'name' ]      =   $name;
//         return [
//             'msg'   =>  "Name has been saved",
//             'goto'  =>  'AskAuthorName';
//         ]
//         echo "Name has been saved";
//         goto AskAuthorName;
//     } else {
//         echo "Invalid Name";
//         goto AskModuleName;
//     }
// });
// exit;
//
// // Skip this
// AskFileName:
// prompt( "What should be the main file name ? ", function( $name ) {
//     if( $name != '' ) {
//         global $module;
//         $module[ 'application' ][ 'main' ]      =   $name;
//         file_put_contents( APPPATH . 'modules/' . $module[ 'application' ][ 'main' ] . '.php', "created using flash" );
//         echo "Name has been saved";
//
//         // Ask Author Name
//         goto AskAuthorName;
//     } else {
//         echo "Invalid File name";
//         goto AskFileName;
//     }
// });
// exit;
//
// AskAuthorName:
// prompt( "What is the author name ? ", function( $name ) {
//     if( $name != '' ) {
//         global $module;
//         $module[ 'application' ][ 'author' ]      =   $name;
//         echo "Author has been saved";
//     } else {
//         echo "Invalid Author Name";
//         goto AskAuthorName;
//     }
// });
// exit;
