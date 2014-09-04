<?php
$active_theme	=	get_core_vars( 'active_theme' );
$theme_settings	=	return_if_array_key_exists( 'theme_settings' , $active_theme );
if( $theme_settings ){	
	if( is_array( get_active_theme_vars( 'theme_items' ) ) ){
		foreach( get_active_theme_vars( 'theme_items' ) as $namespace	=> $items ){
			// Si l'item à été enregistré dans les réglages du thèmes
			if( array_key_exists( $namespace , $theme_settings ) ){
				$item_settings	=	$theme_settings[ $namespace ];
				$api			=	get_apis( return_if_array_key_exists( 'declared_apis' , $item_settings ) );
				$callback		=	return_if_array_key_exists( 'callback' , $api );
				if( $callback ){
					if( is_array ( $callback ) ){
						if( method_exists( $callback[0] , $callback[1] ) ){
							// We dont consider Item IF setting limit result to 0
							if( (int) $item_settings[ 'api_limit' ] > 0 ){
								$returned	=	$callback[0]->$callback[1]( $item_settings[ 'api_limit' ] );
								// Set Item With Returned datas from API
								if( is_array ( $returned ) ){
									foreach( $returned as $r ){
										set_item( $namespace , $r );
									}
								}
							}
						}
					}					
				}
				// 
			}
		}
	}
	get_core_vars( 'active_theme_object' )->home();
}