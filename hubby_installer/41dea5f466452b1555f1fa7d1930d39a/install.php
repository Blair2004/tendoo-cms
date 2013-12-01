<?php
$this->installSession();
$this->appType('MODULE');
$this->appVers(0.1);
$this->appHubbyVers(0.93);
$this->appTableField(array(
	'NAMESPACE'		=> 'hubby_index_mod',
	'HUMAN_NAME'	=> 'Gestion de la page d\'accueil',
	'AUTHOR'		=> 'Hubby Group',
	'DESCRIPTION'	=> 'Cette action permet de gerer la page d\'accueil, carrousel, publication du blog, témoignages.',
	'TYPE'			=> 'BYPAGE',
	'HUBBY_VERS'	=> 0.9
));
$this->appAction(array(
	'action'				=>	'hubby_index_mod',
	'action_name'			=>	'Gestion de la page d\'accueil',
	'action_description'	=>	'Cette action permet de gerer la page d\'accueil, carrousel, publication du blog, témoignages.',
	'mod_namespace'			=>	'hubby_index_mod'
));