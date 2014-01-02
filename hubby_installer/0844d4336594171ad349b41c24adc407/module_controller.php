<?php
class News_module_controller
{
	public function __construct($data)
	{
		$this->core					=		Controller::instance();
		$this->data					=		$data;
		$this->hubby				=&		$this->core->hubby;
		$this->data['core']			=&		$this->core;
		$this->data['news']			=		new News_smart($this->data);
		$this->data['userUtil']		=&		$this->core->users_global;	
		$this->data['setting']		=		$this->data['news']->getBlogsterSetting();	
	}
	public function index($page=1)
	{		
		$this->hubby->setTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->hubby->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		$this->data['ttNews']		=		$this->data['news']->countNews();
		// Load View		
		$this->data['pagination']	=	$this->core->hubby->paginate(5,$this->data['ttNews'],1,'on','off',$page,$this->core->url->site_url(array('blog','index')).'/',$ajaxis_link=null);
		$this->data['pagination'][3]=== false ? $this->core->url->redirect(array('error','code','page404')) : null;
		$this->data['getNews']		=		$this->data['news']->getNews($this->data['pagination'][1],$this->data['pagination'][2]);
		$this->data['currentPage']	=	$page;
		$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_main',$this->data,true,TRUE);
		
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
	public function read($id,$text,$page=1)
	{
		// CE n'est pas au module de faire les chargement nécessaire pour le fonctionnement du theme.
		// Must be retreiving data
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_rules('pseudo','Pseudo','required|min_length[3]|max_length[15]');
		$this->core->form_validation->set_rules('mail','Email','required|valid_email');
		$this->core->form_validation->set_rules('content','Contenu','required|min_length[3]|max_length[1000]');
		if($this->core->form_validation->run())
		{
			// Provisoire $this->input->post('author');
			$result	=	$this->data['news']->postComment($id,$this->core->input->post('content'),$this->core->input->post('pseudo'),$this->core->input->post('email'));
			if($result)
			{
				if($this->data['setting']['APPROVEBEFOREPOST'] == 0)
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('submitedForApproval'));
				}
			}
		}
		$this->data['ttNews']		=		$this->data['news']->countNews();
		$this->data['GetNews']		=		$this->data['news']->getSpeNews($id);
		$this->data['ttComments']	=		$this->data['news']->countComments($id);
		$this->data['pagination']	=	$this->core->hubby->paginate(10,$this->data['ttComments'],1,'active','',$page,$this->core->url->site_url(array('blog','read',$id,$text)).'/');
		$this->data['pagination'][3]=== false ? $this->core->url->redirect(array('error','code','page404')) : null;
		$this->data['currentPage']	=	$page;
		$this->data['Comments']		=		$this->data['news']->getComments($id,$this->data['pagination'][1],$this->data['pagination'][2]);
		if(!$this->data['GetNews'])
		{
			$this->core->url->redirect(array('error/code/page404'));
		}
		$this->data['news']->pushView($this->data['GetNews'][0]['ID']);
		$this->hubby->setTitle('Article - '.$this->data['GetNews'][0]['TITLE']);
		$this->hubby->setDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		$this->data['theme']->definePageTitle($this->data['page'][0]['PAGE_TITLE']);
		$this->data['theme']->definePageDescription($this->data['page'][0]['PAGE_DESCRIPTION']);
		
		// Load View		
		$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_open',$this->data,true,TRUE);
		// Load View From Theme selected;
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
	public function category($cat_text,$catid = null, $page = 1)
	{
		if($catid == null || $catid == 0)
		{
			$this->core->url->redirect(array('error','code','missingArg'));
		}
		$this->data['category']	=	$this->data['news']->retreiveCat($catid);
		$this->hubby->setTitle($this->data['page'][0]['PAGE_TITLE'].' &raquo; '.$this->data['category']['name']);
		$this->hubby->setDescription('Liste des articles publi&eacute; dans la cat&eacute;gorie '.$this->data['category']['name']);
		$this->data['theme']->definePageTitle('Cat&eacute;gories');
		$this->data['theme']->definePageDescription($this->data['category']['desc']);

		$this->data['ttNews']	=	$this->data['news']->countArtFromCat($catid);
		$this->data['pagination']	=	$this->core->hubby->paginate(10,$this->data['ttNews'],1,'active','',$page,$this->core->url->site_url(array($this->core->url->controller(),'category',$cat_text,$catid)).'/',$ajaxis_link=null);
		$this->data['pagination'][3]=== false ? $this->core->url->redirect(array('error','code','page404')) : null;
		$this->data['currentPage']	=	$page;
		$this->data['getNews']	=	$this->data['news']->getArtFromCat($catid,$this->data['pagination'][1],$this->data['pagination'][2]);
		
		$this->data['section']	=		'category';
		$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_category',$this->data,true,TRUE);
		// ----------------------------------------------------------------------------------------------------------------------------------//
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
	public function tester()
	{
		$this->hubby->setTitle('Test');
		$this->hubby->setDescription('Nothing');
		// Load View		
		$this->data['module_content']		=	$this->core->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/common_test',$this->data,true,TRUE);
		
		$this->data['theme']->header($this->data);
		$this->data['theme']->body($this->data);
	}
}
?>