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
	function theme_dir()
	{
		$CORE	=	Controller::instance();
		return $CORE->main_url().THEMES_DIR.$CORE->data['getTheme']['ENCRYPTED_DIR'];
	}
	function theme_assets_url($url)
	{
		$CORE	=	Controller::instance();
		return $CORE->url->main_url().'tendoo_dir/'.$CORE->data['getTheme']['ENCRYPTED_DIR'].'/'.$CORE->url->array2Url($url);
	}
	function js_push_if_not_exists($url)
	{
		$url	=	array_unshift($url,'script');
		$CORE	=	Controller::instance();
		$CORE->file->js_push_if_not_exists(theme_assets_url($url));
	}
	function css_push_if_not_exists($url)
	{
		$url	=	array_unshift($url,'css');
		$CORE	=	Controller::instance();
		$CORE->file->css_push_if_not_exists(theme_assets_url($url));
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