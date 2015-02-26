<?php
if( $pages_editor_loaded_page != 404 ){
	set_page( 'title' , $pages_editor_loaded_page[0][ 'TITLE'] );
	set_page( 'description' , $pages_editor_loaded_page[0][ 'DESCRIPTION'] );
	$active_theme_object->page( return_if_array_key_exists( 'FILE_CONTENT' , $pages_editor_loaded_page[0] ) );
} 
else {
	$active_theme_object->page_404();
}