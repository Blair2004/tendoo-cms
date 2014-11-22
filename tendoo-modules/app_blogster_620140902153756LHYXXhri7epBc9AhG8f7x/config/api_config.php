<?php
$API_CONFIG		=	array();
$API_CONFIG['showcategory']	=	array(
	'API_NAME'		=>	'Blogster - Afficher les cat&eacute;gories',	// nom du widget
	'API_NAMESPACE'			=>	'showcategory', // Espace nom du widget, il doit être unique.
	'API_CLASS_FILE'		=>	'/api/showcategory.php',	//  Chemin d'acces au fichier
	'API_MODULE_NAMESPACE'	=>	'news'	// Espace nom du module sur lequel le widge test attaché.
);
$API_CONFIG['featuredpost']	=	array(
	'API_NAME'		=>	'Blogster - Afficher les articles les plus lues',	// nom du widget
	'API_NAMESPACE'			=>	'featuredpost', // Espace nom du widget, il doit être unique.
	'API_CLASS_FILE'		=>	'/api/featuredpost.php',	//  Chemin d'acces au fichier
	'API_MODULE_NAMESPACE'	=>	'news'	// Espace nom du module sur lequel le widge test attaché.
);
$API_CONFIG['recentspost']	=	array(
	'API_NAME'		=>	'Blogster - Afficher les articles récents',	// nom du widget
	'API_NAMESPACE'			=>	'recentspost', // Espace nom du widget, il doit être unique.
	'API_CLASS_FILE'		=>	'/api/recentspost.php',	//  Chemin d'acces au fichier
	'API_MODULE_NAMESPACE'	=>	'news'	// Espace nom du module sur lequel le widge test attaché.
);
