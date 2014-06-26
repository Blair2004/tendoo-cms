<?php
/*
	Tendoo 0.9.8 Only
	
	Alias des méthodes de l'objet users.php
		user([clé]), alias $this->instance->users_global->current([clé]);
		Recupère les informations de l'utilisateur actuellement connecté.
*/
	function user($info)
	{
		$instance	=	get_instance();
		return $instance->users_global->current($info);
	}