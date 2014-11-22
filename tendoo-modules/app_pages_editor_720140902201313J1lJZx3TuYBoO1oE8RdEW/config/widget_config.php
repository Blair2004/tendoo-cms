<?php
$WIDGET_CONFIG		=	array();
$WIDGET_CONFIG['hierarchy']	=	array(
	'WIDGET_NAME'		=>	'Afficher la hiérarchie des pages',	// nom du widget
	'WIDGET_NAMESPACE'		=>	'hierarchy', // Espace nom du widget, il doit être unique.
	'WIDGET_FILES'			=>	'/widgets/show_page_hierarchy.php',	//  Chemin d'acces au fichier
	'MODULE_NAMESPACE'		=>	$module[ 'namespace' ],
	'WIDGET_MORE'			=>	'/more/show_page_hierarchy_config.php'
);
/**
$WIDGET_CONFIG['show_page_hierarchie']	=	array(
	'WIDGET_NAME'		=>	'Afficher la hiérarchie des pages',	// nom du widget
	'WIDGET_NAMESPACE'		=>	'show_page_hierarchie', // Espace nom du widget, il doit être unique.
	'WIDGET_FILES'			=>	'/widgets/show_page_hierarchy.php',	//  Chemin d'acces au fichier
	'MODULE_NAMESPACE'		=>	$module['NAMESPACE'],	// Espace nom du module sur lequel le widget test attaché.
	'WIDGET_MORE'			=>	'/more/widget_category_config.php'
);
**/