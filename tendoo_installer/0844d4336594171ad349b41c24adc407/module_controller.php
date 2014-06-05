<?php
class News_module_controller
{
	public function __construct($data)
	{
		$this->data					=		$data;
		
		__extends($this);
		
		$this->news					=	new News_smart($this->data);
		$this->data['news']			=&		$this->news;
		$this->data['userUtil']		=&		$this->users_global;	
		$this->data['setting']		=		$this->data['news']->getBlogsterSetting();	
	}
	public function index($page=1)
	{		
		$this->tendoo->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->tendoo->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		$this->data['ttNews']		=		$this->data['news']->countNews();
		// Load View		
		$this->data['pagination']	=	$this->tendoo->paginate(5,$this->data['ttNews'],1,'on','off',$page,$this->url->site_url(array('blog','index')).'/',$ajaxis_link=null);
		$this->data['pagination'][3]=== false ? $this->url->redirect(array('error','code','page404')) : null;
		$this->data['getNews']		=		$this->data['news']->getNews($this->data['pagination'][1],$this->data['pagination'][2]);
		$this->data['currentPage']	=	$page;
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_main',$this->data,true,TRUE);
		
		$this->data['theme']->head($this->data);
		$this->data['theme']->body($this->data);
	}
	public function lecture($id,$text,$page=1)
	{
		// CE n'est pas au module de faire les chargement nécessaire pour le fonctionnement du theme.
		// Must be retreiving data
		$showAsAdmin	=	FALSE; // montrer l'article, même si ce dernier n'est pas publié
		if(isset($_GET['mode']))
		{
			// Reservé aux administrateurs
			if($this->users_global->isAdmin())
			{
				$showAsAdmin	=	$_GET['mode']	==	'preview'	? TRUE : FALSE;
			}
			else
			{
				$this->url->redirect(array('error','code','accessDenied'));
			}
		}
		$this->load->library('form_validation',null,null,$this);
		$this->form_validation->set_rules('pseudo','Pseudo','required|min_length[3]|max_length[15]');
		$this->form_validation->set_rules('mail','Email','required|valid_email');
		$this->form_validation->set_rules('content','Contenu','required|min_length[3]|max_length[1000]');
		if($this->form_validation->run())
		{
			// Provisoire $this->input->post('author');
			$result	=	$this->data['news']->postComment($id,$this->input->post('content'),$this->input->post('pseudo'),$this->input->post('email'));
			if($result)
			{
				if($this->data['setting']['APPROVEBEFOREPOST'] == 0)
				{
					$this->notice->push_notice(notice('done'));
				}
				else
				{
					$this->notice->push_notice(notice('submitedForApproval'));
				}
			}
		}
	//	$this->data['ttNews']		=		$this->data['news']->countNews();
		$this->data['GetNews']		=		$this->data['news']->getSpeNews($id,$showAsAdmin);
		$this->data['getKeywords']	=		$this->data['news']->getNewsKeyWords($id);
		// var_dump($this->data['getKeywords']);
		$this->data['ttComments']	=		$this->data['news']->countComments($id);
		$this->data['pagination']	=	$this->tendoo->paginate(10,$this->data['ttComments'],1,'active','',$page,$this->url->site_url(array('blog','read',$id,$text)).'/');
	//	$this->data['pagination'][3]=== false ? $this->url->redirect(array('error','code','page404')) : null;
		$this->data['currentPage']	=	$page;
		$this->data['Comments']		=		$this->data['news']->getComments($id,$this->data['pagination'][1],$this->data['pagination'][2]);
		if(!$this->data['GetNews'])
		{
			$this->url->redirect(array('error/code/page404'));
		}
		$this->data['news']->pushView($this->data['GetNews'][0]['ID']);
		
		$this->tendoo->setTitle('Article - '.$this->data['GetNews'][0]['TITLE']);
		$this->tendoo->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$keyWords	=	'';
		if(count($this->data['getKeywords']) > 0)
		{
			for($i=0;$i< count($this->data['getKeywords']);$i++)
			{
				if(array_key_exists($i+1,$this->data['getKeywords']))
				{
					$keyWords	.=	$this->data['getKeywords'][$i]['TITLE'].',';
				}
				else
				{
					$keyWords	.=	$this->data['getKeywords'][$i]['TITLE'];
				}
			}
		}
		$this->tendoo->setKeywords($keyWords);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		
		// Load View		
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_open',$this->data,true,TRUE);
		// Load View From Theme selected;
		$this->data['theme']->head($this->data);
		$this->data['theme']->body($this->data);
	}
	public function categorie($cat_text,$catid = null, $page = 1)
	{
		$this->data['category']	=	$this->news->categoryExists($catid);
		if(!$this->data['category'])
		{
			module_location(array('index?unknowCategory'));
		}
		// 	->
		$this->data['countArticles']	=	count($this->news->getCategoryArticles($catid));
		$this->data['paginate']			=	pagination_helper(
			10, // should be set by user
			$this->data['countArticles'],
			$page,
			module_url(array('categorie')),
			$RedirectUrl = array('error','code','page404')
		);
		$this->data['getArticles']		=	$this->news->getCategoryArticles(
			$catid,
			$this->data['paginate']['start'],
			$this->data['paginate']['end']
		);
		//
		$title		=	$this->data['page'][0]['PAGE_TITLE'].' &raquo; '.$this->data['category'][0]['CATEGORY_NAME'].' (catégorie)';
		$description=	$this->data['category'][0]['DESCRIPTION'];
		// 
		$this->tendoo->setTitle($title);
		$this->tendoo->setDescription($description);
		$this->data['theme']->definePageTitle($title);
		$this->data['theme']->definePageDescription($description);
		// 
		if($this->data['getArticles']== false)
		{
			$this->data['getArticles']	=	array(
				array(
					'TITLE'			=>	'Aucune publication disponible',
					'CONTENT'		=>	'Aucune publication n\'est disponible dans cette cat&eacute;gorie',
					'AUTEUR'		=>	'1',
					'DATE'			=>	$this->tendoo->datetime(),
					'THUMB'			=>	$this->url->img_url('hub_back.png'),
					'IMAGE'			=>	$this->url->img_url('hub_back.png'),
					'ID'			=>	0
				)
			);
		}
		
		$this->data['section']	=		'category';
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_category',$this->data,true,TRUE);
		// ----------------------------------------------------------------------------------------------------------------------------------//
		$this->data['theme']->head($this->data);
		$this->data['theme']->body($this->data);
	}
	public function tags($tags_name = '',$page	=	1)
	{
		$this->data['keyWords']	=	$this->news->keywordExists($tags_name);
		if(!$this->data['keyWords'])
		{
			module_location(array('index?notice=unknowKeyWord'));
		}
		$this->data['countArticles']	=	count($this->news->getKeyWordsArticles($tags_name));
		
		$this->data['paginate']			=	pagination_helper(
			10, // should be set by user
			$this->data['countArticles'],
			$page,
			module_url(array('tags')),
			$RedirectUrl = array('error','code','page404')
		);
		$this->data['tagArticles']		=	$this->data['news']->getKeyWordsArticles(
			$tags_name,
			$this->data['paginate']['start'],
			$this->data['paginate']['end']
		);
		//
		$title			=	$this->data['page'][0]['PAGE_TITLE'].' &raquo; '.$tags_name.' (mot-clé)';
		$description	=	$this->data['keyWords'][0]['DESCRIPTION']; // Fetching KeyWords Description
		//
		$this->tendoo->setTitle($title);
		$this->tendoo->setDescription($description);
		// 
		$this->data['theme']->definePageTitle($title);
		$this->data['theme']->definePageDescription($description);
		//
		
		if($this->data['tagArticles']== false)
		{
			$this->data['tagArticles']	=	array(
				array(
					'TITLE'			=>	'Aucune publication disponible',
					'CONTENT'		=>	'Aucune publication n\'est disponible pour ce mot-clé',
					'AUTEUR'		=>	'1',
					'DATE'			=>	$this->tendoo->datetime(),
					'THUMB'			=>	$this->url->img_url('hub_back.png'),
					'IMAGE'			=>	$this->url->img_url('hub_back.png'),
					'ID'			=>	0
				)
			);
		}
		
		$this->data['section']				=	'keywords';
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_keywords',$this->data,true,TRUE);
		// ----------------------------------------------------------------------------------------------------------------------------------//
		$this->data['theme']->head($this->data);
		$this->data['theme']->body($this->data);
	}
	
}
?>