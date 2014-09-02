<?php 
/**
*	UPDATED FOR TENDOO 0.99
**/
class Account extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->instance			=	get_instance();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->load->library('users_global');
		$this->load->library('file');
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->file_2			=	new File;
		// out put files
		css_push_if_not_exists('font');
		css_push_if_not_exists('app.v2');
		css_push_if_not_exists('tendoo_global');
		////->
		js_push_if_not_exists('jquery-1.9');
		js_push_if_not_exists('underscore.1.6.0');
		js_push_if_not_exists('app.min.vtendoo'); 
		js_push_if_not_exists('tendoo_loader');
		js_push_if_not_exists('tendoo_app');
		
		set_core_vars( 'options' , $this->data['options'] = get_meta( 'all' ) );
		
		if(!$this->users_global->isConnected())
		{
			$this->url->redirect(array('login?ref='.urlencode($this->url->request_uri())));
			exit;
		}
		$this->data['left_menu']			=	$this->load->view('account/left_menu',$this->data,true);
		$this->data['smallHeader']			=	$this->load->view('account/smallHeader',$this->data,true);

	}
	public function index()
	{
		$user_pseudo 						=	$this->users_global->current('PSEUDO');
		set_page('title', riake( 'site_name' , $this->data['options'] ) . ' | '.ucfirst($user_pseudo).' &raquo; Mon profil');
		set_page('description','Mon profil');
		$this->data['body']			=	$this->load->view('account/profile/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('avatar_usage','','trim|required');
		if($this->form_validation->run())
		{
			$status	=	$this->users_global->setAvatarSetting(
				$this->input->post(	'facebook_profile' ),
				$this->input->post(	'google_profile' ),
				$this->input->post( 'twitter_profile' ),
				$this->input->post( 'avatar_usage' ),
				'avatar_file'
			);
			if($status['error'] > 0)
			{
				$text	=	'Mise à jour des champs, une erreur lors de l\'envoi du fichier, vérifier la taille de votre fichier et essayer à nouveau.';
			}
			else
			{
				$text	=	'Mise à jour des champs et de l\'avatar.';
			}
			$this->url->redirect(array('account','update?info='.$text));
			exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
		if($this->input->post('user_name'))
		{
			$this->users_global->setUserElement('NAME', $this->input->post('user_name'));
			$this->url->redirect(array('account','update?notice=userNameUpdated'));
		}
		if($this->input->post('user_surname'))
		{
			$this->users_global->setUserElement('SURNAME', $this->input->post('user_surname'));
			$this->url->redirect(array('account','update?notice=userSurnameUpdated'));
		}
		if($this->input->post('user_state'))
		{
			$this->users_global->setUserElement('STATE', $this->input->post('user_state'));
			$this->url->redirect(array('account','update?notice=userStateUpdated'));
		}
		if($this->input->post('user_town'))
		{
			$this->users_global->setUserElement('TOWN', $this->input->post('user_town'));
			$this->url->redirect(array('account','update?notice=userTownUpdated'));
		}
		if($this->input->post('user_bio'))
		{
			$this->users_global->setUserElement('BIO', $this->input->post('user_bio'));
			$this->url->redirect(array('account','update?notice=userBioUpdated'));
		}
		$user_pseudo 						=	$this->users_global->current('PSEUDO');
		set_page('title', riake( 'site_name' , $this->data['options'] ) .' | '.ucfirst($user_pseudo).' &raquo; Mise &agrave; jour du profil');
		set_page('description','Mettre mon profil &agrave; jour');
		
		$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
		$this->data['body']			=	$this->load->view('account/update_prof/body',$this->data,true);
		
		$this->load->view('account/header',$this->data);
		$this->load->view('account/global_body',$this->data);
	}
	public function messaging($index	=	'home',$start= 1,$end = 1,$x	=	0)
	{
		$this->instance->date->timestamp();
		if($index 	== 'home')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('conv_id','Identifiant du message','required');
			if($this->form_validation->run())
			{
				if(is_array($_POST['conv_id']))
				{
					foreach($_POST['conv_id'] as $c)
					{
						$result	=	$this->users_global->deleteConversation($c);
						if($result	== false)
						{
							notice('push','Une erreur est survenu durant la suppression du message, il ne vous est surement pas destinée ou ce message n\'existe pas');
						}
						else
						{
							notice('push',fetch_error('done'));
						}
					}
				}
				else
				{
					$result	=	$this->users_global->deleteConversation($_POST['conv_id']);
					if($result	== false)
					{
						notice('push','Une erreur est survenu durant la suppression du message, il ne vous est surement pas destinée ou ce message n\'existe pas');
					}
					else
					{
						notice('push',fetch_error('done'));
					}
				}
			}
			$user_pseudo 						=	$this->users_global->current('PSEUDO');
			set_page('title', riake( 'site_name' , $this->data['options'] ) .' | '.ucfirst($user_pseudo).' &raquo; Messagerie');
			set_page('description','Messagerie de '.$user_pseudo);
			$this->data['ttMessage']	=	$this->users_global->countMessage();
			$this->data['paginate']		=	$this->tendoo->paginate(30,$this->data['ttMessage'],1,'ClasseOn','ClasseOff',$start,$this->url->site_url(array('account','messaging','home')).'/',null);
			$this->data['getMessage']	=	$this->users_global->getMessage($this->data['paginate'][1],$this->data['paginate'][2]);$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/body',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
		else if($index	== 'write')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('receiver','Pseudo du correspondant','trim|required|min_length[5]|max_length[15]');
			$this->form_validation->set_rules('content','Contenu du message','trim|required|min_length[3]|max_length[1200]');
			if($this->form_validation->run())
			{
				$result	=	$this->users_global->write(
					$this->input->post('receiver'),
					$this->input->post('content')
				);
				if($result	==	'posted')
				{
					$this->url->redirect(array('account','messaging','home'));
				}
				else
				{
					notice('push',fetch_error('error_occured'));
				}
			}
			
			$user_pseudo 						=	$this->users_global->current('PSEUDO');
			set_page('title', riake( 'site_name' , $this->data['options'] ) .' | '.ucfirst($user_pseudo).' &raquo; Ecrire un nouveau message');
			set_page('description','Tendoo Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/write',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		
		}
		else if($index	==	'open')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
			$this->form_validation->set_rules('reply','Contenu du message','trim|required|min_length[3]|max_length[1200]');
			$this->form_validation->set_rules('convid','Identifiant de la convesation','trim|required|min_length[1]');
			if($this->form_validation->run())
			{
				$result	=	$this->users_global->addPost($this->input->post('convid'),$this->input->post('reply'));
				if($result	==	true)
				{
					notice('push',fetch_error('done'));
				}
				else
				{
					notice('push','Le message n\'a pas pu &ecirc;tre post&eacute; parceque vous n\'avez pas directement acc&egrave;s, soit parceque cette discution n\'existe pas ou plus.');
				}
			}
			$this->users_global->editStatus($start);
			$this->data['ttMsgContent']	=	$this->users_global->countMsgContent($start);
			$this->data['paginate']		=	$this->tendoo->paginate(30,$this->data['ttMsgContent'],1,'bg-color-red fg-color-white','bg-color-blue',$end,$this->url->site_url(array('account','messaging','open',$start)).'/',$ajaxis_link=null);
			if($this->data['paginate'][3]	==	false)
			{
				$this->url->redirect(array('page404'));
			}
			$this->data['getMsgContent']=	$this->users_global->getMsgContent($start,$this->data['paginate'][1],$this->data['paginate'][2]);
			
			$user_pseudo 						=	$this->users_global->current('PSEUDO');
			set_page('title', riake( 'site_name' , $this->data['options'] ) .' | '.ucfirst($user_pseudo).' &raquo; Lecture d\'un message');

			set_page('description','Tendoo Users Account');$this->data['lmenu']		=	$this->load->view('account/left_menu',$this->data,true);
			$this->data['body']			=	$this->load->view('account/messaging/read',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/global_body',$this->data);
		}
	}
	public function profile($userPseudo)
	{
		if($this->users_global->current('PSEUDO') == $userPseudo)
		{
			$this->url->redirect(array('account'));
		}
		$user	=	$this->users_global->getUserByPseudo($userPseudo);
		if($user)
		{
			$this->data['user'] =& $user;
			
			set_page('title', riake( 'site_name' , $this->data['options'] ) .' | '.ucfirst($user[0]['PSEUDO']).' &raquo; profil de l\'utilisateur');
			set_page('description',$user[0]['PSEUDO'].' - Profil');
			
			$this->data['body']			=	$this->load->view('account/profile/user_profil_body',$this->data,true);
			
			$this->load->view('account/header',$this->data);
			$this->load->view('account/user_profile_global_body',$this->data);
		}
		else
		{
			$this->url->redirect(array('error','code','unknowProfil'));
		}
	}
	public function ajax($action)
	{
		$this->load->library('form_validation');
		$result	= array(
			'status'	=>	'warning',
			'message'	=>	'Une erreur s\'est produite durant l\'opération.',
			'alertType'	=>	'modal',
			'response'	=>	array()
		);
		if($action == 'setTheme')
		{
			$this->form_validation->set_rules('theme_style','Le champ du thème','required|min_length[1]|max_length[2]');
			if($this->form_validation->run())
			{
				if($this->users_global->editThemeStyle($this->input->post('theme_style')))
				{
					$result	=	 array(
						'status'	=>	'success',
						'message'	=>	'La modification du thème à réussi.',
						'alertType'	=>	'notice',
						'response'	=>	array(),
						'exec'		=>	'function(){
							document.location = "'.$this->url->site_url(array('account','update')).'";
						}'
					);
				}
			}
		}
		else if($action == 'setPassword')
		{
			$this->form_validation->set_rules('user_oldpass','','required|min_length[6]');
			$this->form_validation->set_rules('user_newpass','','required|min_length[6]|matches[user_confirmnewpass]');
			$this->form_validation->set_rules('user_confirmnewpass','','required');
			if($this->form_validation->run())
			{
				$result	=	 array(
					'status'	=>	'warning',
					'message'	=>	'Une erreur s\'est produite, verifiez que l\'ancien mot de passe n\'est pas exact.',
					'alertType'	=>	'modal',
					'response'	=>	array()
				);
				if($this->input->post('user_oldpass') == $this->input->post('user_newpass'))
				{
					$result	=	 array(
						'status'	=>	'warning',
						'message'	=>	'L\'ancien et le nouveau mot de passe ne doivent pas être identique.',
						'alertType'	=>	'modal',
						'response'	=>	array()
					);
				}
				else
				{
					if($this->users_global->updatePassword($this->input->post('user_oldpass'),$this->input->post('user_newpass')))
					{
						$result	=	 array(
							'status'	=>	'success',
							'message'	=>	'La modification du mot de passe à réussi.',
							'alertType'	=>	'notice',
							'response'	=>	array()
						);
					}
				}
			}
			else
			{
				$result	=	 array(
					'status'	=>	'warning',
					'message'	=>	'Une erreur s\'est produite, votre mot de passe doit avoir au moins 6 lettres, et le "nouveau mot de passe" doit être identique à celui du champ "Retaper le mot de passe".',
					'alertType'	=>	'modal',
					'response'	=>	array()
				);
			}
		}
		elseif($action	==	"set_user_meta")
		{
			if($_POST[ 'key' ] && $_POST[ 'value' ])
			{
				if(json_encode(set_user_meta($_POST[ 'key' ], $_POST[ 'value' ])))
				{
					$result	= array(
						'status'	=>	'success',
						'message'	=>	'Les éléments ont correctement été mis à jour.',
						'alertType'	=>	'notice',
						'response'	=>	array()
					);
				}
			}
		}
		elseif($action	==	"get_user_meta")
		{
			if($this->input->post( 'key' ))
			{
				$result	= json_encode(get_user_meta($this->input->post( 'key' )));
			}
			$result		= '{}';
		}
		echo json_encode($result);
	}
}