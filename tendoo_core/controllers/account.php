<?php 
class Account
{
	private $data;
	private $Tendoo;
	private $notice;
	private $file;
	private $url;
	private $core;
	private $load;
	public function __construct()
	{
		$this->core		=	Controller::instance();
		$this->tendoo	=&	$this->core->tendoo;
		$this->url		=&	$this->core->url;
		$this->notice	=&	$this->core->notice;
		$this->load		=&	$this->core->load;
		$this->load->library('file');
		$this->load->library('users_global');
		$this->file		=&	$this->core->file;
		$this->core->file_2	=	new File;
		// out put files
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('css1');
		$this->core->file->css_push('css2');
		$this->core->file->css_push('tendoo_global');

		$this->core->file->js_push('jquery-1.9');
		$this->core->file->js_push('jquery.pjax');
		$this->core->file->js_push('morris.min');
		$this->core->file->js_push('raphael-min');
		$this->core->file_2->js_push('app.v2');
		$this->core->file->js_push('tendoo_app');
		
		if(!$this->core->users_global->isConnected())
		{
			$this->url->redirect(array('login?ref='.urlencode($this->url->request_uri())));
			return;
		}
		$this->data['left_menu']			=	$this->load->view('account/left_menu',$this->data,true);
		$this->data['smallHeader']			=	$this->load->view('account/smallHeader',$this->data,true);

	}
	public function index()
	{
		$this->tendoo->setTitle('Mon profil');
		$this->tendoo->setDescription('Mon profil');
		$this->data['body']			=	$this->load->view('account/profile/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function profile_update()
	{
		$this->load->library('form_validation');
		$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
		if($this->core->input->post('user_name'))
		{
			$this->core->users_global->setUserElement('NAME', $this->core->input->post('user_name'));
			$this->core->notice->push_notice(notice('userNameUpdated'));
		}
		if($this->core->input->post('user_surname'))
		{
			$this->core->users_global->setUserElement('SURNAME', $this->core->input->post('user_surname'));
			$this->core->notice->push_notice(notice('userSurnameUpdated'));
		}
		if($this->core->input->post('user_state'))
		{
			$this->core->users_global->setUserElement('STATE', $this->core->input->post('user_state'));
			$this->core->notice->push_notice(notice('userStateUpdated'));
		}
		if($this->core->input->post('user_town'))
		{
			$this->core->users_global->setUserElement('TOWN', $this->core->input->post('user_town'));
			$this->core->notice->push_notice(notice('userTownUpdated'));
		}
		$this->tendoo->setTitle('Mettre mon profil &agrave; jour');
		$this->tendoo->setDescription('Mettre mon profil &agrave; jour');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
		$this->data['body']			=	$this->load->view('account/update_prof/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function messaging($index	=	'home',$start= 1,$end = 1,$x	=	0)
	{
		$this->core->tendoo->timestamp();
		if($index 	== 'home')
		{
			$this->load->library('form_validation');
			$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->core->form_validation->set_rules('conv_id','Identifiant du message','required');
			if($this->core->form_validation->run())
			{
				if(is_array($_POST['conv_id']))
				{
					foreach($_POST['conv_id'] as $c)
					{
						$result	=	$this->core->users_global->deleteConversation($c);
						if($result	== false)
						{
							$this->core->notice->push_notice('Une erreur est survenu durant la suppression du message, il ne vous est surement pas destinée ou ce message n\'existe pas');
						}
						else
						{
							$this->core->notice->push_notice(notice('done'));
						}
					}
				}
				else
				{
					$result	=	$this->core->users_global->deleteConversation($_POST['conv_id']);
					if($result	== false)
					{
						$this->core->notice->push_notice('Une erreur est survenu durant la suppression du message, il ne vous est surement pas destinée ou ce message n\'existe pas');
					}
					else
					{
						$this->core->notice->push_notice(notice('done'));
					}
				}
			}
			$this->tendoo->setTitle('Messagerie');
			$this->tendoo->setDescription('Tendoo Users Account');
			$this->data['ttMessage']	=	$this->core->users_global->countMessage();
			$this->data['paginate']		=	$this->core->tendoo->paginate(30,$this->data['ttMessage'],1,'ClasseOn','ClasseOff',$start,$this->core->url->site_url(array('account','messaging','home')).'/',null);
			$this->data['getMessage']	=	$this->core->users_global->getMessage($this->data['paginate'][1],$this->data['paginate'][2]);$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/body',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
		else if($index	== 'write')
		{
			$this->load->library('form_validation');
			$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->core->form_validation->set_rules('receiver','Pseudo du correspondant','trim|required|min_length[5]|max_length[15]');
			$this->core->form_validation->set_rules('content','Contenu du message','trim|required|min_length[3]|max_length[1200]');
			if($this->core->form_validation->run())
			{
				$result	=	$this->core->users_global->write(
					$this->core->input->post('receiver'),
					$this->core->input->post('content')
				);
				if($result	==	'posted')
				{
					$this->core->url->redirect(array('account','messaging','home'));
				}
				else
				{
					$this->core->notice->push_notice(notice('error_occured'));
				}
			}
			
			$this->tendoo->setTitle('Messagerie');
			$this->tendoo->setDescription('Tendoo Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/write',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		
		}
		else if($index	==	'open')
		{
			$this->load->library('form_validation');
			$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->core->form_validation->set_rules('reply','Contenu du message','trim|required|min_length[3]|max_length[1200]');
			$this->core->form_validation->set_rules('convid','Identifiant de la convesation','trim|required|min_length[1]');
			if($this->core->form_validation->run())
			{
				$result	=	$this->core->users_global->addPost($this->core->input->post('convid'),$this->core->input->post('reply'));
				if($result	==	true)
				{
					$this->core->notice->push_notice(notice('done'));
				}
				else
				{
					$this->core->notice->push_notice('Le message n\'a pas pu &ecirc;tre post&eacute; parceque vous n\'avez pas directement acc&egrave;s, soit parceque cette discution n\'existe pas ou plus.');
				}
			}
			$this->core->users_global->editStatus($start);
			$this->data['ttMsgContent']	=	$this->core->users_global->countMsgContent($start);
			$this->data['paginate']		=	$this->tendoo->paginate(30,$this->data['ttMsgContent'],1,'bg-color-red fg-color-white','bg-color-blue',$end,$this->core->url->site_url(array('account','messaging','open',$start)).'/',$ajaxis_link=null);
			if($this->data['paginate'][3]	==	false)
			{
				$this->core->url->redirect(array('page404'));
			}
			$this->data['getMsgContent']=	$this->core->users_global->getMsgContent($start,$this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->tendoo->setTitle('Messagerie &raquo; Lecture');
			$this->tendoo->setDescription('Tendoo Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/read',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
	}
}