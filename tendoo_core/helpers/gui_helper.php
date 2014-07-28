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
*	gui_meta() : définit une boite meta pour un GUI
**/
function gui_meta( $options , $title = "" , $type = "collapsible_panel"){
	if( !gui_is_loaded() ): return false ; endif;
	// Sauvegarde des boites méta en utilisant l'espacenom comme identifiant
	$saved_meta	=	array();
	
	if( is_array( $options ) )
	{
		if( return_if_array_key_exists( 'namespace' , $options ) ){
			$saved_meta[ $options[ "namespace" ] ]	=	$options;
		}
	}
	else
	{
		$saved_meta[ $options ]  =	array(
			'namespace'	=>	$options,
			'title'		=>	$title,
			'type'		=>	$type
		);
	}
	set_core_vars( 'gui_saved_meta' , $saved_meta );
	return get_instance()->gui;
};
/**
*	set_field() : défini un champ pour une colonne; set_field()->push_to( namespace );
**/
function gui_field( $array ){
	if( !gui_is_loaded() ): return false ; endif;
	//
	$saved_fields	=	get_core_vars( 'gui_saved_fields' ) ? get_core_vars( 'gui_saved_fields' ) : array();
	$saved_fields	=	$array;
	set_core_vars( 'gui_saved_fields' , $saved_fields );
	return get_instance()->gui;
	
};