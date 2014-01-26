<?php
class syslink_news_common_widget
{
	public function __construct($data)
	{
		$this->core		=	Controller::instance();
		$this->data		=&	$data;
		$this->theme	=&	$this->data['theme'];
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['ENCRYPTED_DIR'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		$this->news		=	new News_smart;
		$this->data['mostViewed']	=	$this->news->getMostViewed(0,10);
		$end			=	'<ul>';
		if($this->core->users_global->isConnected())
		{
			$this->core->load->library('Tendoo_admin');
			if($this->core->users_global->isAdmin())
			{
				$priv	=	$this->core->users_global->current('PRIVILEGE');
				if($this->core->users_global->isSuperAdmin())
				{
					$end		.=	'<li><a href="'.$this->core->url->site_url(array('admin','modules')).'">Liste des modules</a></li>';
					$end		.=	'<li><a href="'.$this->core->url->site_url(array('admin','setting')).'">Param&egrave;tres</a></li>';
					$end		.=	'<li><a href="'.$this->core->url->site_url(array('admin','system','manage_actions')).'">Gestion d\'actions</a></li>';
					$end		.=	'<li><a href="'.$this->core->url->site_url(array('admin','installer')).'">Installer une application</a></li>';
				}
				else if(!$this->core->tendoo_admin->isPublicPriv($priv))
				{
					$end		.=	'<li><a href="'.$this->core->url->site_url(array('admin')).'">Espace administration</a></li>';
				}
			}
			$end		.=	'<li><a href="'.$this->core->url->site_url(array('account')).'">Mon profil</a></li>';
			$end		.=	'<li><a href="'.$this->core->url->site_url(array('account','messaging','home')).'">Ma messagerie</a></li>';
		}
		else
		{
			$options	=	$this->core->tendoo->getOptions();
			if($options[0]['ALLOW_REGISTRATION'] == '1')
			{
				$end		.=	'<li><a href="'.$this->core->url->site_url(array('registration')).'">Inscription</a></li>';
			}
			$end		.=	'<li><a href="'.$this->core->url->site_url(array('login')).'">Connexion</a></li>';
		}
		$end			.=	'</ul>';
		$this->theme->defineWidget($this->data['currentWidget']['WIDGET_INFO']['WIDGET_HEAD'],$end);
	}
}