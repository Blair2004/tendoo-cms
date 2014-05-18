<?php
/*
	Tendoo 0.9.8 Only
	
	Facilite l'utilisation des ressources sans nécessairement avoir besoin d'utiliser l'objet Controller::instance();
	module_...()
	
	module_url()
		Renvoie l'url du module actuellement en cours d'exécution. Fait usage des méthodes $this->core->url... et du tableau $this->data;
*/
	function module_url($segments)
	{
		$CORE	=	Controller::instance();
		if(isset($CORE->data))
		{
			if(array_key_exists('module',$CORE->data))
			{
				if(is_array($segments))
				{
					return $CORE->url->site_url('admin/open/modules/'.$CORE->data['module'][0]['ID'].'/'.$CORE->url->array2Url($segments));
				}
				else
				{
					return $CORE->url->site_url('admin/open/modules/'.$CORE->data['module'][0]['ID'].'/'.$segments);
				}
			}
		}
		return false;
	}
	function site_datetime()
	{
		$CORE	=	Controller::instance();
		return $CORE->tendoo->datetime();
	}
	function site_options()
	{
		$CORE	=	Controller::instance();
		return $CORE->tendoo->getOptions();
	}
	function site_theme()
	{
		$CORE	=	Controller::instance();
		return $CORE->tendoo->getSiteTheme();
	}