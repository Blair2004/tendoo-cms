<?php
class hubby_modus_theme_handler
{
	public $news;	
	public $file;
	private $data;
	private $core;
	private $prototypeList;
	public function __construct($data)
	{
		$this->data							=	$data;
		$this->news	=	true;
		$this->core							=	Controller::instance();
		$this->core->load->library('file');
		$this->data['file']					=	$this->core->file;
		$this->themeEncrypted_dir				=	$this->data['getTheme']['ENCRYPTED_DIR'];
		include_once(THEMES_DIR.$this->themeEncrypted_dir.'/library.php');
		$this->modus_lib					=	new modus_lib;
		$this->data['netWorking']			=	$this->modus_lib->getNetworking();
		// Load Css File
		$this->data['file']->css_url		=	$this->core->url->main_url().'hubby_themes/'.$this->themeEncrypted_dir.'/css/';
		$this->data['file']->css_push('style');
		$this->data['file']->css_push('jquery.tweet');	
		$this->data['file']->css_push('superfish');	
		$this->data['file']->css_push('prettyPhoto/css/prettyPhoto');
		$this->data['file']->css_push('poshytip-1.1/src/tip-twitter/tip-twitter');
		$this->data['file']->css_push('poshytip-1.1/src/tip-yellowsimple/tip-yellowsimple');
		$this->data['file']->css_push('flexslider');	
		$this->data['file']->css_push('lessgrid');


		// Load Js
		$this->data['file']->js_url			=	$this->core->url->main_url().'hubby_assets/script/';
		$this->data['file']->js_push('jquery');
		$this->data['file']->js_url			=	$this->core->url->main_url().'hubby_themes/'.$this->themeEncrypted_dir.'/js/';
		$this->data['file']->js_push('moveForm');
		$this->data['file']->js_push('tabs');
		$this->data['file']->js_push('masonry.min');
		$this->data['file']->js_push('imagesloaded');
		$this->data['file']->js_push('tweet/jquery.tweet');
		$this->data['file']->js_push('superfish-1.4.8/js/hoverIntent');
		$this->data['file']->js_push('superfish-1.4.8/js/superfish');
		$this->data['file']->js_push('superfish-1.4.8/js/supersubs');	
		$this->data['file']->js_push('prettyPhoto/js/jquery.prettyPhoto');
		$this->data['file']->js_push('poshytip-1.1/src/jquery.poshytip.min');
		$this->data['file']->js_push('jquery.flexslider-min');
		$this->data['file']->js_push('modernizr');
		$this->data['file']->js_push('custom');
		
	}
	public function header($data)
	{
		$this->data	=	array_merge($this->data,$data);
		$this->core->load->view('hubby_themes/'.$this->themeEncrypted_dir.'/default/header',$this->data,FALSE,TRUE);
	}
	public function head($data)
	{
		$this->data	=	array_merge($this->data,$data);
		return $this->core->load->view('hubby_themes/'.$this->themeEncrypted_dir.'/default/head',$this->data,true,TRUE);
	}
	public function footer($data)
	{
		$this->data	=	array_merge($this->data,$data);
		return $this->core->load->view('hubby_themes/'.$this->themeEncrypted_dir.'/default/footer',$this->data,true,TRUE);
	}
	public function body($data)
	{
		$this->data					=	array_merge($this->data,$data);
		$this->data['head']			=	$this->head($this->data);
		$this->data['footer']		=	$this->footer($this->data);
		$this->core->load->view('hubby_themes/'.$this->themeEncrypted_dir.'/default/body',$this->data,FALSE,TRUE);
	}
	private $pagination_datas;
	public function set_pagination_datas($data)
	{
		$this->pagination_datas['firstLink']		=	isset($data['firstLink']) 	? $data['firstLink'] : "null";
		$this->pagination_datas['firstLinkText']	=	isset($data['firstLinkText']) ? $data['firstLinkText'] : "null";
		$this->pagination_datas['LinkText']			=	isset($data['LinkText']) ? $data['LinkText'] : "null";
		$this->pagination_datas['lastLinkText']		=	isset($data['lastLinkText']) ? $data['lastLinkText'] : "null";
		$this->pagination_datas['totalPage']		=	isset($data['totalPage']) ? $data['totalPage'] : "Non sp&eacute;cifi&eacute;";
		$this->pagination_datas['activeLink']		=	isset($data['activeLink']) ? $data['activeLink'] : "Non sp&eacute;cifi&eacute;";
		$this->pagination_datas['activeLinkText']	=	isset($data['activeLinkText']) ? $data['activeLinkText'] : "Texte non sp&eacute;cifi&eacute;";
		$this->pagination_datas['innerLink']		=	isset($data['innerLink']) ? $data['innerLink'] : "Liens non sp&eacute;cifi&eacute;";
		$this->pagination_datas['currentPage']		=	isset($data['currentPage']) ? $data['currentPage'] : "page non sp&eacute;cifi&eacute;";
	}
	public function pagination()
	{
		$this->include_item('pagination');
	}
	public function include_item($item)
	{
		include_once(THEMES_DIR.$this->themeEncrypted_dir.'/extends/items/'.$item.'.php');
	}
	/*
	/*	Commons
	*/
	private $pageTitle			=	'Page Sans Titre';
	private $pageDescription	=	'';
	public function definePageTitle($title)
	{
		$this->pageTitle	=	$title;
	}
	public function definePageDescription($description)
	{
		$this->pageDescription	=	$description;
	}
	/*
	/*	Gallery ShowCase
	*/
	private $galleryShowCaseTitle	=	'Gallery Showcase';
	private $galleryGroup			=	array();
	public function defineGalleryShowCaseTitle($title)
	{
		$this->galleryShowCaseTitle	=	$title;
	}
	public function defineGalleryShowCase($title,$description,$thumb,$full,$link,$timestamp)
	{
		$this->galleryGroup[]		=	array(
			'TITLE'					=>	$title,
			'DESCRIPTION'			=>	$description,
			'THUMB'					=>	$thumb,
			'FULL'					=>	$full,
			'LINK'					=>	$link,
			'TIMESTAMP'				=>	$timestamp
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
	public function defineCarousselTitle($title)
	{
		$this->carousselTitle	=	$title;
	}
	public function defineCaroussel($title,$content,$image,$link,$timestamp) // Ok
	{
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
	public function defineOnTopContentTitle($title)
	{
		$this->onTopContentTitle	=	$title;
	}
	public function defineOnTopContent($thumb,$title,$content,$link,$timestamp) // Ok
	{
		$this->onTopContent[]	=	array(
			'THUMB'				=>	$thumb,
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link,
			'DATETIME'			=>	$timestamp
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
	public function defineLastestElementsTitle($title)
	{
		$this->lastestElementsTitle	=	$title;
	}
	public function defineLastestElements($thumb,$title,$content,$link,$timestamp)
	{
		$this->lastestElements[]	=	array(
			'THUMB'				=>	$thumb,
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link,
			'DATETIME'			=>	$timestamp
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
	private $indexAboutUsTitle	=	"Abous Us";
	public function defineIndexAboutUs($content)
	{
		$this->indexAboutUs	=	$content;
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
	private $partners_title		=	'Our Partners';
	private $partners_content;
	public function definePartnersTitle($title)
	{
		$this->partners_title	=	$title;
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
	private $listText		=	array();
	private $textListTitle	=	'Sample text';
	public function defineTextListTitle($title)
	{
		$this->textListTitle			=	$title;
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
	public function defineTabShowCaseTitle($title)
	{
		$this->tabShowCaseTitle	=	$title;
	}
	public function defineTabShowCase($title,$content) // Ok
	{
		$this->tabShowCase[]	=	array(
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content
		);
	}
	private function parseTabShowCase()
	{
		$this->include_item('index.parse_tabShowCase');
	}
	/*
	/*	Featured products index 
	*/
	private $featuredProductTitle	=	'Featured Product';
	private $featuredProduct		=	array();
	private $featuredProductDevise	=	'€';
	public function defineFeaturedProductTitle($title)
	{
		$this->featuredProductTitle	=	strlen($title) > 0 ? $title : "Featured Product";
	}
	public function defineFeaturedProductDevice($devise)
	{
		$this->featuredProductDevise	=	$devise;
	}
	public function defineFeaturedProducts($title,$content,$thumb,$price,$link)
	{
		$this->featuredProduct[]		=	array(
			'TITLE'			=>	$title,
			'CONTENT'		=>	$content,
			'THUMB'			=>	$thumb,
			'PRICE'			=>	$price,
			'LINK'			=>	$link
		);
	}
	private function parseFeaturedProducts()
	{
		$this->include_item('index.parse_featuredProducts');
	}
	/*
	/* Products listing + Single view
	*/
	private $productListingDevise		=	'€';
	public function defineProductListingDevice($device)
	{
		$this->productListingDevise		=	$device;
	}
	private $productListingCaroussel	=	array();
	public function defineProductListingCaroussel($title,$description,$thumb,$date,$link,$price)
	{
		$this->productListingCaroussel[]	=	array(
			'TITLE'						=>	$title,
			'CONTENT'					=>	$description,
			'THUMB'						=>	$thumb,
			'DATE'						=>	$date,
			'LINK'						=>	$link,
			'PRICE'						=>	$price
		);
	}
	private function parseProductListingCaroussel()
	{
		$this->include_item('index.parse_productsListingCaroussel');
	}
	/*
	/*	Page index Parser
	*/
	public function parseIndex()
	{
		$this->include_item('index.parse');
	}
	/*
	/*	End
	*/
	public function socialBar()
	{
		$this->include_item('index.parse_socialBar');
	}
	/*
	/*	Parse Blogs publications
	*/
	private $blogPostTitle		=	'Blog posts';
	private $blogPost			=	array();
	public function defineBlogPostTitle($title)
	{
		$this->blogPostTitle	=	$title;
	}
	public function defineBlogPost($title,$content,$thumb,$full,$author,$link,$timestamp,$category,$category_link)
	{
		$this->blogPost[]		=	array(
			'AUTHOR'			=>	$author,
			'CONTENT'			=>	$content,
			'THUMB'				=>	$thumb,
			'FULL'				=>	$full,
			'LINK'				=>	$link,
			'TITLE'				=>	$title,
			'TIMESTAMP'			=>	$timestamp,
			'CATEGORY'			=>	$category,
			'CATEGORY_LINK'		=>	$category_link
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
	public function defineSingleBlogPost($title,$content,$thumb,$full,$author,$timestamp,$category,$category_link)
	{
		$this->singleBlogPost		=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content,
			'THUMB'					=>	$thumb,
			'FULL'					=>	$full,
			'AUTHOR'				=>	$author,
			'TIMESTAMP'				=>	$timestamp,
			'CATEGORY'				=>	$category,
			'CATEGORY_LINK'			=>	$category_link
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
	/*	Multilple Product view
	*/
	private $productView	=	array();
	public function defineProductView($title,$content,$thumb,$full,$author,$timestamp,$link,$link_text,$category,$category_link,$price,$add_button_text = 'Ajouter au panier',$add_button_link = '#',$remove_button_text= "Retirer du panier", $remove_button_link = '#',$login_button_text = 'Connectez-vous',$login_button_link	=	'#')
	{
		$this->productView[]	=	array(
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'THUMB'				=>	$thumb,
			'FULL'				=>	$full,
			'AUTHOR'			=>	$author,
			'TIMESTAMP'			=>	$timestamp,
			'LINK'				=>	$link,
			'LINK_TEXT'			=>	$link_text,
			'CATEGORY'			=>	$category,
			'CATEGORY_LINK'		=>	$category_link,
			'PRICE'				=>	$price,
			'ADD_TEXT'	=>	$add_button_text,
			'ADD_LINK'	=>	$add_button_link,
			'REMOVE_LINK'=>	$remove_button_link,
			'REMOVE_TEXT'=>	$remove_button_text,
			'LOGIN_TEXT'	=>	$login_button_text,
			'LOGIN_LINK'	=>	$login_button_link
		);
	}
	private function parseProductView()
	{
		$this->include_item('blog.parse_productView');
	}
	/*
	/*	Single Product view
	*/
	private $singleProductView		=	array();
	public function defineSingleProductView($title,$content,$thumb,$full,$author,$timestamp,$category,$category_link,$price,$other_preview = array(),$add_button_text = 'Ajouter au panier',$add_button_link = '#',$remove_button_text = 'Retirer du panier', $remove_button_link = '#',$check_button_text	=	'Consulter mon panier',$check_button_link	=	'#',$login_button_text = 'Connectez-vous', $login_button_link = '#')
	{
		$this->singleProductView[]	=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content,
			'THUMB'					=>	$thumb,
			'FULL'					=>	$full,
			'AUTHOR'				=>	$author,
			'TIMESTAMP'				=>	$timestamp,
			'CATEGORY'				=>	$category,
			'CATEGORY_LINK'			=>	$category_link,
			'PRICE'					=>	$price,
			'OTHERS_PICS'			=>	$other_preview,
			'ADD_TEXT'				=>	$add_button_text,
			'ADD_LINK'				=>	$add_button_link,
			'REMOVE_TEXT'			=>	$remove_button_text,
			'REMOVE_LINK'			=>	$remove_button_link,
			'CHECK_TEXT'			=>	$check_button_text,
			'CHECK_LINK'			=>	$check_button_link,
			'LOGIN_TEXT'			=>	$login_button_text,
			'LOGIN_LINK'			=>	$login_button_link
		);
	}
	private function parseSingleProductView()
	{
		$this->include_item('blog.parse_singleProductView');
	}
	/*
	/* Cart List
	*/
	private $cartListTitle				=	'Our products';
	private $cartListElements			=	array();
	private $cartListDevise				=	'€';
	private $cartListPanelButton		=	array();
	public function defineCartListDevise($devise)
	{
		$this->cartListDevise	=	strlen($devise) > 0 ? $devise : "€";
	}
	public function defineCartListPanelButton($text,$link)
	{
		$this->cartListPanelButton[]	=	array(
			'LINK'			=>	$link,
			'TEXT'			=>	$text
		);
	}
	public function defineCartListTitle($title)
	{
		$this->cartTitle	=	strlen($title) > 0 ? $title : "Our products";
	}
	public function defineCartListElement($title,$content,$thumb,$price,$link,$cancel_link)
	{
		$this->cartListElements[]		=	array(
			'TITLE'			=>	$title,
			'CONTENT'		=>	$content,
			'THUMB'			=>	$thumb,
			'PRICE'			=>	$price,
			'LINK'			=>	$link,
			'CANCEL_LINK'	=>	$cancel_link
		);
	}
	private function parseCartList() // this include widget side panel
	{
		$this->include_item('blog.parse_cartList');
	}
	/*
	/*	Parse Blog page
	*/
	public function parseListing() // ParseBlog Will be deprecated
	{
		$this->parseBlog();
	}
	public function parseBlog()
	{
		$this->include_item('blog.parse');
	}
	/*
	/*	Form Creator
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
			$subtype	=	'type="'.$a['subtype'].'"';
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
		if(array_key_exists('type',$a))
		{
			if($a['type']	==	'textarea')
			{
				$balise	=	'<textarea '.$name.'>'.$value.'</textarea>';
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
		$this->currentForm[]	= '<div>'.$balise.$text.'</div><br>';
	}
	private function parseForm($action	=	"",$enctype	=	"multipart/form-data",$type 	=	"POST")
	{
		$this->include_item('blog.parse_form');
	}
	/*
	/* 	Define Unique 
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
	/*	Define Widget
	*/
	private $ttWidgets				=	array();
	public function defineWidget($title,$content)
	{
		$this->ttWidgets[]			=	array(
			'TITLE'					=>	$title,
			'CONTENT'				=>	$content
		);
	}
	private function parseWidgets()
	{
		$this->include_item('widgets');
	}
	/*
	/*	Contact Methods
	*/
	private $contactAddress				=	'';
	private $contactTitle				=	"Our Contact";
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
		if(in_array($type,array('email','mobile','phone','address')))
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
		?>
        <div id="main">
			<!-- social -->
			<?php $this->socialBar();?>
			<!-- ENDS social -->
			<!-- Content -->
			<div id="content">
				<!-- masthead -->
		        <div id="masthead">
					<span class="head"><?php echo $this->pageTitle;?></span><span class="subhead"><?php echo word_limiter($this->pageDescription,10);?></span>
					<ul class="breadcrumbs">
						<li><a href="index.html">home</a></li>
						<li>/ contact</li>
					</ul>
				</div>
	        	<!-- ENDS masthead -->
	        	
	        	
	        	
	        	<!-- page content -->
	        	<div id="page-content">
					<p><?php echo $this->contactContent;?></p>
					
					<!-- form -->
					<?php $this->parseForm($this->contactHeader['ACTION'],$this->contactHeader['ENCTYPE'],$this->contactHeader['METHOD']);?>
					<!-- ENDS form -->
						
	        		
	        	</div>
	        	<!-- ENDS page content -->
	        	
	        	
	        	<!-- sidebar -->
                <?php 
				if(count($this->contactAddressItems) > 0)
				{
				?>
	        	<aside id="sidebar">
	        		<div class="block">
		        		<h4><?php echo $this->contactTitle;?></h4>
		        		<p><?php echo $this->contactAddress;?></p>
		        		
		        		<ul class="address-block">
                        <?php
						foreach($this->contactAddressItems as $c)
						{
						?>
		        			<li class="<?php echo $c['TYPE'];?>"><?php echo $c['CONTENT'];?></li>
						<?php
						}
						?>
		        		</ul>
	        		</div>	        	
	        	</aside>
	        	<div class="clearfix"></div>
                <?php
				}
				?>
				<!-- ENDS sidebar -->
				
				
			
			</div>
			<!-- ENDS content -->
			
			<div class="clearfix"></div>
			<div class="shadow-main"></div>
			
			
		</div>
        <?php
	}
	/*
	/*	Notice
	*/
	public function parseNotice()
	{
		$this->include_item('notice');
	}
	/*
	/* Cart element
	*/
	private $currentCartContent			=	array();
	public function defineCurrentCartContent($total_items,$total_prices,$cart_link,$cart_text,$item_shotElement,$devise)
	{
		$this->currentCartContent		=	array(
			'TOTAL_ITEMS'				=>	$total_items,
			'TOTAL_PRICES'				=>	$total_prices,
			'CART_LINK'					=>	$cart_link,
			'CART_TEXT'					=>	$cart_text,
			'ITEM_LIST'					=>	$item_shotElement,
			'DEVISE'					=>	$devise
		);
	}
	public function parseCurrentCartContent() // of for entiri
	{
		$this->include_item('cart.parse_currentCartContent');
	}
}


