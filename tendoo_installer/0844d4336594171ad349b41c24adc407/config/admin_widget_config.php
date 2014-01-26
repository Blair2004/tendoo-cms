<?php
$ADMIN_WIDGET_CONFIG		=	array();
$ADMIN_WIDGET_CONFIG['quickpost']	=	array(
	'WIDGET_HUMAN_NAME'		=>	'Quick Blog',	// nom du widget
	'WIDGET_NAMESPACE'		=>	'quickpost', // Espace nom du widget, il doit être unique.
	'WIDGET_DESCRIPTION'	=>	'Faire rapidement des nouvelles publications, sans ouvrir le module.', // Espace nom du widget, il doit être unique.
	'WIDGET_FILES'			=>	'/admin_widgets/quickblog.php',	//  Chemin d'acces au fichier
	'MODULE_NAMESPACE'		=>	$module['NAMESPACE']	// Espace nom du module sur lequel le widge test attaché.
);