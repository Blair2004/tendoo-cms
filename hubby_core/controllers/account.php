<?php 
class Account
{
	private $data;
	private $hubby;
	private $notice;
	private $file;
	private $url;
	private $core;
	private $load;
	public function __construct()
	{
		$this->core		=	Controller::instance();
		$this->hubby	=&	$this->core->hubby;
		$this->url		=&	$this->core->url;
		$this->notice	=&	$this->core->notice;
		$this->load		=&	$this->core->load;
		$this->load->library('file');
		$this->load->library('users_global');
		$this->file		=&	$this->core->file;
		// out put files
		$this->core->file->css_push('modern');
		$this->core->file->css_push('modern-responsive');
		$this->core->file->css_push('hubby_default');
		$this->core->file->css_push('ub.framework');
		$this->core->file->css_push('hubby_global');

		$this->core->file->js_push('jquery');
		$this->core->file->js_push('dropdown');
		$this->core->file->js_push('hubby_app');
		$this->core->file->js_push('resizer');
		$this->core->file->js_push('dialog');
		
		if(!$this->core->users_global->isConnected())
		{
			$this->url->redirect(array('login?ref='.urlencode($this->url->request_uri())));
			return;
		}

	}
	public function index()
	{
		$this->hubby->setTitle('Mon profil');
		$this->hubby->setDescription('Mon profil');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
		$this->data['body']			=	$this->load->view('account/profile/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function profile_update()
	{
		$this->load->library('form_validation');
		if($this->core->input->post('user_name'))
		{
			$this->core->users_global->setUserElement('NAME', $this->core->input->post('user_name'));
		}
		if($this->core->input->post('user_surname'))
		{
			$this->core->users_global->setUserElement('SURNAME', $this->core->input->post('user_surname'));
		}
		if($this->core->input->post('user_state'))
		{
			$this->core->users_global->setUserElement('STATE', $this->core->input->post('user_state'));
		}
		if($this->core->input->post('user_town'))
		{
			$this->core->users_global->setUserElement('TOWN', $this->core->input->post('user_town'));
		}
		$this->hubby->setTitle('Mettre mon profil &agrave; jour');
		$this->hubby->setDescription('Mettre mon profil &agrave; jour');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
		$this->data['body']			=	$this->load->view('account/update_prof/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function messaging($index	=	'home',$start= 1,$end = 1,$x	=	0)
	{
		if($index 	== 'home')
		{
			$this->load->library('form_validation');
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
			$this->hubby->setTitle('Messagerie');
			$this->hubby->setDescription('Hubby Users Account');
			$this->data['ttMessage']	=	$this->core->users_global->countMessage();
			$this->data['paginate']		=	$this->core->hubby->paginate(30,$this->data['ttMessage'],1,'ClasseOn','ClasseOff',$start,$this->core->url->site_url(array('account','messaging','home')).'/',null);
			$this->data['getMessage']	=	$this->core->users_global->getMessage($this->data['paginate'][1],$this->data['paginate'][2]);$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/body',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
		else if($index	== 'write')
		{
			$this->load->library('form_validation');
			$this->core->form_validation->set_rules('receiver','Pseudo du correspondant','trim|required|min_length[6]|max_length[15]');
			$this->core->form_validation->set_rules('content','Contenu du message','trim|required|min_length[6]|max_length[1200]');
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
			
			$this->hubby->setTitle('Messagerie');
			$this->hubby->setDescription('Hubby Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/write',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		
		}
		else if($index	==	'open')
		{
			$this->load->library('form_validation');
			$this->core->form_validation->set_rules('reply','Contenu du message','trim|required|min_length[6]|max_length[1200]');
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
			$this->data['paginate']		=	$this->hubby->paginate(30,$this->data['ttMsgContent'],1,'bg-color-red fg-color-white','bg-color-blue',$end,$this->core->url->site_url(array('account','messaging','open',$start)).'/',$ajaxis_link=null);
			if($this->data['paginate'][3]	==	false)
			{
				$this->core->url->redirect(array('page404'));
			}
			$this->data['getMsgContent']=	$this->core->users_global->getMsgContent($start,$this->data['paginate'][1],$this->data['paginate'][2]);
			
			$this->hubby->setTitle('Messagerie &raquo; Lecture');
			$this->hubby->setDescription('Hubby Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/read',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
	}
}