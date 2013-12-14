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
		?>
<ul class="pager" style="height:20px;">
    <?php
			if(is_array($this->pagination_datas['innerLink']))
			{
				foreach($this->pagination_datas['innerLink'] as $p)
				{
					if($p['state'] == 'active')
					{
					?>
    <li class="active"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
    <?php
					}
					else
					{
						?>
    <li><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
    <?php
					}
				
				}
			}
			else
			{
				?>
    <li><a href="#">0</a></li>
    <?php
			}
				?>
</ul>
<?php
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
		if(count($this->galleryGroup) > 0)
		{
		?>
        <h1 class="home-block-heading"><?php echo $this->galleryShowCaseTitle;?></h1>
        <ul class="home-gallery">
        <?php
			foreach($this->galleryGroup as $g)
			{
		?>
            <li><a href="<?php echo $g['FULL'];?>" data-rel="prettyPhoto" class="thumb"><img src="<?php echo $g['THUMB'];?>" alt="<?php echo $g['TITLE'];?>" /></a></li>
            <?php
			}
			?>
        </ul>
        <div class="clearfix"></div>
        <?php
		}
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
		if(count($this->carousselElement) > 0)
		{
				?>
<div class="flexslider home-slider">
  <ul class="slides">
 <?php
	foreach($this->carousselElement as $c)
	{
?>
    <li>
      <a href="<?php echo $c['LINK'];?>"><img src="<?php echo $c['IMAGE'];?>"  alt="<?php echo $c['TITLE'];?>" style="width:100%;"  /></a>
      <p class="flex-caption"><?php echo word_limiter(strip_tags($c['CONTENT']),20);?></p>
    </li>
<?php
	}
			?>
  </ul>
</div>
<div class="shadow-slider"></div>
<?php
		}
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
		if(count($this->onTopContent) > 0)
		{
		?>
<h1 class="home-block-heading"><?php echo $this->onTopContentTitle;?></h1>
<div class="featured masonry" style="position: relative; height: 759px;">
<?php
foreach($this->onTopContent as $c)
	{
	?>
    <figure class="masonry-brick">
        <a href="<?php echo $c['THUMB'];?>" data-rel="prettyPhoto" class="thumb" rel="prettyPhoto"><img src="<?php echo $c['THUMB'];?>" alt="<?php echo $c['TITLE'];?>"></a>
        <div>
            <a href="<?php echo $c['LINK'];?>" class="heading"><?php echo $c['TITLE'];?></a>
             <?php echo word_limiter(strip_tags($c['CONTENT']),50);?>
        </div>
        <a class="link" href="<?php echo $c['LINK'];?>"></a>
    </figure>
	<?php
	}
			?>
    <div class="clearfix"></div>
</div>
<!-- ENDS Featured -->
<?php
		}
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
		if(count($this->lastestElements) > 0)
		{
		?>
<h1 class="home-block-heading"><?php echo $this->lastestElementsTitle;?></h1>
<div class="featured masonry" style="position: relative; height: 759px;">
<?php
foreach($this->lastestElements as $c)
	{
	?>
    <figure class="masonry-brick">
        <a href="<?php echo $c['THUMB'];?>" data-rel="prettyPhoto" class="thumb" rel="prettyPhoto"><img src="<?php echo $c['THUMB'];?>" alt="<?php echo $c['TITLE'];?>"></a>
        <div>
            <a href="<?php echo $c['LINK'];?>" class="heading"><?php echo $c['TITLE'];?></a>
             <?php echo word_limiter(strip_tags($c['CONTENT']),50);?>
        </div>
        <a class="link" href="<?php echo $c['LINK'];?>"></a>
    </figure>
	<?php
	}
			?>
    <div class="clearfix"></div>
</div>
<!-- ENDS Featured -->
<?php
		}
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
		if(isset($this->indexAboutUs))
		{
		?>
        <h1 class="home-block-heading"><?php echo $this->indexAboutUsTitle;?></h1>
        <div class="text-posts" style="margin-left:24px;">
            <p><?php echo strip_tags($this->indexAboutUs);?></p>
        </div>
        <div class="clearfix"></div>
		<?php
		}
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
		if(count($this->listText) > 0)
		{
		?>
<h1 class="home-block-heading"><?php echo $this->textListTitle;?></h1>
        <ul class="text-posts">
<?php
			foreach($this->listText as $t)
			{
?>
            <li>
                <a href="<?php echo $t['LINK'];?>" class="heading"><?php echo $t['TITLE'];?></a>
                <?php echo word_limiter($t['CONTENT'],200);?>
            </li>
		<?php
			}
			?>
        </ul>
            <?php
		}
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
		if(count($this->tabShowCase) > 0)
		{
		?>
        <h1 class="home-block-heading"><?php echo $this->tabShowCaseTitle;?></h1>
        <div style="padding:0 24px;">
            <ul class="tabs">
            <?php
                foreach($this->tabShowCase as $s)
                {
                    ?>
                    <li><a href="#" class="current"><span><?php echo $s['TITLE'];?></span></a></li>
                    <?php
                }
            ?>
            </ul>
            <div class="panes">
            <?php
            foreach($this->tabShowCase as $s)
            {
            ?>
                <div style="display: block;">
                    <p><?php echo $s['CONTENT'];?></p>
                </div>
            <?php
            }
            ?>
            </div>
		</div>
        <div class="clearfix"></div>	
        <br />
        <?php
		}
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
		if(count($this->featuredProduct) > 0)
		{
		?>
        <h1 class="home-block-heading"><?php echo $this->featuredProductTitle;?></h1>
        <div class="featured">
        <?php 
		foreach($this->featuredProduct as $p)
		{
		?>
            <figure>
                <a href="<?php echo $p['THUMB'];?>" data-rel="prettyPhoto" class="thumb"><img src="<?php echo $p['THUMB'];?>" alt="<?php echo $p['TITLE'];?>"></a>
                <div>
                    <a href="<?php echo $p['LINK'];?>" class="heading"><?php echo $p['TITLE'];?></a>
                    <?php echo word_limiter(strip_tags($p['CONTENT']),100);?>
                    <div style="line-height:20px;background:#002191;color:#EEE;padding:0 5px;">Prix : <?php echo $p['PRICE'];?> <?php echo $this->featuredProductDevise;?></div>
                </div>
                <a class="link" href="<?php echo $p['LINK'];?>"></a>
            </figure>
		<?php
		}
		?>
            <div class="clearfix"></div>
        </div>
        <?php
		}
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
		if(count($this->productListingCaroussel) > 0)
		{
				?>
<div class="flexslider home-slider">
  <ul class="slides">
 <?php
	foreach($this->productListingCaroussel as $c)
	{
?>
    <li>
    
      <a href="<?php echo $c['LINK'];?>"><img src="<?php echo $c['THUMB'];?>"  alt="<?php echo $c['TITLE'];?>"  /></a>
      <div style="padding:20px 20px;background:rgba(0, 0, 0, 0.8);position:absolute;top:0;color:white;"><?php echo $c['TITLE'];?></div>
      <p class="flex-caption">
	  	<?php echo word_limiter(strip_tags($c['CONTENT']),20);?>
        <div style="padding:10 20px;background:#FFF;opacity:0.8;float:right"><?php echo $this->productListingDevise;?> <?php echo $c['PRICE'];?></div></p>
      
    </li>
<?php
	}
			?>
  </ul>
</div>
<div class="shadow-slider"></div>
<?php
		}
	}
	/*
	/*	Page index Parser
	*/
	public function parseIndex()
	{
		?>
<div id="main">
    <!-- social -->
    <?php $this->socialBar();?>
    <!-- ENDS social -->
    <!-- Content -->
    <div id="content">
        <!-- slider -->
        <?php $this->parseCaroussel();?>
		<?php $this->parseProductListingCaroussel();?>
        <!-- ENDS slider -->
        <!-- Headline -->
		<?php $this->parseIndexAboutUs();?>
        <!-- ENDS Headline -->
        <!-- featured -->
        <?php $this->parseOnTopContent();?>
        <!-- ENDS featured -->
        <!-- Features Products -->
        <?php $this->parseFeaturedProducts();?>
        <?php $this->parseLastestElements();?>
        <!-- ENDS Features Products -->
        <?php $this->parseTabShowCase();?>
        <!-- text-posts -->
        <?php $this->parseTextList();?>
        <!-- ENDS text-posts -->
        <!-- home-gallery -->
        <?php $this->parseGalleryShowCase();?>
        <!-- ENDS home-gallery -->
    </div>
    <!-- ENDS content -->
    <div class="clearfix"></div>
    <div class="shadow-main"></div>
</div>
<?php
	}
	/*
	/*	End
	*/
	public function socialBar()
	{
		?>
        <div id="social-bar">
		<?php
        if($this->data['netWorking']['FACEBOOK_ACCOUNT'] != '' || $this->data['netWorking']['TWITTER_ACCOUNT'] != '' || $this->data['netWorking']['GOOGLEPLUS_ACCOUNT'] != '')
        {
            ?>
            <ul>
            <?php
            if($this->data['netWorking']['FACEBOOK_ACCOUNT'] != '')
            {
                ?>
                <li><a href="<?php echo $this->data['netWorking']['FACEBOOK_ACCOUNT'];?>"  title="Become a fan"><img src="<?php echo $this->core->url->main_url().THEMES_DIR.$this->themeEncrypted_dir.'/img/social/facebook_32.png';?>"  alt="Facebook" /></a></li>
            <?php
            }
            else if($this->data['netWorking']['TWITTER_ACCOUNT'] != '')
            {
                ?>
                <li><a href="<?php echo $this->data['netWorking']['TWITTER_ACCOUNT'];?>"  title="Become a fan"><img src="<?php echo $this->core->url->main_url().THEMES_DIR.$this->themeEncrypted_dir.'/img/social/twitter_32.png';?>"  alt="Twitter" /></a></li>
            <?php
            }
            else if($this->data['netWorking']['GOOGLEPLUS_ACCOUNT'] != '')
            {
                ?>
                <li><a href="<?php echo $this->data['netWorking']['GOOGLEPLUS_ACCOUNT'];?>"  title="Become a fan"><img src="<?php echo $this->core->url->main_url().THEMES_DIR.$this->themeEncrypted_dir.'/img/social/google_plus_32.png';?>"  alt="googleplus" /></a></li>
            <?php
            }
            ?>
            </ul>
            <?php
        }
        ?>
        </div>
        <?php
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
		if(count($this->blogPost) > 0)
		{
		?>
        <div id="posts-list">
        	<?php
			foreach($this->blogPost as $p)
			{
				$global	=	$this->core->hubby->time($p['TIMESTAMP'],TRUE);
			?>
            <article class="format-standard">
                
                <div class="feature-image">
                    <a href="<?php echo $p['FULL'];?>" data-rel="prettyPhoto"><img src="<?php echo $p['THUMB'];?>" alt="<?php echo $p['TITLE'];?>" /></a>
                </div>
                
                <h1><a href="<?php echo $p['LINK'];?>" class="post-heading"><?php echo $p['TITLE'];?></a></h1>
                <div class="meta">
                    <span class="entry-date"><?php echo $this->core->hubby->time(strtotime($p['TIMESTAMP']));?></span>
                    dans <span class="categories"><a href="<?php echo $p['CATEGORY_LINK'];?>"><?php echo $p['CATEGORY'];?></a></span>
                </div>
                <div class="excerpt"><?php echo word_limiter(strip_tags($p['CONTENT']),50);?>
                </div>
                <a href="<?php echo $p['LINK'];?>" class="read-more">Lire la suite</a>
            </article>
                <?php
			}
				?>
        </div>
        <?php
		}
		else if($this->blogPost === FALSE)
		{
			var_dump($this->blogPost);
			?>
		<div id="posts-list">
        	<pre>Aucun article disponible</pre>
        </div>
            <?php
		}
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
		if(count($this->singleBlogPost) > 0)
		{
	?>
	<div id="post-content">

	<div class="feature-image">
		<a href="<?php echo $this->singleBlogPost['FULL'];?>" data-rel="prettyPhoto"><img src="<?php echo $this->singleBlogPost['THUMB'];?>" alt="<?php echo $this->singleBlogPost['TITLE'];?> text" /></a>
	</div>
	<h1 class="post-heading"><?php echo $this->singleBlogPost['TITLE'];?></h1>
	<div class="meta">
		<span class="entry-date"><?php echo $this->core->hubby->time(strtotime($this->singleBlogPost['TIMESTAMP']));?></span>
		dans <span class="categories"><a href="<?php echo $this->singleBlogPost['CATEGORY_LINK'];?>"><?php echo $this->singleBlogPost['CATEGORY'];?></a></span>
	</div>
	
	<div class="content-area"><?php echo $this->singleBlogPost['CONTENT'];?></div>
		
	<div class="clearfix"></div>
	<!-- comments list -->
	<div id="comments-wrap">
		<h3 class="heading"><?php echo $this->TT_SBP_comments;?> commentaires</h3>
		<ol class="commentlist">
			<?php
			if($this->TT_SBP_comments > 0)
			{
				$commentID	=	1;
				foreach($this->SBP_comments as $s)
				{
			?>	   
			<li class="comment even thread-even depth-1" id="li-comment-<?php echo $commentID;?>">
				
				<div id="comment-1" class="comment-body clearfix">
					<img alt='' src='http://0.gravatar.com/avatar/4f64c9f81bb0d4ee969aaf7b4a5a6f40?s=35&amp;d=&amp;r=G' class='avatar avatar-35 photo' height='35' width='35' />      
					<div class="comment-author vcard"><?php echo $s['AUTHOR'];?></div>
					<div class="comment-meta commentmetadata">
						<span class="comment-date"><?php echo $s['TIMESTAMP'];?></span>
						<span class="comment-reply-link-wrap"><a class='comment-reply-link' href='replytocom=23#respond' onclick='return addComment.moveForm("comment-1", "1", "respond", "432")'>R&eacute;pondre</a></span>
						
					</div>
					<div class="comment-inner">
						<p><?php echo $s['CONTENT'];?></p>
					</div>
				</div>
			</li>
            <?php
					$commentID++;
				}
			}
			?>
		</ol>
	</div>
	<!-- ENDS comments list -->
    <!-- pager -->
	<?php $this->pagination();?>
    <div class="clearfix"></div>	
	<!-- Respond -->				
	<div id="respond">
		
		<div class="cancel-comment-reply"><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">Cancel reply</a></div>
		<?php $this->parseNotice();?>
        <?php $this->parseForm();?>
	</div>
	<div class="clearfix"></div>
	<!-- ENDS Respond -->	
</div>
	<?php
		}
		else if($this->singleBlogPost	===	false)
		{
			?>
		<div id="posts-list">
        	<pre>Article introuvable disponible</pre>
        </div>
            <?php
		}
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
		if(count($this->productView) > 0)
		{
		?>
        <div id="posts-list">
        	<?php
			foreach($this->productView as $p)
			{
				$global	=	$this->core->hubby->time($p['TIMESTAMP'],TRUE);
			?>
            <article class="format-standard">
                
                <div class="feature-image">
                    <a href="<?php echo $p['FULL'];?>" data-rel="prettyPhoto"><img src="<?php echo $p['THUMB'];?>" alt="<?php echo $p['TITLE'];?>" /></a>
                </div>
                
                <h1><a href="<?php echo $p['LINK'];?>" class="post-heading"><?php echo $p['TITLE'];?></a></h1>
                <div class="meta">
                	<?php
					if(is_numeric($p['PRICE']))
					{
					?>
                	<span>Prix : <?php echo $this->productListingDevise;?> <?php echo $p['PRICE'];?></span> - 
                    <?php
					}
					else
					{
						?>
                	<span><?php echo $p['PRICE'];?></span>
                        <?php
					}
					?>
                    <span class="entry-date"><?php echo $this->core->hubby->time(strtotime($p['TIMESTAMP']));?></span>
                    dans <span class="categories"><a href="<?php echo $p['CATEGORY_LINK'];?>"><?php echo $p['CATEGORY'];?></a></span>
                </div>
                <div class="excerpt"><?php echo word_limiter(strip_tags($p['CONTENT']),50);?>
                </div>
                <a href="<?php echo $p['LINK'];?>" class="read-more"><?php echo $p['LINK_TEXT'];?></a>
                <?php
				if($p['ADD_LINK'] != '#')
				{
				?>
                <a href="<?php echo $p['ADD_LINK'];?>" class="read-more"><?php echo $p['ADD_TEXT'];?></a>
                <?php
				}
				if($p['REMOVE_LINK'] != '#')
				{
				?>
                <a href="<?php echo $p['REMOVE_LINK'];?>" class="read-more"><?php echo $p['REMOVE_TEXT'];?></a>
                <?php
				}
				if($p['LOGIN_LINK'] != '#')
				{
				?>
                <a href="<?php echo $p['LOGIN_LINK'];?>" class="read-more"><?php echo $p['LOGIN_TEXT'];?></a>
                <?php
				}
				?>
            </article>
                <?php
			}
				?>
        </div>
        <?php
		}
		else if($this->blogPost === FALSE)
		{
			var_dump($this->blogPost);
			?>
		<div id="posts-list">
        	<pre>Aucun article disponible</pre>
        </div>
            <?php
		}
	
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
		if(count($this->singleProductView) > 0)
		{
			$this->singleProductView	=&	$this->singleProductView[0];
	?>
	<div id="post-content">
	<div class="feature-image">
		<a href="<?php echo $this->singleProductView['FULL'];?>" data-rel="prettyPhoto"><img src="<?php echo $this->singleProductView['THUMB'];?>" alt="<?php echo $this->singleProductView['TITLE'];?> text" /></a>
	</div>
	<h1 class="post-heading"><?php echo $this->singleProductView['TITLE'];?> - <?php echo $this->productListingDevise;?> <?php echo $this->singleProductView['PRICE'];?></h1>
    <div class="content-area"><?php echo $this->singleProductView['CONTENT'];?></div>
    <div style="float:left;padding:10px 20px;background:#0C6;font-weight:600;margin-right:5px;"><a href="<?php echo $this->singleProductView['ADD_LINK'];?>"><?php echo $this->singleProductView['ADD_TEXT'];?></a></div>
    <div style="float:left;padding:10px 20px;background:#000;font-weight:600;margin-right:5px;"><a style="color:#FFF" href="<?php echo $this->singleProductView['REMOVE_LINK'];?>"><?php echo $this->singleProductView['REMOVE_TEXT'];?></a></div>
    <div style="float:left;padding:10px 20px;background:#09C;font-weight:600;margin-right:5px;"><a href="<?php echo $this->singleProductView['CHECK_LINK'];?>"><?php echo $this->singleProductView['CHECK_TEXT'];?></a></div>
		
	<div class="clearfix"></div>
    </div>
        <?php
		}
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
		if(count($this->cartListElements) > 0 )
		{
			?>
			<div id="post-content">
			<?php
            if(is_array($this->cartListPanelButton) && count($this->cartListPanelButton) > 0)
            {
            ?>
            <ul class="list-buttons">
                <?php
                foreach($this->cartListPanelButton as $p)
                {
                    // red green blue
                ?>
                <li><a href="<?php echo $p['LINK'];?>" class="link-button"><?php echo $p['TEXT'];?></a></li>
                <?php
                }
                ?>
            </ul>
            <div class="clearfix"></div>
            <?php
            }
			foreach($this->cartListElements as $c)
			{
				?>
				<div class="toggle-trigger"><?php echo $c['TITLE'];?> - <?php echo $c['PRICE'];?> <?php echo $this->cartListDevise;?><span style="float:right"><a href="<?php echo $c['CANCEL_LINK'];?>">Retirer
				 le produit</a></span></div>
				<div class="toggle-container" style="display: none;min-height:120px;">
					
				<p><a href="<?php $c['LINK'];?>"><img src="<?php echo $c['THUMB'];?>" alt="<?php echo $c['TITLE'];?>" style="float:left;width:200px;display:inline-block;margin-right:10px;" /></a><?php echo $c['CONTENT'];?></p>
				</div>
				<?php
			}
			?>
			</div>
			<?php
		}
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
		?>
        <!-- MAIN -->
		<div id="main">
				
			<!-- social -->
			<?php $this->socialBar();?>
			<!-- ENDS social -->
			
			
			
			<!-- Content -->
			<div id="content">
			
				<!-- masthead -->
		        <div id="masthead">
					<span class="head"><?php echo $this->pageTitle;?></span><span class="subhead"><?php if(strlen($this->pageDescription) > 0) : echo word_limiter($this->pageDescription,20);endif;?></span>
					<ul class="breadcrumbs">
						<li><a href="index.html">home</a></li>
						<li>/ blog</li>
					</ul>
				</div>
	        	<!-- ENDS masthead -->
	        	
	        	
	        	
	        	<!-- posts list -->
                <?php $this->parseProductView();?>
                <?php $this->parseSingleProductView();?>
                <?php $this->parseCartList();?>
				<?php $this->parseSingleBlogPost();?>
	        	<?php $this->parseBlogPost();?>
	        	<!-- ENDS posts list -->
	        	
	        	
	        	<!-- sidebar -->
	        	<?php echo $this->parseWidgets();?>
				<!-- ENDS sidebar -->
				
				
				<!-- pager -->
        		<?php $this->pagination();?>
				<div class="clearfix"></div>
	        	<!-- ENDS pager -->
			
			</div>
			<!-- ENDS content -->
			
			<div class="clearfix"></div>
			<div class="shadow-main"></div>
			
			
		</div>
		<!-- ENDS MAIN -->
        <?php
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
		if(count($this->currentForm) > 0)
		{
		?>
        <form method="<?php echo $type;?>" enctype="<?php echo $enctype;?>" action="<?php echo $action;?>" id="commentform">
        	<?php
			foreach($this->currentForm as $c)
			{
				echo $c;
			}
			?>
        </form>
        <?php
		}
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
		?>
        <!-- MAIN -->
		<div id="main">
				
			<!-- social -->
			<?php $this->socialBar();?>
			<!-- ENDS social -->
			<!-- Content -->
			<div id="content">
			
				<!-- masthead -->
		        <div id="masthead">
					<span class="head"><?php echo $this->pageTitle;?></span><span class="subhead"><?php if(strlen($this->pageDescription) > 0) : echo word_limiter($this->pageDescription,20);endif;?></span>
					<ul class="breadcrumbs">
						<li><a href="index.html">home</a></li>
						<li>/ blog</li>
					</ul>
				</div>
	        	<!-- ENDS masthead -->
	        	
	        	
	        	
	        	<!-- posts list -->
                <div id="post-content">
				<?php echo $this->uniqueContent;?>
                </div>
	        	<!-- ENDS posts list -->
	        	
	        	
	        	<!-- sidebar -->
	        	<?php $this->parseWidgets();?>
				<!-- ENDS sidebar -->			
			</div>
			<!-- ENDS content -->
			
			<div class="clearfix"></div>
			<div class="shadow-main"></div>
			
			
		</div>
		<!-- ENDS MAIN -->
        <?php
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
		if(count($this->ttWidgets) > 0)
		{
		?>
        <aside id="sidebar">
        <?php
			foreach($this->ttWidgets as $w)
			{
		?>
            <div class="block">
                <h4><?php echo $w['TITLE'];?></h4>
                <?php echo $w['CONTENT'];?>
            </div>
            <?php
			}
			?>
        </aside>
        <?php
		}
		?>
        <div class="clearfix"></div>
        <?php
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
		if(strlen($this->core->notice->parse_notice()) > 0)
		{
		?>
        <div class="headline" style="font-size:15px;">
            <?php $this->core->notice->parse_notice();?>
        </div>
        <?php
		}
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
		$c	=&	$this->currentCartContent;
		if(count($c) == 0): return false;endif;
		?>
        <div class="basket">
            <div class="textbox basket-text float-r" style="padding-right:20px;width:200px;">
                <label><?php echo $c['TOTAL_ITEMS'];?> Produits</label>: <label class="hl-text">
                <?php
				if(is_numeric($c['TOTAL_PRICES']))
				{
					 echo $c['TOTAL_PRICES'].' '.$c['DEVISE'];
				};
				?></label>
                <a href="javascript:;" class="drop-arrow">&nbsp;</a>
            </div>
            <a href="javascript:;" class="button has-icon basket-button border float-r"><span>&nbsp;</span></a>
            <div class="clearfix"></div>
            <?php
            if(count($c['ITEM_LIST']))
            {
            ?>
            <ul class="basket-dropdown">
                <li class="dropdown-header overlay">
                    <span class="basket-arrow">&nbsp;</span>
                    <label class="item"><strong>Produit</strong></label>
                    <label class="price-each"><strong>Prix Unitaire</strong></label>
                    <label class="price"><strong>Prix total</strong></label>
                </li>
                <?php
				if(is_array($c['ITEM_LIST']))
				{
				foreach($c['ITEM_LIST'] as $i)
				{
				?>
                <li class="dropdown-line clearfix">
                    <div class="line-col media">
                        <img src="http://localhost/hub_ex/hubby_themes/d27449fc84378e9b444ed37254315173/img/basket-item-1.jpg" alt="">
                    </div>
                    <div class="line-col desc">
                        <strong><a href="details.html"><?php echo $i['TITLE'];?></a></strong><br>
                        Quantit&eacute; : <?php echo $i['QUANTITY'];?>
                    </div>
                    <div class="line-col price-each">
                        <?php echo $i['UNIQUE_PRICE'];?> <?php echo $c['DEVISE'];?>
                    </div>
                    
                    <div class="line-col price">
                        <?php echo $i['GLOBAL_PRICE'];?> <?php echo $c['DEVISE'];?>
                        <a href="<?php echo $i['REMOVE_LINK'];?>"><?php echo $i['REMOVE_TEXT'];?></a>
                    </div>
                </li>
                <?php
				}
				}
				?>
                <li class="dropdown-total">
                    <strong>Total</strong>: <span class="hl-text"><?php echo $c['TOTAL_PRICES'];?></span>
                </li>
                <li class="dropdown-footer clearfix">
                    <a href="<?php echo $c['CART_LINK'];?>" class="button dark shadow"><?php echo $c['CART_TEXT'];?></a>
                </li>
                
            </ul>
            <?php
            }
            ?>
        </div>
        <?php
	}
}


