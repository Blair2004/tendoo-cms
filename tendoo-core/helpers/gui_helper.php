<?php
function gui_is_loaded()
{
	if( class_exists( 'gui' ) )
	{
		return true;
	}
	return false;
}
/**
*	gui_cols_width() : définit une largeur pour chaque colonne
**/
function gui_cols_width( $cols , $width ){
	if( gui_is_loaded() ){
		get_instance()->gui->cols_width( $cols , $width );
	}
	// ajouter un debogage
};
/**
*	gui_enable : set enabled feature for current gui. Must be called before output GUI
**/
function gui_enable( $feature )
{
	if( gui_is_loaded() )
	{
		return get_instance()->gui->enable( $feature );
	}
}
/**
*	gui_meta() : définit une boite meta pour un GUI
**/
function gui_meta( $options , $title = "" , $type = "panel"){
	if( gui_is_loaded() )
	{
		return get_instance()->gui->set_meta( $options , $title , $type );
	}
	return false;
};
/**
*	set_item() : défini un champ pour une colonne; set_field()->push_to( namespace );
**/
function gui_item( $array ){
	if( gui_is_loaded() )
	{
		return get_instance()->gui->set_item( $array );
	}
	return false;	
};