<?php
class blogster_tepas_class extends Libraries
{
	public function __construct($data)
	{
		parent::__construct();
		__extends($this);
		$this->module	=	get_modules( 'filter_namespace' , 'blogster' );
		$this->load->library('tendoo_admin',null,'admin');
		if(defined('SCRIPT_CONTEXT'))
		{
			if(SCRIPT_CONTEXT == 'ADMIN')
			{
				$this->admin_context();
				// get_instance()->tendoo_admin->system_not('2 Nouveaux commentaires disponibles', 'Deux nouveaux commentaires sont dans la liste d\'attentes des [Lire la suite] ', '#', '10 mai 2013', null);
			}
			else
			{
				$this->public_context();
			}
			$this->both_context();
		}
	}
	public function admin_context()
	{
		// Creating Menu 1.4
		add_admin_menu( 'before' , 'menu' , array(
			'title'		=>	'Articles',
			'href'		=>	module_url( array( 'index' ) , 'blogster'  ),
			'childs'	=>	array(
				array(
					'title'	=>	'Ajouter un article', 
					'href'	=>	module_url( array( 'publish' ) , 'blogster' )
				),
				array(
					'title'	=>	'Ajouter une categorie', 
					'href'	=>	module_url( array( 'category', 'create' ) , 'blogster' )
				),
				array(
					'title'	=>	'Gestion des categories', 
					'href'	=>	module_url( array( 'category' ) , 'blogster' )
				),
				array(
					'title'	=>	'Gestion des commentaires', 
					'href'	=>	module_url( array( 'comments' ) , 'blogster' )
				),
				array(
					'title'	=>	'Gestion des mots-clés', 
					'href'	=>	module_url( array( 'tags' ) , 'blogster' )
				),
				array(
					'title'	=>	'Réglages', 
					'href'	=>	module_url( array( 'setting' ) , 'blogster' )
				)
			)
		) );
		declare_admin_widget(array(
			"module_namespace"		=>	"blogster",
			"widget_namespace"		=>	"articles_stats",
			"widget_title"			=>	"Statistiques de Blogster",
			"widget_content"		=>	$this->load->view(MODULES_DIR.$this->module['encrypted_dir'].'/views/widgets/articles_stats',null,true,true),
			"widget_description"	=>	'Affiche les statistiques sur Blogster'
		));
		declare_admin_widget(array(
			"module_namespace"		=>	"blogster",
			"widget_namespace"		=>	"recents_commentaires",
			"widget_title"			=>	"Commentaires récents",
			"widget_content"		=>	$this->load->view(MODULES_DIR.$this->module['encrypted_dir'].'/views/widgets/recents_comments',null,true,true),
			"widget_description"	=>	'Affiche les commentaires récents',
			"action_control"		=>	module_action('blogster','blogster_manage_comments')
		));
	}
	public function public_context()
	{
		if( function_exists('declare_shortcut') && get_instance()->users_global->isConnected()){
			if($this->admin->actionAccess('publish_news',$this->module['namespace']))
			{
				declare_shortcut('Ecrire un article',$this->url->site_url(array('admin','open','modules',$this->module['namespace'],'publish')));
			}
			if($this->admin->actionAccess('category_manage',$this->module['namespace']))
			{
				declare_shortcut('Liste des catégories',$this->url->site_url(array('admin','open','modules',$this->module['namespace'],'category')));
			}
		}
	}
	public function both_context()
	{
		// Declaring API_RECENT_POST
		$file	= $this->module[ 'uri_path' ] . 'api/recentspost.php';
		if( is_file( $file ) ){
			
			include_once( $file );
			$this->library = new blogster_recentspost_api($this->module);
			
			declare_api( 'blogster_get_blog_post' , 'Articles récents du blog' , array( $this->library , "getDatas" ) );
		}
		// Declaring API_FEATURED_POST
		$file	= $this->module[ 'uri_path' ] . 'api/featuredpost.php';
		if( is_file( $file ) ){
			
			include_once( $file );
			$this->library = new blogster_featuredpost_api($this->module);
			
			declare_api( 'blogster_get_featured_blog_post' , 'Les meilleurs articles du blog' , array( $this->library , "getDatas" ) );
		}
	}
}
