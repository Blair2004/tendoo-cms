<?php
/**
 *  Ask Something
 *  @param
 *  @return
**/

function confirm( $question, $comparision, $continue, $cancel = null ) {
    echo $question;
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);
    if( trim($line) != $comparison ){
        if( is_callable( $cancel ) ) {
            $cancel();
        }
        exit;
    }

    if( is_callable( $continue ) ) {
        $continue();
    }
    exit;
}

function prompt( $question, $continue ) {
    echo $question;
    $handle = fopen ("php://stdin","r");
    $line = fgets($handle);

    if( is_callable( $continue ) ) {
        $continue( $line );
    }
    exit;
}
