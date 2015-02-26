<?php 
class tendoo_theme_handler extends Libraries
{
	public function __construct()
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
    	__extends( $this );
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->instance						=	get_instance();
        $this->theme						=	get_core_vars('active_theme');
		$this->data							=	array();
        // Inclusion du ficher "library.php".		
        if(file_exists(THEMES_DIR.$this->theme['encrypted_dir'].'/library.php'))
        {
			include_once(THEMES_DIR.$this->theme['encrypted_dir'].'/library.php');
		}       
		$this->output_files(); 
	}
	private function output_files()
	{
		theme_jpush('js/jquery-1.11.0');
		theme_jpush("js/bootstrap.min");

		theme_cpush("css/bootstrap");
		theme_cpush("css/bootstrap-responsive");
		theme_cpush("css/font-awesome.min");
	}
    public function view($path,$do = "showDirectly")
	{
		$file	=	THEMES_DIR.$this->theme['encrypted_dir'].'/'.$path.'.php';
		if(file_exists($file))
		{
        	// Converting $this->data key to vars
            foreach($this->data as $key	=>	 $value)
            {
            	$$key	=	$value;
            }
			ob_start();
			include($file);
			$content	=	ob_get_clean();
			if($do == 'returnContent')
			{
				return $content;
				
			}
			else if($do == 'showDirectly')
			{
				echo $content;
                return true;
			}
		}
        else
        {
			$this->tendoo->error('Unable to load : '.$file);
            return false;
        }
	}
	/**
		Méthodes de chargement des fichiers de base.
			header($data) // Charge l'entête de la page avec le menu et le logo.
			head($data)// charge l'entête du document avec les balises titles et opère chargement des fichiers css ou js.
			footer($data) // charge le pied de la page.
			body($data) // charge le corps de la page.
	**/
	public function header($data)
	{
        return $this->view('templates/header','returnContent');
	}
	public function footer($data)
	{
        return $this->view('templates/footer','returnContent');
	}
	public function head($data)
	{
		$this->data	=	array_merge($this->data,$data);
       	$this->view('templates/head');
	}
	public function body($data)
	{
		$this->data						=	array_merge($this->data,$data);
		set_core_vars( 'theme_header' ,	$this->header($this->data) );
		set_core_vars( 'theme_footer' , $this->footer($this->data) );
        $this->view('templates/body');
	}
	/**
		Méthode : Inclusion des fichiers dans le dossiers "extends/items/". Ne prend que le nom du fichier en paramètre sans extension.
	**/
	public function include_item($item,$array = array())
	{
		include(THEMES_DIR.$this->theme['encrypted_dir'].'/items/'.$item.'.php');
		/*
			Procédé de recupération des fichiers
				define[...] pour définir l'item qui est enregistré
				parse[...] pour recupéré l'item préalablement définit.
		*/
	}
	public function include_template($item,$array = array())
	{
		include(THEMES_DIR.$this->theme['encrypted_dir'].'/templates/'.$item.'.php');
		/*
			Procédé de recupération des fichiers
				define[...] pour définir l'item qui est enregistré
				parse[...] pour recupéré l'item préalablement définit.
		*/
	}
	/*
	/*	Méthodes communues
	*/
	private $pageTitle			=	'Page Sans Titre'; // Titre de la page
	private $pageDescription	= ''; // Description de la page
	private $pageKeywords		=	'';
	public function definePageTitle($title) // Définir le titre de la page
	{
		$this->pageTitle	=	$title;
	}
	public function definePageDescription($description) // définir la description de la page
	{
		$this->pageDescription	=	$description;
	}
	public function definePageKeywords($keywords)
	{
		$this->pageKeywords	=	$keywords;
	}
	public function home()
	{
		$this->include_template('home');
	}
	/*
	/*	End
	*/
	/*
	/*	Blogs et publications
	*/
	public function blog_posts() // Tendoo 1.2
	{
		$this->include_template('blog.posts');
	}
	/*
	/*	Single Blog post With comments
	*/
	public function blog_single()
	{
		$this->include_template('blog.single');
	}
	/*
	/*	Single Blog post With comments
	*/
	public function contact()
	{
		$this->include_template('blog.single');
	}
	/*
	/*	sidebar
	*/
	public function sidebar_right()
	{
		$this->include_template('sidebar.right');
	}
	public function sidebar_left()
	{
		$this->include_template('sidebar.left');
	}
	public function sidebar_bottom()
	{
		$this->include_template('sidebar.bottom');
	}
	/*
	/* 	Define Unique  : Page sans élément. (peut toutefois avoir les méthodes parseLeftWidgets(), parseRigthWidgets() ou parseBottomWidgets()).
	*/
	private $uniqueContent				=	'';
	public function defineUnique($content)
	{
		$this->uniqueContent			=	$content;
	}
	public function parseUnique()
	{
		$this->include_item('unique.parse');
	}
	/*
	/*	Définition du contact
	*/
	private $contactAddress				=	'';
	private $contactTitle				=	"Our Contact"; // Texte par défaut.
	private $contactContent				=	'';
	private $contactAddressItems		=	array();
	private $contactHeader				=	array('ACTION'	=>	'',	'ENCTYPE'	=>	'multipart/form-data',	'METHOD'	=>	'POST');
	public function defineContactAddress($title,$content)
	{
		$this->contactTitle				=	$title;
		$this->contactAddress			=	$content;
	}
	public function defineContactContent($content)
	{
		$this->contactContent			=	$content;
	}
	public function defineContactAddressItem($type,$content)
	{
		if(in_array($type,array('email','mobile','phone','address','fax','skype','facebook','googleplus','twitter','road','country','city')))
		{
			$this->contactAddressItems[]	=	array(
				'TYPE'						=>	$type,
				'CONTENT'					=>	$content
			);
		}
	}
	public function defineContactFormHeader($action="",$enctype="multipart/form-data",$method="POST")
	{
		$this->contactHeader['ACTION']	=	$action;
		$this->contactHeader['ENCTYPE']	=	$enctype;
		$this->contactHeader['METHOD']	=	$method;
	}
	public function parseContact()
	{
		$this->include_item('contact.parse');
	}
	/*
	/*	Notice : Recupèrera les notifications passées sur l'objet du noyau "notice".
	*/
	public function parseNotice()
	{
		$this->include_item('notice');
	}	
	public function page404()
	{
		$this->include_template( 'page404' );
	}
	public function page( $content = '' )
	{
		set_active_theme_vars( 'page_content' , $content );
		$this->include_template( 'page' );
	}
}