<?php
class blogster_backend extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->_config();
		$this->data						=	$data;
		$this->instance					=	get_instance();
		$this->opened_module			=	get_core_vars( 'opened_module' );
		$this->data['module']			=	get_core_vars( 'opened_module' );
		$this->news						=	new blogster_library($this->data);
		$this->data['news']				=&	$this->news;
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		$this->link						=	MODULES_DIR.$this->opened_module['encrypted_dir'].'/';
		/*
			Intégration de la librarie FILE MANAGER : Gestionnaire des fichiers médias.
		*/
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$fileManager					=	get_modules( 'filter_namespace' , 'tendoo_contents' );
		if($fileManager)
		{
			include_once(MODULES_DIR.$fileManager['encrypted_dir'].'/utilities.php');
			$this->data['fmlib']	=	new tendoo_contents_utility(); // Loading library
		}
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	}
	private function _config()
	{
		setup_admin_left_menu( 'Blogster' , 'file-text-o' );
		add_admin_left_menu( 'Accueil' , module_url( array( 'index' ) ) );
		add_admin_left_menu( 'Ajouter un article' , module_url( array( 'publish' ) ) );
		add_admin_left_menu( 'Gestion des catégories' , module_url( array( 'category' ) ) );
		add_admin_left_menu( 'Gestion des commentaires' , module_url( array( 'comments' ) ) );
		add_admin_left_menu( 'Gestion des mots-clés' , module_url( array( 'tags' ) ) );
		add_admin_left_menu( 'Réglages' , module_url( array( 'setting' ) ) );
	}
	public function index($page	= 1)
	{
		if($this->input->post('draftSelected'))
		{
			if($this->tendoo_admin->actionAccess('edit_news','news'))
			{
				foreach($_POST['art_id'] as $id)
				{
					if(!$this->news->moveSpeNewsToDraft($id))
					{
						notice('push',hubby_error('Une erreur s\'est produite durant le d&eacute;placement de certaines articles'));
					}
				}
				notice('push',fetch_notice_output('done'));
			}
			else
			{
				notice('push',fetch_notice_output('notForYourPriv'));
			}
		}
		if($this->input->post('publishSelected'))
		{
			if($this->tendoo_admin->actionAccess('edit_news','news'))
			{
				foreach($_POST['art_id'] as $id)
				{
					if(!$this->news->publishSpeNews($id))
					{
						notice('push',hubby_error('Une erreur s\'est produite durant la publication de certaines articles'));
					}
				}
				notice('push',fetch_notice_output('done'));
			}
			else
			{
				notice('push',fetch_notice_output('notForYourPriv'));
			}
		}
		if($this->input->post('deleteSelected'))
		{
			if($this->tendoo_admin->actionAccess('delete_news','news'))
			{
				$status	=	array();
				$status['error']	=	0;
				$status['success']	=	0;
				foreach($_POST['art_id'] as $id)
				{
					if($this->news->deleteSpeNews($id))
					{
						$status['success']++;
					}
					else
					{
						$status['error']++;
					}
				}
				notice('push',tendoo_info($status['success'].' article(s) a/ont été supprimé(s), '.$status['error'].' article(s) non supprimé(s)'));
			}
			else
			{
				notice('push',fetch_notice_output('notForYourPriv'));
			}
		}
		// Filtre
		$this->data['ttNews']			=	$this->news->countNews();
		$this->data['ttMines']			=	$this->news->countNews('mines');
		$this->data['ttScheduled']		=	$this->news->countNews('scheduled');
		$count	=	$this->data['ttNews'];
		$filter	=	'default';
		if(isset($_GET['filter']))
		{
			$filter	=	$_GET['filter'];
			if($filter	==	'mines')
			{
				$count	=	$this->data['ttMines'];
			}
			else if($filter	==	'scheduled')
			{
				$count	=	$this->data['ttScheduled'];
			}
		}
		$this->data['lastestComments']	=	$this->news->getComments(0,5);	
		$this->data['paginate']	=	
		$this->tendoo->paginate(10,$count,1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->url->site_url(array('admin','open','modules',$this->opened_module['namespace'],'index')).'/',$ajaxis_link=null);
		if($this->data['paginate'][3] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
		set_page('title','Blogster - Page d\'administration');
		$this->data['getNews']		=	$this->news->getNews($this->data['paginate'][1],$this->data['paginate'][2],FALSE,$filter);
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/main',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function publish()
	{
		if($this->tendoo_admin->actionAccess('publish_news','news'))
		{
			js_push_if_not_exists('jquery-ui-1.10.4.custom.min');
			css_push_if_not_exists('jquery-ui-1.10.4.custom.min');
			
			$this->data['categories']	=	$this->news->getCat();
			if(count($this->data['categories']) == 0)
			{
				$this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'],'category','create?notice=noCategoryCreated'));
			}
			set_page('title','Blogster - Créer un nouvel article');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			$this->form_validation->set_rules('news_name','Intitulé de l\'article','trim|max_length[200]');
			$this->form_validation->set_rules('news_content','Contenu de l\'article','trim|max_length[20000]');
			$this->form_validation->set_rules('push_directly','Choix de l\'action','trim|max_length[10]');		
			$this->form_validation->set_rules('image_link','Lien de l\'image','trim|max_length[1000]');		
			$this->form_validation->set_rules('thumb_link','Lien de l\'image','trim|max_length[1000]');		
			if($this->form_validation->run())
			{
				$this->data['result']	=	$this->news->publish_news(
					$this->input->post('news_name'),
					$this->input->post('news_content'),
					$this->input->post('push_directly'),
					$this->input->post('image_link'),
					$this->input->post('thumb_link'),
					isset($_POST['category']) ? $_POST['category'] : array(1), // expecitng Array
					FALSE,
					isset($_POST['artKeyWord']) ? $_POST['artKeyWord'] : false,
					$this->input->post('scheduledDate'),
					$this->input->post('scheduledTime')
				);
				if($this->data['result'])
				{
					$this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'],'edit',$this->data['result'][0]['ID'].'?info=Article crée. <a href="'.$this->url->site_url(array('tendoo@news','lecture',$this->data['result'][0]['URL_TITLE'].'?mode=preview'.'" style="text-decoration:underline" target="_blank">cliquez pour voir un aperçu</a>'))));
				}
				else
				{
					notice('push',fetch_notice_output('error'));
				}
				
			}
			$this->instance->visual_editor->loadEditor(1);
			// Ajout des fichier du plugin bootstrap mutiselect
			$this->file->js_url	=	$this->url->main_url();
			js_push_if_not_exists(MODULES_DIR.$this->opened_module['encrypted_dir'].'/js/bootstrap-multiselect');
			$this->file->css_url=	$this->url->main_url();
			css_push_if_not_exists(MODULES_DIR.$this->opened_module['encrypted_dir'].'/css/bootstrap-multiselect');
			// Loading Bloster Script
			$this->file->js_url	=	$this->url->main_url();
			js_push_if_not_exists(MODULES_DIR.$this->opened_module['encrypted_dir'].'/js/blogster.script');
			return $this->data['body']	=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/publish',$this->data,true,TRUE,$this);
		}
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function edit($e)
	{
		js_push_if_not_exists('jquery-ui-1.10.4.custom.min');
		css_push_if_not_exists('jquery-ui-1.10.4.custom.min');
		
		if(!$this->tendoo_admin->actionAccess('edit_news','news'))
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->data['categories']	=	$this->news->getCat();
		if(count($this->data['categories']) == 0)
		{
			$this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'],'category','create?notice=noCategoryCreated'));
		}
		// Control Sended Form Datas
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

		$this->form_validation->set_rules('news_name','Intitulé de l\'article','trim|max_length[200]');
		$this->form_validation->set_rules('news_content','Contenu de l\'article','trim|max_length[20000]');
		$this->form_validation->set_rules('push_directly','Choix de l\'action','trim|max_length[10]');		
		$this->form_validation->set_rules('image_link','Lien de l\'image','trim|max_length[1000]');		
		$this->form_validation->set_rules('thumb_link','Lien de l\'image','trim|max_length[1000]');		
		// $this->form_validation->set_rules('category','Cat&eacute;gorie','trim|min_length[1]|max_length[200]');	
		$this->form_validation->set_rules('article_id','Identifiant de l\'article','required|min_length[1]');	
		if($this->form_validation->run())
		{
			$this->data['result']	=	$this->news->edit(
				$this->input->post('article_id'),
				$this->input->post('news_name'),
				$this->input->post('news_content'),
				$this->input->post('push_directly'),
				$this->input->post('image_link'),
				$this->input->post('thumb_link'),
				isset($_POST['category']) ? $_POST['category']	:	array(1), // Setting Default categoryArray if not set
				isset($_POST['artKeyWord']) ? $_POST['artKeyWord'] : false,
				$this->input->post('scheduledDate'),
				$this->input->post('scheduledTime')
			);
			if($this->data['result'])
			{
				notice('push',tendoo_success('Article mis à jour. <a href="'.$this->url->site_url(array('tendoo@news','lecture',$this->data['result'][0]['URL_TITLE'].'?mode=preview')).'" style="text-decoration:underline" target="_blank">cliquez pour voir un aperçu</a>'));
			}
			else
			{
				notice('push',fetch_notice_output('error'));
			}
		}
		// Retreiving News Data
		$this->data['getSpeNews']		=	$this->news->getSpeNews($e);
		if($this->data['getSpeNews'] == false)
		{
			module_location(array('index?notice=unknowArticle'));
		}
		// Récupération des mots clés de l'article.
		$this->data['getKeyWords']		=	$this->news->getNewsKeyWords($e);
//		var_dump($this->data['getKeyWords']);
		$this->data['getNewsCategories']=	$this->news->getArticlesRelatedCategory($e);
		// Définition du titre		
		set_page('title','Blogster - Modifier un article');
		// Chargement de l'éditeur
		$this->instance->visual_editor->loadEditor(1);
		// Ajout des fichier du plugin bootstrap mutiselect
		$this->file->js_url	=	$this->url->main_url();
		js_push_if_not_exists(MODULES_DIR.$this->opened_module['encrypted_dir'].'/js/bootstrap-multiselect');
		$this->file->css_url=	$this->url->main_url();
		css_push_if_not_exists(MODULES_DIR.$this->opened_module['encrypted_dir'].'/css/bootstrap-multiselect');
		// Loading Bloster Script
		$this->file->js_url	=	$this->url->main_url();
		js_push_if_not_exists(MODULES_DIR.$this->opened_module['encrypted_dir'].'/js/blogster.script');
		
	
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/edit',$this->data,true,TRUE,$this);
		return $this->data['body'];
	}
	public function category($e = 'index',$i = null)
	{
		if(!$this->tendoo_admin->actionAccess('category_manage','news'))
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		if($e == 'index')
		{
			if($this->input->post('action') == 'delete')
			{
				$exec	=	$this->news->deleteBulkCat($_POST['cat_id']);
				module_location('category?info='.$exec['success'].' catégorie(s) supprimé(s). '.$exec['error']. ' erreur(s)');
			}
			if($i	==	null): $i		=	1;endif; // affecte un lorsque la page n\'est pas correctement défini
			$page						=&	$i; // don't waste memory
			$this->data['ttCat']		=	$this->news->countCat();
			$this->data['paginate']		=	$this->tendoo->paginate(10,$this->data['ttCat'],1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->url->site_url(array('admin','open','modules',$this->opened_module['namespace'],'category','index')).'/',$ajaxis_link=null);
			if($this->data['paginate'][3] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
			$this->data['getCat']		=	$this->news->getCat($this->data['paginate'][1],$this->data['paginate'][2]);
			set_page('title','Blogster - Gestion des cat&eacute;gories');
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/ajax_category',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/category',$this->data,true,TRUE);
				return $this->data['body'];
			}
		}
		else if($e == 'create')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			$this->form_validation->set_rules('cat_name','Nom de la cat&eacute;gorie','required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('cat_description','Description de la cat&eacute;gorie','required|min_length[3]|max_length[200]');
			if($this->form_validation->run())
			{
				$this->data['notice']	=	$this->news->createCat(
					$this->input->post('cat_name'),
					$this->input->post('cat_description')
				);
				notice('push',fetch_notice_output($this->data['notice']));
			}
			notice('push',validation_errors('<p class="error">','</p>'));
			set_page('title','Blogster - Cr&eacute;e une categorie');
			
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/ajax_create_cat',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/create_cat',$this->data,true,TRUE);
				return $this->data['body'];
			}
		}
		else if($e == 'manage' && $i != null)
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			if($this->input->post('allower') == 'ALLOWEDITCAT')
			{
				$this->form_validation->set_rules('cat_name','Nom de la cat&eacute;gorie','required|min_length[3]|max_length[50]');
				$this->form_validation->set_rules('cat_description','Description de la cat&eacute;gorie','required|min_length[3]|max_length[200]');
				if($this->form_validation->run())
				{
					$this->data['notice']	=	$this->news->editCat(
						$this->input->post('cat_id'),
						$this->input->post('cat_name'),
						$this->input->post('cat_description')
					);
					notice('push',fetch_notice_output($this->data['notice']));
				}
			}
			else if($this->input->post('allower') == 'ALLOWCATDELETION')
			{
				$this->form_validation->set_rules('cat_id_for_deletion','Identifiant de la cat&eacute;gorie','required|min_length[1]');
				if($this->form_validation->run())
				{
					$this->data['notice']	=	$this->news->deleteCat(
						$this->input->post('cat_id_for_deletion')
					);
					if($this->data['notice']	==	'CatDeleted')
					{
						$this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'],'category?notice='.$this->data['notice']));
					}
					notice('push',fetch_notice_output($this->data['notice']));
				}
			}
			$this->data['cat']			=	$this->news->retreiveCat($i);
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/ajax_manage_cat',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/manage_cat',$this->data,true,TRUE);
				return $this->data['body'];
			}
		}
	}
	public function delete($se)
	{
		if(!$this->tendoo_admin->actionAccess('delete_news','news'))
		{
			$result	= array(
				'status'	=>		'warning',
				'message'	=>		strip_tags(fetch_notice_output('notForYourPriv')),
				'alertType'	=>		'modal',
				'response'	=>		'null'
			);
			return array(
				'RETURNED'	=>	json_encode($result),
				'MCO'		=>	TRUE
			);
		}
		else
		{
			$this->data['delete']		=	$this->news->deleteSpeNews((int)$se);
			$result	= array(
				'status'	=>		'success',
				'message'	=>		'message supprimé',
				'alertType'	=>		'notice',
				'response'	=>		'null'
			);
			return array(
				'RETURNED'	=>	json_encode($result),
				'MCO'		=>	TRUE
			);
		}
	}
	public function comments($page	=	1)
	{
		if($this->tendoo_admin->actionAccess('blogster_manage_comments','news'))
		{	
			$this->data['setting']			=	$this->news->getBlogsterSetting();
			$this->data['ttComments']		=	$this->news->countComments();
			$this->data['paginate']		=	$this->tendoo->paginate(30,$this->data['ttComments'],1,'bg-color-red fg-color-white','bg-color-green fg-color-white',$page,$this->url->site_url(array('admin','open','modules',$this->opened_module['namespace'],'comments')).'/');
			$this->data['getComments']		=	$this->news->getComments($this->data['paginate'][1],$this->data['paginate'][2]);
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/ajax_list_comments',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/list_comments',$this->data,true,TRUE);
				return $this->data['body'];
			}
			$this->data['body']				=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/list_comments',$this->data,true,TRUE);
			return $this->data['body'];
		}
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function comments_manage($id)
	{
		if($this->tendoo_admin->actionAccess('blogster_manage_comments','news'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

			if(isset($_POST['approve']))
			{
				$this->form_validation->set_rules('hiddenId','Identifiant du commentaire','trim|required|min_length[1]');
				if($this->form_validation->run())
				{
					if($this->news->approveComment($this->input->post('hiddenId')))
					{
						notice('push',fetch_notice_output('done'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occured'));
					}
				}
			}
			else if(isset($_POST['disapprove']))
			{
				$this->form_validation->set_rules('hiddenId','Identifiant du commentaire','trim|required|min_length[1]');
				if($this->form_validation->run())
				{
					if($this->news->disapproveComment($this->input->post('hiddenId')))
					{
						notice('push',fetch_notice_output('done'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occured'));
					}
				}
			}
			else if(isset($_POST['delete']))
			{
				$this->form_validation->set_rules('hiddenId','Identifiant du commentaire','trim|required|min_length[1]');
				if($this->form_validation->run())
				{
					if($this->news->deleteComment($this->input->post('hiddenId')))
					{
						$this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'],'comments?notice=commentDeleted'));
					}
				}
			}
			$this->data['speComment']	=	$this->news->getSpeComment($id);
			if(!$this->data['speComment']): $this->url->redirect(array('admin','open','modules',$this->opened_module['namespace'],'comments?notice=unknowComments'));endif; // redirect if comment doesn't exist.
			set_page('title','Blogster - Gestion de commentaire');
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/ajax_manage_comments',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/manage_comments',$this->data,true,TRUE);
				return $this->data['body'];
			}
		}
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function setting()
	{
		if($this->tendoo_admin->actionAccess('blogster_setting','news'))
		{
			if(isset($_POST['update']))
			{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

				$this->form_validation->set_rules('validateall','','');
				$this->form_validation->set_rules('allowPublicComment','','');
				$this->form_validation->set_rules('update','','');
				if($this->form_validation->run())
				{
					if($this->news->setBlogsterSetting($this->input->post('validateall'),$this->input->post('allowPublicComment')))
					{
						notice('push',fetch_notice_output('done'));
					}
					else
					{
						notice('push',fetch_notice_output('error_occured'));
					}; // modification des parametres
				}
			}
			if(isset($_FILES['import']))
			{
				$config['file_name']		=	'backup';
				$config['overwrite']		=	TRUE;
				$config['upload_path'] 		= 	$this->link;
				$config['allowed_types'] 	= 	'json';
				$config['remove_spaces']	=	TRUE;
				$this->load->library('upload', $config,null,$this);
				$this->upload->do_upload('import');
				if(is_file($this->link.'backup.json'))
				{
					$content				=	file_get_contents($this->link.'backup.json');
					$fullArray				=	json_decode($content,TRUE);
					$status					=	$this->news->doImport($fullArray);
					notice('push',tendoo_info($status['success'].' requête(s) a/ont correctement été exécutée(s), '.$status['error'].' requête(s) n\'a/ont pas pu être exécutée(s)'));
					unlink($this->link.'backup.json');
				}
			}
			if($this->input->post('export'))
			{
				// Prevent output
				ob_clean();
				$options	=	site_options();
				// exportation des données
				header('Content-type: application/octect-stream');
				header('Content-Disposition: attachment; filename="'.$options[0]['SITE_NAME'].'_blogster_backup.json"');
				echo $this->news->export();
				die();
			}
			$this->data['setting']		=	$this->news->getBlogsterSetting();
			set_page('title','Blogster - Param&ecirc;tres avanc&eacute;');
			
			$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/setting',$this->data,true,TRUE);
			return $this->data['body'];
		}
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function tags($action = 'index', $page	=	1)
	{
		if(module_action('blogster_manage_tags','news'))
		{
			// Get All keyWords
			$this->data['totalKeyWords']=	count($this->news->getAllPopularKeyWords('all'));
			// Starting Pagination
			$_elPP	=	isset($_GET['limit']) ? $_GET['limit'] : 10;
			$this->data['paginate']		=	pagination_helper(
				$_elPP,
				$this->data['totalKeyWords'],
				$page,
				module_url(array('tags','index'))
			);
			// Get KeyWord Using Page Pagination
			$this->data['getKeywords']	=	$this->news->getAllPopularKeyWords('limitedTo',$this->data['paginate']['start'],$this->data['paginate']['end']);
			// Set Page Title
			set_page('title','Blogster - Gestion des mots clés');
			
			$this->data['body']			=	$this->load->view(MODULES_DIR.$this->opened_module['encrypted_dir'].'/views/keywords_main',$this->data,true,TRUE,$this);
			return $this->data['body'];
		}
		else
		{
			module_location('?notice=accessDenied');
		}
	}
	public function ajax($section,$params2="",$params3="")
	{
		if($section == 'createCategory')
		{
			$array	=	array(
				'status'	=>		'warning',
				'alertType'	=>		'modal',
				'message'	=>		'La catégoie n\'a pas pu être créer, vérifiez qu\'une catégorie ayant le même nom n\'existe pas déjà.',
				'response'	=>		'cat_creation_error'
			);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('categoryName','Du nom de la cat&eacutegorie','trim|required');
			if($this->form_validation->run())
			{
				$cat	=	$this->data['news']->createCat($this->input->post('categoryName'),'Aucune description Enregistr&eacute;e');
				if($cat)
				{
					$array	=	array(
						'status'	=>		'success',
						'alertType'	=>		'notice',
						'message'	=>		'La catégorie a correctement été créé.',
						'response'	=>		'cat_created',
						'exec'		=>		'function(){
							$(".multiselect").multiselect("destroy");
							$(".multiselect").append("<option value=\"'.$cat[0]['ID'].'\">'.$cat[0]['CATEGORY_NAME'].'</option>")							
							$(".multiselect").multiselect({
								dropRight		: true,
								nonSelectedText	: "Veuillez choisir",
								nSelectedText	:	"cochés",
								enableFiltering	:	true								
							});
						}'
					);
				}
				
			}
			else
			{
				$array	=	array(
					'status'	=>		'warning',
					'alertType'	=>		'modal',
					'message'	=>		'La catégoie n\'a pas pu être créer, vérifiez le nom de la catégorie.',
					'response'	=>		'cat_creation_error'
				);
			}
			return array(
				'MCO'		=>	TRUE,
				'RETURNED'	=>	json_encode($array)
			);
		}
		else if($section == 'tags')
		{
			if($params2 == 'delete')
			{
				// Suppression de mots clés.
				$result	=	$this->news->deleteKeyWords($params3);
				return array(
					'RETURNED'	=>	json_encode($result),
					'MCO'		=>	TRUE
				);
			}
			if($params2 == 'create')
			{
				$this->load->library('form_validation',null,null,$this);
				$this->form_validation->set_rules('kw_title','Champs du titre du mot clé','required|min_length[1]|max_length[30]');
				if($this->form_validation->run())
				{
					$result	=	$this->news->createKeyWord($this->input->post('kw_title'),$this->input->post('kw_description'));
					return array(
						'RETURNED'	=>	json_encode($result),
						'MCO'		=>	TRUE
					);
				}
				else
				{
					return array(
						'RETURNED'	=>	json_encode(array(
							'message'	=>	validation_errors(),
							'alertType'	=>	'modal',
							'status'	=>	'warning',
							'response'	=>	''
						)),
						'MCO'		=>	TRUE
					);
				}
			}
		}
	}
}
