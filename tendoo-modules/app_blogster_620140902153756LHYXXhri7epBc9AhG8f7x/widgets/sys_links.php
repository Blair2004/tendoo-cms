<?php
class syslink_blogster_common_widget
{
	public function __construct($data)
	{
		$this->instance		=	get_instance();
		$this->data		=&	$data;
		$this->theme	=	get_core_vars('active_theme_object');
		$this->location	=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['encrypted_dir'];
		
		if(!class_exists('News_smart'))
		{
			include_once($this->location.'/library.php');
		}
		$this->news		=	new News_smart;
		$this->data['mostViewed']	=	$this->news->getMostViewed(0,10);
		$end			=	'<ul>';
		if($this->instance->users_global->isConnected())
		{
			$this->instance->load->library('tendoo_admin');
			if($this->instance->users_global->isAdmin())
			{
				$priv	=	$this->instance->users_global->current('REF_ROLE_ID');
				if($this->instance->users_global->isSuperAdmin())
				{
					$end		.=	'<li><a href="'.$this->instance->url->site_url(array('admin','modules')).'">Liste des modules</a></li>';
					$end		.=	'<li><a href="'.$this->instance->url->site_url(array('admin','setting')).'">Param&egrave;tres</a></li>';
					$end		.=	'<li><a href="'.$this->instance->url->site_url(array('admin','system','manage_actions')).'">Gestion d\'actions</a></li>';
					$end		.=	'<li><a href="'.$this->instance->url->site_url(array('admin','installer')).'">Installer une application</a></li>';
				}
				else if(!$this->instance->tendoo_admin->is_public_role($priv))
				{
					$end		.=	'<li><a href="'.$this->instance->url->site_url(array('admin')).'">Espace administration</a></li>';
				}
			}
			$end		.=	'<li><a href="'.$this->instance->url->site_url(array('account')).'">Mon profil</a></li>';
			$end		.=	'<li><a href="'.$this->instance->url->site_url(array('account','messaging','home')).'">Ma messagerie</a></li>';
		}
		else
		{
			$options	=	get_meta( 'all' );
			if( riake( 'allow_registration' , $options ) == '1')
			{
				$end		.=	'<li><a href="'.$this->instance->url->site_url(array('registration')).'">Inscription</a></li>';
			}
			$end		.=	'<li><a href="'.$this->instance->url->site_url(array('login')).'">Connexion</a></li>';
		}
		$end			.=	'</ul>';
		// For Zones
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$widget_title	=	$this->data['currentWidget'][ 'WIDGET_INFO' ][ 'WIDGET_TITLE' ];
			$zone			=	$this->data['widgets']['requestedZone']; // requestedZone
			set_widget( strtolower($zone) , $widget_title , $end , 'text' );
		}
	}
}