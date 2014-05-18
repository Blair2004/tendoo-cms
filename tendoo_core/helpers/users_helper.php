<?php
/*
	Tendoo 0.9.8 Only
	
	Alias des méthodes de l'objet users.php
		user([clé]), alias $this->core->users_global->current([clé]);
		Recupère les informations de l'utilisateur actuellement connecté.
*/
	function user($info)
	{
		$CORE	=	Controller::instance();
		return $CORE->users_global->current($info);
	}