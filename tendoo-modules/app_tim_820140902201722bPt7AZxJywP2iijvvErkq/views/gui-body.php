<?php
// GUI Dev
if( true == false ) :
// 
gui_cols_width( 1 , 2 );
gui_cols_width( 2 , 2 );
gui_meta( "espace_nom" , "Comment créer une UI avec Tendoo GUI" )->push_to( 1 );
gui_meta( "super_nombre" , "Super Nombre" )->push_to( 2 );
$this->visual_editor->loadEditor(1);
// 
$form			=	array(
	'action'		=>	'',
	'method'		=>	'POST',
	"submit_text"	=>	"Enregistrer",
	"reset_text"	=>	"Reinitialiser"
);
$fields[]		=	array(
	'label'		=>	'Nom',
	'type'		=>	'text',
	'name'		=>	'name'	
);
$fields[]		=	array(
	'label'		=>	'Nom',
	'type'		=>	'password',
	'name'		=>	'name'	
);
$fields[]		=	array(
	'label'		=>	array('Se connecter','fuir','troisie'),
	'type'		=>	'radio',
	'name'		=>	array('se_connecter','se_deconnecter','troisie'),
	'value'		=>	array( 'connect' , 'escape' , 'troisie' )
);
$fields[]		=	array(
	'label'		=>	array('Option 1','Option 2','Option 3'),
	'type'		=>	'checkbox',
	'name'		=>	array('se_connecter','se_deconnecter','troisie'),
	'value'		=>	array( 'connect' , 'escape' , 'troisie' )
);

$fields[]		=	array(
	'label'		=>	"Une options",
	'placeholder'	=>	'Choissiez une option',
	'type'		=>	'select',
	'name'		=>	"select",
	'value'		=>	array( 'connect' , 'escape' , 'troisie' ),
	'text'		=>	array( 'connect' , 'escape' , 'troisie' )
);
for( $i = 0; $i < count( $fields ) ; $i++ ){
	gui_field( $fields[ $i ] )->push_to( "espace_nom" );
}
/*$fields[]		=	array(
	'label'		=>	'Contenu',
	'type'		=>	'visual_editor',
	'name'		=>	'nom',
	'id'		=>	'mon_editeur'
);*/
gui_field( array(
	'label'		=>	'Contenu',
	'type'		=>	'visual_editor',
	'name'		=>	'nom',
	'id'		=>	'mon_editeur'
) )->push_to( 'super_nombre' );

unset( $config , $fields , $form );
$form			=	array(
	'action'		=>	'',
	'method'		=>	'POST',
	"submit_text"	=>	"Enregistrer",
	"reset_text"	=>	"Reinitialiser"
);
$fields[]		=	array(
	'label'		=>	'Nom',
	'type'		=>	'text',
	'name'		=>	'name'	
);
$fields[]		=	array(
	'label'		=>	'Contenu',
	'type'		=>	'visual_editor',
	'name'		=>	'nom_2',
	'id'		=>	'mon_Rediteur'
);
$fields[]		=	array(
	'label'		=>	'Nom',
	'type'		=>	'text',
	'name'		=>	'name'	
);
$config[]		=	array(
	'namespace'	=>	'hello_world_2',
	'type'		=>	'collapsible_panel',
	'title'		=>	'Hello World',
	'content'	=>	$fields,
	'form_wrap'	=>	$form
);
// $this->gui->col_push( 2 , $config );
$this->gui->get();
endif;