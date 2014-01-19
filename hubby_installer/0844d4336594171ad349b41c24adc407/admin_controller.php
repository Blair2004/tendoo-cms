<?php
class News_admin_controller
{
	private $moduleData;
	private $data;
	private $news;
	private $news_smart;
	private $hubby_admin;
	private $hubby;
	private $notice;
	public function __construct($data)
	{
		$this->core						=	Controller::instance();
		$this->hubby					=&	$this->core->hubby;
		$this->hubby_admin				=&	$this->core->hubby_admin;
		$this->data						=&	$data;
		$this->notice					=&	$this->core->notice;
		
		$this->moduleData				=	$this->data['module'][0];
		$this->news						=	new News($this->data);
		$this->data['news']				=&	$this->news;
		
		$this->hubby_admin->menuExtendsBefore($this->news->getMenu());
		$this->data['inner_head']		=	$this->core->load->view('admin/inner_head',$this->data,true);
		$this->data['ajaxMenu']	=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_menu',$this->data,true,TRUE);
		$this->data['lmenu']			=	$this->core->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		$this->linnk					=	MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/';
	}
	public function index($page	= 1)
	{
		
		$this->data['ttNews']		=	$this->news->countNews();
		$this->data['paginate']	=	$this->core->hubby->paginate(1,$this->data['ttNews'],1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->core->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'index')).'/',$ajaxis_link=null);
		if($this->data['paginate'][3] == FALSE): $this->core->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
		
		$this->hubby->setTitle('Blogster - Page d\'administration');
		$this->data['getNews']		=	$this->news->getNews($this->data['paginate'][1],$this->data['paginate'][2]);
		
		if(isset($_GET['ajax']))
		{
			$this->data['body']	=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_main',$this->data,true,TRUE);
			return array(
				'MCO'		=>		TRUE,
				'RETURNED'	=>		$this->data['body']
			);
		}
		else
		{
			$this->data['body']	=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/main',$this->data,true,TRUE);
			return $this->data['body'];
		}
	}
	public function publish()
	{
		if($this->core->users_global->isSuperAdmin()	|| $this->hubby_admin->adminAccess('modules','publish_news',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->data['categories']	=	$this->news->getCat();
			if(count($this->data['categories']) == 0)
			{
				$this->core->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'category','create?notice=noCategoryCreated'));
			}
			$this->hubby->setTitle('Blogster - Créer un nouvel article');
			$this->core->load->library('form_validation');
			$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			$this->core->form_validation->set_rules('news_name','Intitulé de l\'article','trim|required|min_length[5]|max_length[200]');
			$this->core->form_validation->set_rules('news_content','Contenu de l\'article','trim|required|min_length[5]|max_length[5000]');
			$this->core->form_validation->set_rules('push_directly','Choix de l\'action','trim|required|min_length[1]|max_length[10]');		
			$this->core->form_validation->set_rules('image_link','Lien de l\'image','trim|required|min_length[5]|max_length[1000]');		
			if($this->core->form_validation->run())
			{
				$this->data['result']	=	$this->news->publish_news(
					$this->core->input->post('news_name'),
					$this->core->input->post('news_content'),
					$this->core->input->post('push_directly'),
					$this->core->input->post('image_link'),
					$this->core->input->post('category')
				);
				if($this->data['result'])
				{
					$this->notice->push_notice(notice('done'));
				}
				else
				{
					$this->notice->push_notice(notice('error'));
				}
				
			}
			$this->hubby->loadEditor(3);
			if(isset($_GET['ajax']))
			{
				return array(
					'MCO'		=>	TRUE,
					'RETURNED'	=>	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_publish',$this->data,true,TRUE)
				);
			}
			else
			{
			return $this->data['body']	=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/publish',$this->data,true,TRUE);
			}
		}
		else
		{
			$this->core->url->redirect(array('admin','menu?notice=accessDenied'));
		}
	}
	public function ajax_publish()
	{
		$this->core->form_validation->set_rules('news_name','Intitulé de l\'article','trim|required|min_length[5]|max_length[200]');
		$this->core->form_validation->set_rules('news_content','Contenu de l\'article','trim|required|min_length[5]|max_length[5000]');
		$this->core->form_validation->set_rules('push_directly','Choix de l\'action','trim|required|min_length[1]|max_length[10]');		
		$this->core->form_validation->set_rules('image_link','Lien de l\'image','trim|required|min_length[5]|max_length[1000]');		
		if($this->core->form_validation->run())
		{
			$this->data['result']	=	$this->news->publish_news(
				$this->core->input->post('news_name'),
				$this->core->input->post('news_content'),
				$this->core->input->post('push_directly'),
				$this->core->input->post('image_link'),
				$this->core->input->post('category')
			);
			if($this->data['result'])
			{
				return 'true';
			}
			else
			{
				return 'false';
			}
		}
	}
	public function edit($e)
	{
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','edit_news',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->data['categories']	=	$this->news->getCat();
		if(count($this->data['categories']) == 0)
		{
			$this->core->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'category','create?notice=noCategoryCreated'));
		}
		// Control Sended Form Datas
		$this->core->load->library('form_validation');
		$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

		$this->core->form_validation->set_rules('news_name','Intitulé de l\'article','trim|required|min_length[5]|max_length[200]');
		$this->core->form_validation->set_rules('news_content','Contenu de l\'article','trim|required|min_length[5]|max_length[5000]');
		$this->core->form_validation->set_rules('push_directly','Choix de l\'action','trim|required|min_length[1]|max_length[1000]');		
		$this->core->form_validation->set_rules('image_link','Lien de l\'image','trim|required|min_length[5]|max_length[1000]');	
		$this->core->form_validation->set_rules('category','Cat&eacute;gorie','trim|required|min_length[1]|max_length[200]');	
		$this->core->form_validation->set_rules('article_id','Identifiant de l\'article','required|min_length[1]');	
		if($this->core->form_validation->run())
		{
			$this->data['result']	=	$this->news->edit(
				$this->core->input->post('article_id'),
				$this->core->input->post('news_name'),
				$this->core->input->post('news_content'),
				$this->core->input->post('push_directly'),
				$this->core->input->post('image_link'),
				$this->core->input->post('category')
			);
			if($this->data['result'])
			{
				$this->notice->push_notice(notice('done'));
			}
			else
			{
				$this->notice->push_notice(notice('error'));
			}
		}
		// Retreiving News Data
		$this->data['news']		=	$this->news->getSpeNews($e);
		$this->hubby->setTitle('Blogster - Créer un nouvel article');
		$this->hubby->loadEditor(3);
		
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/edit',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function category($e = 'index',$i = null)
	{
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','category_manage',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->url->redirect(array('admin','index?notice=accessDenied'));
		}
		if($e == 'index')
		{
			if($i	==	null): $i		=	1;endif; // affecte un lorsque la page n\'est pas correctement défini
			$page						=&	$i; // don't waste memory
			$this->data['ttCat']		=	$this->news->countCat();
			$this->data['paginate']		=	$this->core->hubby->paginate(10,$this->data['ttCat'],1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->core->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'category','index')).'/',$ajaxis_link=null);
			if($this->data['paginate'][3] == FALSE): $this->core->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
			$this->data['getCat']		=	$this->news->getCat($this->data['paginate'][1],$this->data['paginate'][2]);
			$this->hubby->setTitle('Blogster - Gestion des cat&eacute;gories');
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_category',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/category',$this->data,true,TRUE);
				return $this->data['body'];
			}
		}
		else if($e == 'create')
		{
			$this->core->load->library('form_validation');
			$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			$this->core->form_validation->set_rules('cat_name','Nom de la cat&eacute;gorie','required|min_length[3]|max_length[50]');
			$this->core->form_validation->set_rules('cat_description','Description de la cat&eacute;gorie','required|min_length[3]|max_length[200]');
			if($this->core->form_validation->run())
			{
				$this->data['notice']	=	$this->news->createCat(
					$this->core->input->post('cat_name'),
					$this->core->input->post('cat_description')
				);
				$this->notice->push_notice(notice($this->data['notice']));
			}
			$this->notice->push_notice(validation_errors('<p class="error">','</p>'));
			$this->hubby->setTitle('Blogster - Cr&eacute;e une categorie');
			$this->hubby->loadEditor(2);
			
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_manage_cat',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/manage_cat',$this->data,true,TRUE);
				return $this->data['body'];
			}
		}
		else if($e == 'manage' && $i != null)
		{
			$this->core->load->library('form_validation');
			$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			if($this->core->input->post('allower') == 'ALLOWEDITCAT')
			{
				$this->core->form_validation->set_rules('cat_name','Nom de la cat&eacute;gorie','required|min_length[3]|max_length[50]');
				$this->core->form_validation->set_rules('cat_description','Description de la cat&eacute;gorie','required|min_length[3]|max_length[200]');
				if($this->core->form_validation->run())
				{
					$this->data['notice']	=	$this->news->editCat(
						$this->core->input->post('cat_id'),
						$this->core->input->post('cat_name'),
						$this->core->input->post('cat_description')
					);
					$this->notice->push_notice(notice($this->data['notice']));
				}
			}
			else if($this->core->input->post('allower') == 'ALLOWCATDELETION')
			{
				$this->core->form_validation->set_rules('cat_id_for_deletion','Identifiant de la cat&eacute;gorie','required|min_length[1]');
				if($this->core->form_validation->run())
				{
					$this->data['notice']	=	$this->news->deleteCat(
						$this->core->input->post('cat_id_for_deletion')
					);
					if($this->data['notice']	==	'CatDeleted')
					{
						$this->core->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'category?notice='.$this->data['notice']));
					}
					$this->notice->push_notice(notice($this->data['notice']));
				}
			}
			$this->data['cat']			=	$this->news->retreiveCat($i);
			$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/manage_cat',$this->data,true,TRUE);
			return $this->data['body'];
		}
	}
	public function delete($se)
	{
		if(!$this->core->users_global->isSuperAdmin()	&& !$this->hubby_admin->adminAccess('modules','delete_news',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->data['delete']	=	false;
			$this->data['body']		=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/delete_news',$this->data,true,TRUE);
			return array(
				'RETURNED'	=>	$this->data['body'],
				'MCO'		=>	TRUE
			);
		}
		$this->data['delete']		=	$this->news->deleteSpeNews((int)$se);
		$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/delete_news',$this->data,true,TRUE);
		return array(
			'RETURNED'	=>	$this->data['body'],
			'MCO'		=>	TRUE
		);
	}
	public function comments($page	=	1)
	{
		if($this->core->users_global->isSuperAdmin()	|| $this->hubby_admin->adminAccess('modules','blogster_manage_comments',$this->core->users_global->current('PRIVILEGE')))
		{	$this->data['setting']			=	$this->news->getBlogsterSetting();
			$this->data['ttComments']		=	$this->news->countComments();
			$this->data['paginate']		=	$this->core->hubby->paginate(30,$this->data['ttComments'],1,'bg-color-red fg-color-white','bg-color-green fg-color-white',$page,$this->core->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'comments')).'/');
			$this->data['getComments']		=	$this->news->getComments($this->data['paginate'][1],$this->data['paginate'][2]);
			$this->data['body']				=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/list_comments',$this->data,true,TRUE);
			return $this->data['body'];
		}
		else
		{
			$this->core->url->redirect(array('admin','menu?notice=accessDenied'));
		}
	}
	public function comments_manage($id)
	{
		if($this->core->users_global->isSuperAdmin()	|| $this->hubby_admin->adminAccess('modules','blogster_manage_comments',$this->core->users_global->current('PRIVILEGE')))
		{
			$this->core->load->library('form_validation');
			$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			if(isset($_POST['approve']))
			{
				$this->core->form_validation->set_rules('hiddenId','Identifiant du commentaire','trim|required|min_length[1]');
				if($this->core->form_validation->run())
				{
					if($this->news->approveComment($this->core->input->post('hiddenId')))
					{
						$this->core->notice->push_notice(notice('done'));
					}
					else
					{
						$this->core->notice->push_notice(notice('error_occured'));
					}
				}
			}
			else if(isset($_POST['disapprove']))
			{
				$this->core->form_validation->set_rules('hiddenId','Identifiant du commentaire','trim|required|min_length[1]');
				if($this->core->form_validation->run())
				{
					if($this->news->disapproveComment($this->core->input->post('hiddenId')))
					{
						$this->core->notice->push_notice(notice('done'));
					}
					else
					{
						$this->core->notice->push_notice(notice('error_occured'));
					}
				}
			}
			else if(isset($_POST['delete']))
			{
				$this->core->form_validation->set_rules('hiddenId','Identifiant du commentaire','trim|required|min_length[1]');
				if($this->core->form_validation->run())
				{
					if($this->news->deleteComment($this->core->input->post('hiddenId')))
					{
						$this->core->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'comments?notice=commentDeleted'));
					}
				}
			}
			$this->data['speComment']	=	$this->news->getSpeComment($id);
			if(!$this->data['speComment']): $this->core->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'comments?notice=unknowComments'));endif; // redirect if comment doesn't exist.
			$this->hubby->setTitle('Blogster - Gestion de commentaire');
			$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/manage_comments',$this->data,true,TRUE);
			return $this->data['body'];
		}
		else
		{
			$this->core->url->redirect(array('admin','menu?notice=accessDenied'));
		}
	}
	public function setting()
	{
		if($this->core->users_global->isSuperAdmin()	|| $this->hubby_admin->adminAccess('modules','blogster_setting',$this->core->users_global->current('PRIVILEGE')))
		{
			if(isset($_POST['update']))
			{
				$this->core->load->library('form_validation');
				$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

				$this->core->form_validation->set_rules('validateall','','');
				$this->core->form_validation->set_rules('allowPublicComment','','');
				$this->core->form_validation->set_rules('update','','');
				if($this->core->form_validation->run())
				{
					if($this->news->setBlogsterSetting($this->core->input->post('validateall'),$this->core->input->post('allowPublicComment')))
					{
						$this->core->notice->push_notice(notice('done'));
					}
					else
					{
						$this->core->notice->push_notice(notice('error_occured'));
					}; // modification des parametres
				}
			}
			if(isset($_POST['limit_submiter']))
			{
				if($this->news->updateWidgetSetting('CAT',$this->core->input->post('limitcat')))
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			else if(isset($_POST['mostreaded_submiter']))
			{
				if($this->news->updateWidgetSetting('MOSTREADED',$this->core->input->post('mostreaded')))
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			$this->data['setting']		=	$this->news->getBlogsterSetting();
			$this->hubby->setTitle('Blogster - Param&ecirc;tres avanc&eacute;');
				
			$this->data['body']			=	$this->core->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/setting',$this->data,true,TRUE);
			return $this->data['body'];
		}
		else
		{
			$this->core->url->redirect(array('admin','menu?notice=accessDenied'));
		}
	}
}
