<?php
$WIDGET_CONFIG		=	array();
$WIDGET_CONFIG['aflecatdi']	=	array(
	'WIDGET_NAME'		=>	'Afficher les categorie disponible',	// nom du widget
	'WIDGET_NAMESPACE'		=>	'aflecatdi', // Espace nom du widget, il doit être unique.
	'WIDGET_FILES'			=>	'/widgets/category_lister.php',	//  Chemin d'acces au fichier
	'MODULE_NAMESPACE'		=>	'blogster',	// Espace nom du module sur lequel le widget test attaché.
	'WIDGET_MORE'			=>	'/more/widget_category_config.php'
);
$WIDGET_CONFIG['aflearlep']	=	array(
	'WIDGET_NAME'		=>	'Afficher les articles les plus lues',
	'WIDGET_NAMESPACE'		=>	'aflearlep',
	'WIDGET_FILES'			=>	'/widgets/most_readed_lister.php',
	'MODULE_NAMESPACE'		=>	'blogster',
	'WIDGET_MORE'			=>	'/more/widget_aflearlep_config.php'
);
$WIDGET_CONFIG['syslink']	=	array(
	'WIDGET_NAME'		=>	'Liens Syst&egrave;me',
	'WIDGET_NAMESPACE'		=>	'syslink',
	'WIDGET_FILES'			=>	'/widgets/sys_links.php',
	'MODULE_NAMESPACE'		=>	'blogster',
);
$WIDGET_CONFIG['comments']	=	array(
	'WIDGET_NAME'		=>	'Afficher les commentaires',
	'WIDGET_NAMESPACE'		=>	'comments',
	'WIDGET_FILES'			=>	'/widgets/comments.php',
	'MODULE_NAMESPACE'		=>	'blogster',
	'WIDGET_MORE'			=>	'/more/widget_comments_config.php'
);
$WIDGET_CONFIG['tags']	=	array(
	'WIDGET_NAME'		=>	'Afficher les mots clés',
	'WIDGET_NAMESPACE'		=>	'tags',
	'WIDGET_FILES'			=>	'/widgets/tags.php',
	'MODULE_NAMESPACE'		=>	'blogster',
	'WIDGET_MORE'			=>	'/more/widget_tags_config.php'
);