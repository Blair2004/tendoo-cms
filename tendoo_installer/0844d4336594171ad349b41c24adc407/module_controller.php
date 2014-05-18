<?php
class News_module_controller
{
	public function __construct($data)
	{
		__extends($this);
		
		$this->data					=		$data;
		$this->data['news']			=		new News_smart($this->data);
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
		
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
	public function read($id,$text,$page=1)
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
					$keyWords	.=	$this->data['getKeywords'][$i]['KEYWORDS'].',';
				}
				else
				{
					$keyWords	.=	$this->data['getKeywords'][$i]['KEYWORDS'];
				}
			}
		}
		$this->tendoo->setKeywords($keyWords);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		
		// Load View		
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_open',$this->data,true,TRUE);
		// Load View From Theme selected;
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
	public function category($cat_text,$catid = null, $page = 1)
	{
		if($catid == null || $catid == 0)
		{
			$this->url->redirect(array('error','code','missingArg'));
		}
		$this->data['category']	=	$this->data['news']->retreiveCat($catid);
		$this->tendoo->setTitle($this->data['page'][0]['PAGE_TITLE'].' &raquo; '.$this->data['category']['name']);
		$this->tendoo->setDescription('Liste des articles publi&eacute; dans la cat&eacute;gorie '.$this->data['category']['name']);
		$this->data['theme']->definePageTitle('Cat&eacute;gories');
		$this->data['theme']->definePageDescription($this->data['category']['desc']);

		$this->data['ttNews']	=	$this->data['news']->countArtFromCat($catid);
		$this->data['pagination']	=	$this->tendoo->paginate(10,$this->data['ttNews'],1,'active','',$page,$this->url->site_url(array($this->url->controller(),'category',$cat_text,$catid)).'/',$ajaxis_link=null);
		$this->data['pagination'][3]=== false ? $this->url->redirect(array('error','code','page404')) : null;
		$this->data['currentPage']	=	$page;
		$this->data['getNews']	=	$this->data['news']->getArtFromCat($catid,$this->data['pagination'][1],$this->data['pagination'][2]);
		if($this->data['getNews']== false)
		{
			$this->data['getNews']	=	array(
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
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
	public function tester()
	{
		$this->tendoo->setTitle('Test');
		$this->tendoo->setDescription('Nothing');
		// Load View		
		$this->data['module_content']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_test',$this->data,true,TRUE);
		
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
}
?>