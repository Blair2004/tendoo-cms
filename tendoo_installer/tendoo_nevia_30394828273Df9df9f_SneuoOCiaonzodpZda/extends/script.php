<?php 
class nevia_theme_handler
{
	// Designed With 2TB
	public function __construct($data)
	{
        // Recupération des données envoyé par le system.
		$this->data							=	$data;
        // Extension de l'objet et  mise à jour du noyau.
    	__extends($this);
        // Définition des informations du thème.
        $this->theme						=	$this->data['activeTheme'];
        // Inclusion du ficher "library.php".		
        if(file_exists(THEMES_DIR.$this->theme['ENCRYPTED_DIR'].'/library.php'))
        {
			include_once(THEMES_DIR.$this->theme['ENCRYPTED_DIR'].'/library.php');
		}        
		theme_jpush("js/globals/jquery.min");
		theme_jpush("js/globals/jquery.contact");
		theme_jpush("js/globals/jquery.easing.1.3");
		theme_jpush("js/globals/jquery.fancybox.min");
		theme_jpush("js/globals/jquery.flexslider");
		theme_jpush("js/globals/jquery.gmap.min");
		theme_jpush("js/globals/jquery.isotope.min");
		theme_jpush("js/globals/jquery.jcarousel");
		theme_jpush("js/globals/jquery.layerslider-transitions");
		theme_jpush("js/globals/jquery.layerslider.min");
		theme_jpush("js/globals/jquery.modernizr");
		theme_jpush("js/globals/jquery.selectnav");
		theme_jpush("js/globals/jquery.shop");
		theme_jpush("js/globals/jquery.transit-modified");
		theme_jpush("js/globals/script");
		theme_jpush("js/globals/switcher");
		theme_jpush("js/globals/custom");


		theme_cpush("css/globals/base");
		theme_cpush("css/globals/icons");
		theme_cpush("css/globals/responsive");
		theme_cpush("css/globals/style");

	}
    public function view($path,$do = "showDirectly")
	{
		$file	=	THEMES_DIR.$this->theme['ENCRYPTED_DIR'].'/'.$path.'.php';
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
		$this->data	=	array_merge($this->data,$data);
        return $this->view('default/header','returnContent');
	}
	public function footer($data)
	{
		$this->data	=	array_merge($this->data,$data);
        return $this->view('default/footer','returnContent');
	}
	public function head($data)
	{
		$this->data	=	array_merge($this->data,$data);
       	$this->view('default/head');
	}
	public function body($data)
	{
		$this->data						=	array_merge($this->data,$data);
		$this->data['header']			=	$this->header($this->data);
		$this->data['footer']			=	$this->footer($this->data);
        $this->view('default/body');
	}
	/**
		Méthode : Pagination.
	**/
	private $pagination_datas;
	public function set_pagination_datas($data)
	{
		// Définition du premier lien
		$this->pagination_datas['firstLink']		=	isset($data['firstLink']) 	? $data['firstLink'] : "null";
		$this->pagination_datas['firstLinkText']	=	isset($data['firstLinkText']) ? $data['firstLinkText'] : "null";
		// Définition d'un lien
		$this->pagination_datas['LinkText']			=	isset($data['LinkText']) ? $data['LinkText'] : "null";
		$this->pagination_datas['lastLinkText']		=	isset($data['lastLinkText']) ? $data['lastLinkText'] : "null";
		// Nombre de pages
		$this->pagination_datas['totalPage']		=	isset($data['totalPage']) ? $data['totalPage'] : "Non sp&eacute;cifi&eacute;";
		// définition du lien actif
		$this->pagination_datas['activeLink']		=	isset($data['activeLink']) ? $data['activeLink'] : "Non sp&eacute;cifi&eacute;";
		$this->pagination_datas['activeLinkText']	=	isset($data['activeLinkText']) ? $data['activeLinkText'] : "Texte non sp&eacute;cifi&eacute;";
		// Définition de l'inner link
		$this->pagination_datas['innerLink']		=	isset($data['innerLink']) ? $data['innerLink'] : "Liens non sp&eacute;cifi&eacute;";
		// Définition du lien actif [avancé].
		$this->pagination_datas['currentPage']		=	isset($data['currentPage']) ? $data['currentPage'] : "page non sp&eacute;cifi&eacute;";
	}
	/**
	Récupération des fichiers pagination.
	**/
	public function pagination()
	{
		$this->include_item('pagination');
	}
	/**
		Méthode : Inclusion des fichiers dans le dossiers "extends/items/". Ne prend que le nom du fichier en paramètre sans extension.
	**/
	public function include_item($item,$array = array())
	{
		include(THEMES_DIR.$this->theme['ENCRYPTED_DIR'].'/extends/items/'.$item.'.php');
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
	public function parseIndex()
	{
		$this->include_item('index.parse');
	}
	/*
	/*	End
	*/
	/*
	/*	Blogs et publications
	*/
	private $blogPostTitle		=	'Blog posts';
	private $blogPost			=	array();
	public function defineBlogPostTitle($title)
	{
		$this->blogPostTitle	=	$title;
	}
	public function defineBlogPost($title,$content,$thumb,$full,$author,$link,$timestamp,$categories	=	array(),$comments	=	false,$keywords = array())
	{
/*PUSH_BLOGPOST_JS_IF_NOT_EXISTS*/
/*PUSH_BLOGPOST_CSS_IF_NOT_EXISTS*/
		$this->blogPost[]		=	array(
			'AUTHOR'			=>	$author, // est un tableau associatif [PSEUDO],[ID],[EMAIL] ...
			'CONTENT'			=>	$content,
			'THUMB'				=>	$thumb,
			'FULL'				=>	$full,
			'LINK'				=>	$link,
			'TITLE'				=>	$title,
			'TIMESTAMP'			=>	$timestamp,
			'CATEGORIES'		=>	$categories, // forme array('TITLE'	=>	'','LINK'	=>	'', 'DESCRIPTION'	=>	'');
            'KEYWORDS'			=>	$keywords, // array('TITLE' => '', 'LINK' =>	'', 'DESCRIPTION' 	=> '');
			'COMMENTS'			=>	$comments
		);
	}
	private function parseBlogPost()
	{
		$this->include_item('blog.parse_post');
	}
	/*
	/*	Single Blog post With comments
	*/
	private $singleBlogPost			=	array();
	private $singleBlogPostComments	=	array();
	private $replyForms				=	array();
	private $replyFormTitle			=	'R&eacute;pondre';
	public function defineSingleBlogPost($title,$content,$thumb,$full,$author,$timestamp,$categories	=	array(),$keywords	=	array())
	{
/*PUSH_SINGLEBLOGPOST_JS_IF_NOT_EXISTS*/
/*PUSH_SINGLEBLOGPOST_CSS_IF_NOT_EXISTS*/
		$this->singleBlogPost		=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content,
			'THUMB'					=>	$thumb,
			'FULL'					=>	$full,
			'AUTHOR'				=>	$author,
			'TIMESTAMP'				=>	$timestamp,
			'CATEGORIES'			=>	$categories,
            'KEYWORDS'				=>	$keywords // array('TITLE' => '', 'LINK' =>	'', 'DESCRIPTION' 	=> '');
		);
	}
	private $SBP_comments			=	array();
	private $TT_SBP_comments		=	0;
	public function defineSBP_comments($author,$authorLink,$content,$timestamp) // define single blog post comments
	{
		$this->SBP_comments[]		=	array(
			'AUTHOR'				=>	$author,
			'AUTHORLINK'			=>	$authorLink,
			'CONTENT'				=>	$content,
			'TIMESTAMP'				=>	$timestamp
		);
	}
	public function defineTT_SBP_comments($ttSBP_comments)
	{
		if(is_int($ttSBP_comments))
		{
			$this->TT_SBP_comments	=	$ttSBP_comments;
		}
		else
		{
			$this->TT_SBP_comments	=	0;
		}
	}
	public function defineReplyFormTitle($title)
	{
		$this->replyFormTitle		=	$title;
	}
	public function defineSBP_replyForm($text,$name,$placeholder)
	{
		$this->replyForms[]			=	array(
			'TEXT'					=>	$text,
			'NAME'					=>	$name,
			'PLACEHOLDER'			=>	$placeholder
		);
	}
	private function parseSingleBlogPost()
	{
		$this->include_item('blog.parse_singlePost');
	}
	/*
	/*	Parse Blog page
	*/
	public function parseBlog()
	{
		$this->include_item('blog.parse');
	}
	/*
		Méthode : Générateur de formulaire.
			Utilisaiton : 
			...->defineForm(array(
				"text"			=>		"mon lien",
				"name"			=>		"nom_du_champ",
				"subtype"		=>		"submit" (peut prendre les valeurs : "submit","reset","button". Sous type de l'élément. correspond à l'attribut "type" d'un élément "input".)
				"value"			=>		"" // valeur du champ,
				"placeholder"	=>		"" // valeur pré remplie du champ.
				"type"			=>		"textarea" // ou non définit, "subtype" sera utilisé à la place. l'élément sera donc forcément un "input" ou "select"
			));
	*/
	private $currentForm			=	array();
	public function defineForm($a)
	{
		if(array_key_exists('text',$a))
		{
			$text	=	'<label>'.$a['text'].'</label>';
		}
		else
		{
			$text	=	'';
		}
		if(array_key_exists('name',$a))
		{
			$name	=	'name="'.$a['name'].'"';
		}
		else
		{
			$name	=	'';
		}
		if(array_key_exists('subtype',$a))
		{
			if(in_array($a['subtype'],array('submit','reset','button')))
			{
			$subtype	=	'class="comment_submit" type="'.$a['subtype'].'"';
			}
			else
			{
			$subtype	=	'class="comment_input_bg" type="'.$a['subtype'].'"';
			}
		}
		else
		{
			$subtype	=	'';
		}
		if(array_key_exists('value',$a))
		{
			$value	=	'value="'.$a['value'].'"';
		}
		else
		{
			$value	=	'';
		}
		if(array_key_exists('placeholder',$a))
		{
			$name	.=	' placeholder="'.$a['placeholder'].'" ';
		}
		else
		{
			$name	.=	' ';
		}
		if(array_key_exists('type',$a))
		{
			if($a['type']	==	'textarea')
			{
				$balise	=	'<textarea class="comment_textarea_bg" '.$name.'>'.$value.'</textarea>';
			}
			else
			{
				if(array_key_exists('subtype',$a))
				{
					if(in_array($a['subtype'],array('submit','reset','button')))
					{
					$balise	=	'<input '.$name.' '.$subtype.' '.$value.'/>';
					}
					else
					{
					$balise	=	'<input '.$name.' '.$subtype.' '.$value.'/>';
					}
				}
				else
				{
				$balise	=	'<input '.$name.' '.$subtype.' '.$value.'/>';
				}
			}
		}
		else
		{
			if(array_key_exists('subtype',$a))
			{
				if(in_array($a['subtype'],array('submit','reset','button')))
				{
				$balise	=	'<input '.$name.' '.$subtype.' '.$value.'/>';
				}
				else
				{
				$balise	=	'<input '.$name.' '.$subtype.' '.$value.'/>';
				}
			}
			else
			{
			$balise	=	'<input '.$name.' '.$subtype.' '.$value.'/>';
			}
		}
		$this->currentForm[]	= '<div>'.$text.$balise.'</div>';
	}
	private function parseForm($action	=	"",$enctype	=	"multipart/form-data",$type 	=	"POST")
	{
		$this->formAction	=	$action;
		$this->formEnctype	=	$enctype;
		$this->formType		=	$type;
		
		$this->include_item('blog.parse_form');
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
	/*	Define Left Widget
	*/
	private $ttLeftWidgets				=	array();
	public function defineLeftWidget($title,$content)
	{
		$this->ttLeftWidgets[]			=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content
		);
	}
	private function parseLeftWidgets()
	{
		$currentWidget	=	$this->ttLeftWidgets;
		$this->include_item('widgets.left',array('currentWidget'=>$currentWidget));
	}
	/*
	/*	Right Widgets
	*/
	private $ttRightWidgets				=	array();
	public function defineRightWidget($title,$content)
	{
		$this->ttRightWidgets[]			=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content
		);
	}
	private function parseRightWidgets()
	{
		$currentWidget	=	$this->ttRightWidgets;
		$this->include_item('widgets.right');
	}
	/*
	/*	Bottom Widgets
	*/
	private $ttBottomWidgets				=	array();
	public function defineBottomWidget($title,$content)
	{
		$this->ttBottomWidgets[]			=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content
		);
	}
	public function parseBottomWidgets()
	{
		$currentWidget	=	$this->ttBottomWidgets;
		$this->include_item('widgets.bottom');
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
}