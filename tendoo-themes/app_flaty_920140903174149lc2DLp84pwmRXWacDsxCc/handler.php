<?php 
class flaty_theme_handler extends Libraries
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
		theme_jpush('js/jquery');
		theme_jpush("js/bootstrap.min");
		theme_jpush("js/html5shiv");
		theme_jpush("js/jquery.prettyPhoto");
		theme_jpush("js/jquery.isotope.min");
		theme_jpush("js/respond.min");
		theme_jpush("js/main");

		theme_cpush("css/bootstrap.min");
		theme_cpush("css/font-awesome.min");
		theme_cpush("css/animate");
		theme_cpush("css/prettyPhoto");
		theme_cpush("css/main");
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
	/*
	/*	Méthode Gallery ShowCase
	*/
	private $galleryShowCaseTitle	=	'Gallery Showcase';
	private $galleryGroup			=	array();
	private $galleryDescription		=	'';
	public function defineGalleryDescription($description)
	{
		$this->galleryDescription	=	$description;
	}
	public function defineGalleryShowCaseTitle($title)
	{
		$this->galleryShowCaseTitle	=	$title;
	}
	public function defineGalleryShowCase($title,$description,$thumb,$full,$link,$timestamp,$author = array(),$categories = array())
	{
/*PUSH_GALLERY_JS_IF_NOT_EXISTS*/
/*PUSH_GALLERY_CSS_IF_NOT_EXISTS*/
		$this->galleryGroup[]		=	array(
			'TITLE'					=>	$title,
			'DESCRIPTION'			=>	$description,
			'THUMB'					=>	$thumb,
			'FULL'					=>	$full,
			'LINK'					=>	$link,
			'TIMESTAMP'				=>	$timestamp,
			'AUTHOR'				=>	$author,
			'CATEGORIES'			=>	$categories
		);
	}
	private function parseGalleryShowCase() // Ok
	{
		$this->include_item('index.gallery_showcase');
	}
	/*
	/*	Carousel Element
	*/
	private $carousselElement	=	array();
	private $carousselTitle		=	'';
	private $carousselDescription	=	'';
	public function defineCarousselDescription($description)
	{
		$this->carousselDescription	=	$description;
	}
	public function defineCarousselTitle($title)
	{
		$this->carousselTitle	=	$title;
	}
	public function defineCaroussel($title,$content,$image,$link,$timestamp) // Ok
	{
/*PUSH_CAROUSSEL_JS_IF_NOT_EXISTS*/
/*PUSH_CAROUSSEL_CSS_IF_NOT_EXISTS*/
		$this->carousselElement[]	=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content,
			'IMAGE'					=>	$image,
			'DATETIME'				=>	$timestamp,
			'LINK'					=>	$link
		);
	}
	private function parseCaroussel()
	{
		$this->include_item('index.parse_caroussel');
	}
	/*
	/*	Ontop Content
	*/
	private $onTopContentTitle	=	'Featured Title';
	private $onTopContent		=	array();
	private $onTopContentDescription	=	'';
	public function defineOnTopContentDescription($description)
	{
		$this->onTopContentDescription	=	$description;
	}
	public function defineOnTopContentTitle($title)
	{
		$this->onTopContentTitle	=	$title;
	}
	public function defineOnTopContent($thumb,$title,$content,$link,$timestamp,$author = '',$categories = array()) // Ok
	{
/*PUSH_ONTOPCONTENT_JS_IF_NOT_EXISTS*/
/*PUSH_ONTOPCONTENT_CSS_IF_NOT_EXISTS*/
		$this->onTopContent[]	=	array(
			'THUMB'				=>	$thumb,
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link,
			'DATETIME'			=>	$timestamp,
			'AUTHOR'			=>	$author,
			'CATEGORIES'		=>	$categories // est un tableau.
		);
	}
	private function parseOnTopContent()
	{
		$this->include_item('index.parse_onTopContent');
	}
	/*
	/* Lastest content new (0.9.4)
	*/
	private $lastestElementsTitle	=	'Lastest';
	private $lastestElements		=	array();
	private $lastestElementsDescription	=	'';
	public function defineLastestElementsDescription($description)
	{
		$this->lastestElementsDescription	=	$description;
	}
	public function defineLastestElementsTitle($title)
	{
		$this->lastestElementsTitle	=	$title;
	}
	public function defineLastestElements($thumb,$title,$content,$link,$timestamp,$author = '')
	{
/*PUSH_LASTESTELEMENT_JS_IF_NOT_EXISTS*/
/*PUSH_LASTESTELEMENT_CSS_IF_NOT_EXISTS*/
		$this->lastestElements[]	=	array(
			'THUMB'				=>	$thumb,
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link,
			'DATETIME'			=>	$timestamp,
			'AUTHOR'			=>	$author
		);
	}
	private function parseLastestElements()
	{
		$this->include_item('index.parse_lastestElements');
	}
	/*
	/*	Signature element	
	*/
	private $indexAboutUs;
	private $indexAboutUsTitle			=	"Abous Us";
	private $indexAboutUsDescription	=	'';
	public function defineIndexAboutUs($content)
	{
		$this->indexAboutUs	=	$content;
	}
	public function defineIndexAboutUsDescription($description)
	{
		$this->indexAboutUsDescription	=	$description;
	}
	public function defineIndexAboutUsTitle($title)
	{
		$this->indexAboutUsTitle	=	$title;
	}
	private function parseIndexAboutUs()
	{
		$this->include_item('index.parse_aboutUs');
	}
	/*
	/*	Partner about us
	*/
	private $partners_title			=	'Our Partners';
	private $partners_content;
	private $partners_description	=	'';
	public function definePartnersTitle($title)
	{
		$this->partners_title	=	$title;
	}
	public function definePartnersDescription($description)
	{
		$this->partners_description	=	$description;
	}
	public function definePartnersContent($content)
	{
		$this->partners_content	=	$content;
	}
	private function parsePartners()
	{
		$this->include_item('index.parse_partners');
	}
	/*
	/*	Text List Showcase
	*/
	private $listText				=	array();
	private $textListTitle			=	'Sample text';
	private $textListDescription	=	'';
	public function defineTextListTitle($title)
	{
		$this->textListTitle			=	$title;
	}
	public function defineTextListDescription($description)
	{
		$this->textListDescription		=	$description;
	}
	public function defineTextList($title,$content,$thumb,$link,$timestamp)
	{
		$this->listText[]	=	array(
			'TITLE'				=>	$title,
			'CONTENT'			=>	strip_tags($content),
			'THUMB'				=>	$thumb,
			'LINK'				=>	$link,
			'TIMESTAMP'			=>	$timestamp
		);
	}
	public function parseTextList() // Ok
	{
		$this->include_item('index.parse_textList');
	}
	/*
	/*	Tab show case
	*/
	private $tabShowCase		=	array();
	private $tabShowCaseTitle	=	'Tab Show Case';
	private $tabShowCaseDescription	=	'';
	public function defineTabShowCaseDescription($description)
	{
		$this->tabShowCaseDescription	=	$description;
	}
	public function defineTabShowCaseTitle($title)
	{
		$this->tabShowCaseTitle	=	$title;
	}
	public function defineTabShowCase($title,$content,$link = '#') // Ok
	{
		$this->tabShowCase[]	=	array(
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link
		);
	}
	private function parseTabShowCase()
	{
		$this->include_item('index.parse_tabShowCase');
	}
	/*
	/*	Méthode chargement du prototype de la page d'accueil.
	*/
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
	public function page-404()
	{
		$this->include_template( 'page-404' );
	}
	public function page( $content = '' )
	{
		set_active_theme_vars( 'page_content' , $content );
		$this->include_template( 'page' );
	}
}