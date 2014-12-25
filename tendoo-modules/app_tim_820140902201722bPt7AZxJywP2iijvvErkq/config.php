<?php
declare_module( 'tim' , array( 
	'name'				=>		'Gestionnaire de la page d\'accueil',
	'author'			=>		'Tendoo Luminax Group',
	'description'		=>		'Personnaliser votre page d\'accueil. Ajouter, supprimer et ordonnez tous les éléments disponibles, afin de donner à votre page d\'accueil une apparence unique.',
	'has_widget'		=>		TRUE,
	'has_api'			=>		TRUE,
	'has_icon'			=>		TRUE,
	'handle'			=>		'INDEX',
	'compatible'		=>		1.3,
	'version'			=>		0.2
) ); 
push_module_action( 'tim' , array(
	'action'				=>	'tim_manage',
	'action_name'			=>	'Gestion de la page d\'accueil',
	'action_description'	=>	'Cette action donne accès à la gestion de la page d\'accueil.',
	'mod_namespace'			=>	'tim'
));