<?php
class News_admin_controller
{
	public function __construct($data)
	{
		$this->data						=&	$data;
		__extends($this);
		
		$this->moduleData				=	$this->data['module'][0];
		$this->news						=	new News($this->data);
		$this->data['news']				=&	$this->news;
		
		$this->tendoo_admin->menuExtendsBefore($this->news->getMenu());
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		$this->link						=	MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/';
		/*
			Intégration de la librarie FILE MANAGER : Gestionnaire des fichiers médias.
		*/
		$fileManager					=	$this->tendoo_admin->getSpeModuleByNamespace('tendoo_contents');
		if($fileManager)
		{
			include_once(MODULES_DIR.$fileManager[0]['ENCRYPTED_DIR'].'/utilities.php');
			$this->data['fmlib']	=	new tendoo_contents_utility(); // Loading library
		}
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
						$this->notice->push_notice(hubby_error('Une erreur s\'est produite durant le d&eacute;placement de certaines articles'));
					}
				}
				$this->notice->push_notice(notice('done'));
			}
			else
			{
				$this->notice->push_notice(notice('notForYourPriv'));
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
						$this->notice->push_notice(hubby_error('Une erreur s\'est produite durant la publication de certaines articles'));
					}
				}
				$this->notice->push_notice(notice('done'));
			}
			else
			{
				$this->notice->push_notice(notice('notForYourPriv'));
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
				$this->notice->push_notice(tendoo_info($status['success'].' article(s) a/ont été supprimé(s), '.$status['error'].' article(s) non supprimé(s)'));
			}
			else
			{
				$this->notice->push_notice(notice('notForYourPriv'));
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
			$this->tendoo->paginate(10,$count,1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'index')).'/',$ajaxis_link=null);
		if($this->data['paginate'][3] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
		
		$this->tendoo->setTitle('Blogster - Page d\'administration');
		$this->data['getNews']		=	$this->news->getNews($this->data['paginate'][1],$this->data['paginate'][2],FALSE,$filter);
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/main',$this->data,true,TRUE);
		return $this->data['body'];
	}
	public function publish()
	{
		if($this->tendoo_admin->actionAccess('publish_news','news'))
		{
			$this->file->js_push('jquery-ui-1.10.4.custom.min');
			$this->file->css_push('jquery-ui-1.10.4.custom.min');
			
			$this->data['categories']	=	$this->news->getCat();
			if(count($this->data['categories']) == 0)
			{
				$this->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'category','create?notice=noCategoryCreated'));
			}
			$this->tendoo->setTitle('Blogster - Créer un nouvel article');
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
					$this->input->post('category'),
					FALSE,
					isset($_POST['artKeyWord']) ? $_POST['artKeyWord'] : false,
					$this->input->post('scheduledDate'),
					$this->input->post('scheduledTime')
				);
				if($this->data['result'])
				{
					$this->url->redirect(array('admin','open','modules',$this->data['module'][0]['ID'],'edit',$this->data['result'][0]['ID'].'?notice=artCreated'));
				}
				else
				{
					$this->notice->push_notice(notice('error'));
				}
				
			}
			$this->tendoo->loadEditor(1);
			$this->file->js_url	=	$this->url->main_url();
			$this->file->js_push(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/js/blogster.script');
			return $this->data['body']	=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/publish',$this->data,true,TRUE,$this);
		}
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function edit($e)
	{
		$this->file->js_push('jquery-ui-1.10.4.custom.min');
		$this->file->css_push('jquery-ui-1.10.4.custom.min');
		if(!$this->tendoo_admin->actionAccess('edit_news','news'))
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->data['categories']	=	$this->news->getCat();
		if(count($this->data['categories']) == 0)
		{
			$this->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'category','create?notice=noCategoryCreated'));
		}
		// Control Sended Form Datas
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');

		$this->form_validation->set_rules('news_name','Intitulé de l\'article','trim|max_length[200]');
		$this->form_validation->set_rules('news_content','Contenu de l\'article','trim|max_length[20000]');
		$this->form_validation->set_rules('push_directly','Choix de l\'action','trim|max_length[10]');		
		$this->form_validation->set_rules('image_link','Lien de l\'image','trim|max_length[1000]');		
		$this->form_validation->set_rules('thumb_link','Lien de l\'image','trim|max_length[1000]');		
		$this->form_validation->set_rules('category','Cat&eacute;gorie','trim|min_length[1]|max_length[200]');	
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
				$this->input->post('category'),
				isset($_POST['artKeyWord']) ? $_POST['artKeyWord'] : false,
				$this->input->post('scheduledDate'),
				$this->input->post('scheduledTime')
			);
			if($this->data['result'])
			{
				$this->notice->push_notice(tendoo_success('Article mis à jour. <a href="'.$this->url->site_url(array('tendoo@news','read',$this->data['result'][0]['ID'],$this->tendoo->urilizeText($this->data['result'][0]['TITLE']).'?mode=preview')).'" style="text-decoration:underline" target="_blank">cliquez pour voir un aperçu</a>'));
			}
			else
			{
				$this->notice->push_notice(notice('error'));
			}
		}
		// Retreiving News Data
		$this->data['getSpeNews']		=	$this->news->getSpeNews($e);
		$this->tendoo->setTitle('Blogster - Modifier un article');
		$this->tendoo->loadEditor(1);
	
		$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/edit',$this->data,true,TRUE,$this);
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
			if($i	==	null): $i		=	1;endif; // affecte un lorsque la page n\'est pas correctement défini
			$page						=&	$i; // don't waste memory
			$this->data['ttCat']		=	$this->news->countCat();
			$this->data['paginate']		=	$this->tendoo->paginate(10,$this->data['ttCat'],1,'bg-color-blue fg-color-white','bg-color-white fg-color-blue',$page,$this->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'category','index')).'/',$ajaxis_link=null);
			if($this->data['paginate'][3] == FALSE): $this->url->redirect(array('error','code','page404'));endif; // redirect if page incorrect
			$this->data['getCat']		=	$this->news->getCat($this->data['paginate'][1],$this->data['paginate'][2]);
			$this->tendoo->setTitle('Blogster - Gestion des cat&eacute;gories');
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_category',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/category',$this->data,true,TRUE);
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
				$this->notice->push_notice(notice($this->data['notice']));
			}
			$this->notice->push_notice(validation_errors('<p class="error">','</p>'));
			$this->tendoo->setTitle('Blogster - Cr&eacute;e une categorie');
			
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_create_cat',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/create_cat',$this->data,true,TRUE);
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
					$this->notice->push_notice(notice($this->data['notice']));
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
						$this->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'category?notice='.$this->data['notice']));
					}
					$this->notice->push_notice(notice($this->data['notice']));
				}
			}
			$this->data['cat']			=	$this->news->retreiveCat($i);
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_manage_cat',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/manage_cat',$this->data,true,TRUE);
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
				'message'	=>		strip_tags(notice('notForYourPriv')),
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
			$this->data['paginate']		=	$this->tendoo->paginate(30,$this->data['ttComments'],1,'bg-color-red fg-color-white','bg-color-green fg-color-white',$page,$this->url->site_url(array('admin','open','modules',$this->moduleData['ID'],'comments')).'/');
			$this->data['getComments']		=	$this->news->getComments($this->data['paginate'][1],$this->data['paginate'][2]);
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_list_comments',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/list_comments',$this->data,true,TRUE);
				return $this->data['body'];
			}
			$this->data['body']				=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/list_comments',$this->data,true,TRUE);
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
						$this->notice->push_notice(notice('done'));
					}
					else
					{
						$this->notice->push_notice(notice('error_occured'));
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
						$this->notice->push_notice(notice('done'));
					}
					else
					{
						$this->notice->push_notice(notice('error_occured'));
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
						$this->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'comments?notice=commentDeleted'));
					}
				}
			}
			$this->data['speComment']	=	$this->news->getSpeComment($id);
			if(!$this->data['speComment']): $this->url->redirect(array('admin','open','modules',$this->moduleData['ID'],'comments?notice=unknowComments'));endif; // redirect if comment doesn't exist.
			$this->tendoo->setTitle('Blogster - Gestion de commentaire');
			if(isset($_GET['ajax']))
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_manage_comments',$this->data,true,TRUE);
				return array(
					'RETURNED'			=>	$this->data['body'],
					'MCO'				=>	TRUE
				);
			}
			else
			{
				$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/manage_comments',$this->data,true,TRUE);
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
						$this->notice->push_notice(notice('done'));
					}
					else
					{
						$this->notice->push_notice(notice('error_occured'));
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
					$this->notice->push_notice(tendoo_info($status['success'].' requête(s) a/ont correctement été exécutée(s), '.$status['error'].' requête(s) n\'a/ont pas pu être exécutée(s)'));
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
			$this->tendoo->setTitle('Blogster - Param&ecirc;tres avanc&eacute;');
			
			$this->data['body']			=	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/setting',$this->data,true,TRUE);
			return $this->data['body'];
		}
		else
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
	}
	public function ajax($section)
	{
		if($section == 'createCategory')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('categoryName','Du nom de la cat&eacutegorie','trim|required');
			if($this->form_validation->run())
			{
				if($this->data['news']->createCat($this->input->post('categoryName'),'Aucune description Enregistr&eacute;e') == 'categoryCreated')
				{
					$this->data['message']	=	'La cat&eacute;gorie &agrave; &eacute;t&eacute; cr&eacute;e.';
					$this->data['notice_type']	=	'success';
				}
				else
				{
					$this->data['message']	=	"Une erreur s\'est produite durant la cr&eacute;ation de la cat&eacute;gorie. V&eacute;rifiez qu\'une cat&eacutegorie ayant le m&ecirc;me nom n\'existe pas d&eacute;j&agrave;.";
					$this->data['notice_type']	=	'warning';
				}
				return array(
					'MCO'		=>	TRUE,
					'RETURNED'	=>	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_creatingCategory',$this->data,true,TRUE)
				);
			}
			else
			{
				$this->data['message']			=	"Le nom de la cat&eacute;gorie n\'est pas valide";
				$this->data['notice_type']	=	'warning';
				return array(
					'MCO'		=>	TRUE,
					'RETURNED'	=>	$this->load->view(MODULES_DIR.$this->moduleData['ENCRYPTED_DIR'].'/views/ajax_creatingCategory',$this->data,true,TRUE)
				);
			}
		}
	}
}
