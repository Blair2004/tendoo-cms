<?php
Class users_global extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->db			=	get_db();
		$this->instance		=	get_instance();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->createUserAvatarDir();
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->superAdmin	=	0;
		// -=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=-=-=-=-=-=--=
		$this->connection_status	=	FALSE;
		if($this->cookiesLogin() == FALSE) // in case there is no cookies created else autUser will be called with encrypt process disabled.
		{
			// log user if not yet connected
			if($this->session->started())
			{
				$this->authUser(
					$this->session->userdata( 'PSEUDO' ),
					$this->session->userdata( 'PASSWORD' ),
					FALSE,
					FALSE
				);
				
			}
		}
		$this->menuStatus	=	'show_menu';
	}
	public function createUserAvatarDir()
	{
		if(!is_dir(ASSETS_DIR.'/img/avatars'))
		{
			mkdir(ASSETS_DIR.'/img/avatars');
		}
	}
	/**
	*	setAvatarSetting : définit les options d'avatar et des profils vers les réseau sociaux.
	**/
	public function setAvatarSetting($facebook_profile,$google_plus_profile,$twitter_profile,$avatar_usage = 'system',$avatar_file = null)
	{
		$notice['error']	=	0;
		$notice['success']	=	0;
		if(isset($_FILES[ $avatar_file ]))
		{
			$config['upload_path'] 		= ASSETS_DIR.'img/avatars';
			$config['allowed_types']	= 'gif|jpg|png';
			$config['max_size']			= '100';
			$config['max_width']  		= '300';
			$config['max_height']  		= '300';
			$config['file_name']		= 'avatar_'.$this->current('PSEUDO');
			$config['overwrite']		=	TRUE;
			$this->load->library('upload', $config);
			
			if( isset( $_FILES[ $avatar_file ] ) )
			{
				if( riake( 'size' , $_FILES[ $avatar_file ] ) > 0 ) // Only when a file is send you can consider treating it.
				{
					if($this->upload->do_upload($avatar_file))
					{
						$upload_data				=	$this->upload->data();
						$this->setUserElement('AVATAR_LINK',$this->url->main_url().$config[ 'upload_path' ] .'/'. $upload_data[ 'file_name' ]);
						$notice['success']++;
					}
					else
					{
						$notice['error']++;
					}
				}
			}
		}
		if(in_array($avatar_usage,array('facebook','twitter','google','system')))
		{
			$this->setUserElement('AVATAR_TYPE',$avatar_usage);
		}
		$this->setUserElement('FACEBOOK_PROFILE',$facebook_profile);
		$this->setUserElement('GOOGLE_PROFILE',$google_plus_profile);
		$this->setUserElement('TWITTER_PROFILE',$twitter_profile);
		
		return $notice;
	}
	public function cookiesLogin()
	{
		$UPDO	=	get_cookie('UPDO');
		$UPSW	=	get_cookie('UPSW');
		if($UPDO && $UPSW)
		{
			$this->authUser(
				$UPDO,
				$UPSW,
				TRUE,
				FALSE // Encrypt Password False cause, it's already encrypted
			);
			return true;
		}
		return false;
	}
	public function destroyLoginCookies()
	{
		delete_cookie('UPDO');
		delete_cookie('UPSW');
	}
	public function keepConnected($pseudo,$password)
	{
		$cookie_pseudo	=	array(
		    'name'   => 'UPDO',
		    'value'  => $pseudo,
		    'expire' => '86500',
		    'domain' => '',
		    'path'   => '/',
		    'prefix' => '',
		    'secure' => FALSE
		);
		$this->input->set_cookie($cookie_pseudo);
		$cookie_password	=	array(
		    'name'   => 'UPSW',
		    'value'  => $password,
		    'expire' => '86500',
		    'domain' => '',
		    'path'   => '/',
		    'prefix' => '',
		    'secure' => FALSE
		);
		$this->input->set_cookie($cookie_password);
	}
	public function systemPrivilege()
	{
		return array($this->superAdmin);
	}
	public function hasAdmin()
	{
		$query	=	$this->db->where('REF_ROLE_ID','SUPERADMIN')->get('tendoo_users');
		$array	=	$query->result_array();
		if(count($array) > 0)
		{
			return true;
		}
		return false;
	}
	public function userExists($pseudo)
	{
		$query	=	$this->db->where('PSEUDO',strtolower($pseudo))->get('tendoo_users');
		$array	=	$query->result_array();
		if(count($array) > 0)
		{
			return true;
		}
		return false;
	}
	public function getUserByPseudo($pseudo)
	{
		$query	=	$this->db->where('PSEUDO',strtolower($pseudo))->get('tendoo_users');
		$array	=	$query->result_array();
		if(count($array) > 0)
		{
			return $array;
		}
		return false;
	}
	public function createSuperAdmin($pseudo,$password,$sexe,$email)
	{
		if(!$this->userExists($pseudo))
		{
			$array['PSEUDO']	=	strtolower($pseudo);
			$array['PASSWORD']	=	sha1($password);
			$array['SEX']		=	($sexe	==	'MASC') ? 'MASC' : 'FEM';
			$array['EMAIL']		=	$email;
			$array['REF_ROLE_ID']	=	'SUPERADMIN';
			$array['REG_DATE']	=	$this->instance->date->datetime();
			$array['ACTIVE']	=	'TRUE';
			get_instance()->meta_datas->set_user_meta( 'first_visit' , true , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'dashboard_theme' , 1 , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_0' , '{"0":"generals_stats\/system","1":"articles_stats\/blogster"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_1' , '{"0":"welcome\/system","1":"app_icons\/system"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_2' , '{"0":"recents_commentaires\/blogster"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'new_comer' , true , $array[ 'PSEUDO' ] );
			$this->db->insert('tendoo_users',$array);
			return 'userCreated';
		}
		return 'userExists';
	}
	public function createUser($pseudo,$password,$sexe,$email,$active	=	'FALSE',$priv_id = 'USER')
	{
		if(!$this->userExists($pseudo))
		{
			if($this->emailExist($email))
			{
				return 'emailUsed';
			}
			$this->load->library('Tendoo_admin');
			if(!$this->tendoo_admin->is_public_role($priv_id)) // Si le priv n'est pa public
			{
				$priv_id = 'USER';
			}
			$array['PSEUDO']	=	strtolower($pseudo);
			$array['PASSWORD']	=	sha1($password);
			$array['SEX']		=	($sexe	==	'MASC') ? 'MASC' : 'FEM';
			$array['EMAIL']		=	$email;
			$array['REF_ROLE_ID']	=	$priv_id;
			$array['REG_DATE']	=	$this->instance->date->datetime();
			$array['ACTIVE']	=	$active;
			get_instance()->meta_datas->set_user_meta( 'first_visit' , true , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'dashboard_theme' , 1 , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_0' , '{"0":"generals_stats\/system","1":"articles_stats\/blogster"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_1' , '{"0":"welcome\/system","1":"app_icons\/system"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_2' , '{"0":"recents_commentaires\/blogster"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'new_comer' , true , $array[ 'PSEUDO' ] );
			$this->db->insert('tendoo_users',$array);
			$this->sendValidationMail($array['EMAIL']);
			return 'userCreated';
		}
		return 'userExists';	
	}
	public function createAdmin($pseudo,$password,$sexe,$privilege= 2,$email,$active	=	'TRUE')
	{
		if(!$this->userExists($pseudo))
		{
			if($this->emailExist($email))
			{
				return 'emailUsed';
			}
			if(!$this->isAllowedPrivilege($privilege) && $privilege	!=	'USER')
			{
				return 'notAllowedPrivilege';
			}
			$array['PSEUDO']	=	strtolower($pseudo);
			$array['PASSWORD']	=	sha1($password);
			$array['EMAIL']		=	$email;
			$array['SEX']		=	($sexe	==	'MASC') ? 'MASC' : 'FEM';
			$array['REF_ROLE_ID']	=	($privilege == 'SUPERADMIN') ? 'USER' : $privilege;
			$array['REG_DATE']	=	$this->instance->date->datetime();
			$array['ACTIVE']	=	$active;
			
			get_instance()->meta_datas->set_user_meta( 'first_visit' , true , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'dashboard_theme' , 1 , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_0' , '{"0":"generals_stats\/system","1":"articles_stats\/blogster"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_1' , '{"0":"welcome\/system","1":"app_icons\/system"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'widget_2' , '{"0":"recents_commentaires\/blogster"}' , $array[ 'PSEUDO' ] );
			get_instance()->meta_datas->set_user_meta( 'new_comer' , true , $array[ 'PSEUDO' ] );
			
			$this->db->insert('tendoo_users',$array);
			return 'adminCreated';
		}
		return 'adminCreationFailed';	
	}
	public function emailExist($email)
	{
		$query	=	$this->db->where('EMAIL',$email)->get('tendoo_users');
		$array	=	$query->result_array();
		if(count($array) > 0)
		{
			return $array[0];
		}
		return false;
	}
	public function emailConnect($email,$password)
	{
		$query	=	$this->db->where('EMAIL',strtolower($email))->where('PASSWORD',$password)->get('tendoo_users');
		$data	=	$query->result_array();
		if($data)
		{
			return $data[0];
		}
		return false;
	}
	public function activateUser($id)
	{
		return $this->db->where('ID',$id)->update('tendoo_users',array('ACTIVE'=>'TRUE'));
	}
	public function authUser($pseudo,$password,$stay = FALSE,$encrypt_password = TRUE)
	{
		if($encrypt_password == TRUE)
		{
			$query	=	$this->db
							->join( 'tendoo_meta' , 'tendoo_meta.USER = tendoo_users.PSEUDO' )
							->where('PSEUDO',strtolower($pseudo))
							->where('PASSWORD',sha1($password))->get('tendoo_users');
		}
		else
		{
			$query	=	$this->db->where('PSEUDO',strtolower($pseudo))->where('PASSWORD',$password)->get('tendoo_users'); // If password is already encrypted
		}
		$data	=	$query->result_array();
		if(count($data) > 0)
		{
			if($data[0]['ACTIVE']	==	'FALSE')
			{
				return 'UnactiveUser';
			}
			else if($data[0]['ACTIVE']	==	'TRUE')
			{
				$this->current['ID']			=	$data[0]['ID'];
				$this->current['PSEUDO']		=	$data[0]['PSEUDO'];
				$this->current['PASSWORD']		=	$data[0]['PASSWORD'];
				$this->current['SEX']			=	($data[0]['SEX'] == 'MASC') ? 'Masculin' : 'Feminin';
				$this->current['EMAIL']			=	$data[0]['EMAIL'];
				$this->current['REF_ROLE_ID']		=	$data[0]['REF_ROLE_ID'];
				$this->current['LAST_ACTIVITY']	=	$data[0]['LAST_ACTIVITY'];
				if($stay == TRUE)
				{
					if($encrypt_password == TRUE)
					{
						$this->keepConnected(strtolower($pseudo),sha1($password));
					}
					else
					{
						$this->keepConnected(strtolower($pseudo),$password);	
					}
				}
				$this->session->set_userdata(array('PSEUDO'		=>$data[0]['PSEUDO']));
				if( $encrypt_password == true ){
					$this->session->set_userdata(array('PASSWORD'	=> sha1( $password ) ) );
				} else {
					$this->session->set_userdata(array('PASSWORD'	=>$password));
				}

				$this->connection_status	=	TRUE;
				return 'userLoggedIn';
			}
		}
		return 'PseudoOrPasswordWrong';
	}
	public function refreshUser() // rafraichir les données de l'utilisateur connecté.
	{ 
		$this->authUser($this->current('PSEUDO'),$this->session->userdata( 'PASSWORD' ),FALSE,FALSE);
	}
	public function sendValidationMail($email)
	{
		$option	=	$this->instance->meta_datas->get();
		$user	=	$this->emailExist($email);
		if($user)
		{
			if($user['REF_ROLE_ID']	==	'SUPERADMIN')
			{
				return 'actionProhibited';
			}
			if($user['ACTIVE']		== 'TRUE')
			{
				return 'alreadyActive';
			}
			$mail	=	 '
<h4>Votre compte à été correctement crée.</h4>

Activez votre compte en cliquant sur le lien suivant :
<a href="'.$this->url->site_url(array('login','activate',$user['EMAIL'],$this->instance->date->timestamp() + 172800,$user['PASSWORD'])).'">Activer votre compte '.$user['PSEUDO'].'</a>.<br>

Ce mail à été envoyé à l\'occassion d\'une inscription sur le site <a href="'.$this->url->main_url().'">'.$this->url->main_url().'</a>.
			';
			
			$this->load->library('email');
			$this->email	=&	$this->email;
			$config = array (
				'mailtype' => 'html',
				'charset'  => 'utf-8',
				'priority' => '1'
			);
			$this->email->initialize($config);
			$this->email->from('noreply@'.$_SERVER['HTTP_HOST'], $option[0]['SITE_NAME']);
			$this->email->to($user['EMAIL']); 
			
			$this->email->subject($option[0]['SITE_NAME'].' - Activer votre compte');
			$this->email->message($mail);	
			
			$this->email->send();
			return 'validationSended';
		}
		return 'unknowEmail';
	}
	public function sendPassChanger($email)
	{
		$option	=	get_meta();
		$user	=	$this->emailExist($email);
		if($user)
		{
			if($user['REF_ROLE_ID']	==	'SUPERADMIN')
			{
				return 'actionProhibited';
			}
			$mail	=	 '
<h4> ' . __( 'Password Recovery Wizard' ) . '</h4>

' . __( 'Change your password through this link' ) . ' :
<a href="'.$this->url->site_url(array('login','passchange',$user['EMAIL'],$this->instance->date->timestamp() + 10800,$user['PASSWORD'])).'"> '. __( 'Change your password' ) .'</a>.<br>

' . __( 'This mail has been sended because of an attempt of password recovery. If you think it\'s a mistake, don\'t follow this link, since this last will expire within 3 hours.' ) ;
			$this->load->library('email');
			$config = array (
				'mailtype' => 'html',
				'charset'  => 'utf-8',
				'priority' => '1'
			);
			$this->email->initialize($config);
			$this->email->from('noreply@' . $_SERVER['HTTP_HOST'], $option['site_name']);
			$this->email->to($user['EMAIL']); 
			
			$this->email->subject($option['site_name'].' - ' . __( 'Change your password' ) );
			$this->email->message($mail);	
			
			$this->email->send();
			return 'NewLinkSended';
		}
		return 'unknowEmail';
	}
	public function isConnected()
	{
		return $this->connection_status;
	}
	public function current($element = NULL)
	{
		if(!array_key_exists($element,$this->current))
		{
			// Special avatar_link working case
			if( strtolower( $element ) == 'avatar_link' ){
				if( $avatar	=	get_user_meta( $element ) ){
					return $avatar;
				} 
				return img_url( 'avatar_default.jpg' );
			} else {
				return get_user_meta( $element );
			}
		}
		if($element == NULL)
		{
			return $this->current;
		}
		else
		{
			return $this->current[$element];
		}
	}
	public function closeUserSession()
	{
		$this->destroyLoginCookies();
		$this->session->close();
	}
	public function allowedAdminPrivilege()
	{
		$query	=	$this->db->select('ID')->from('tendoo_roles')->get();
		$result	=	$query->result_array();
		if(count($result)> 0)
		{
			$privilege	=	array();
			foreach($result as $r)
			{
				$privilege[]	=	$r['ID'];
			}
			return $privilege;
		}
		return array();
		
	}
	public function isAllowedPrivilege($priv)
	{
		if(in_array($priv,$this->allowedAdminPrivilege()))
		{
			return true;
		}
		return false;
	}
	public function isAdmin()
	{
		if(in_array($this->current('REF_ROLE_ID') , $this->allowedAdminPrivilege()) || $this->current('REF_ROLE_ID') == $this->superAdmin)
		{
			return true;
		}
		return false;
	}
	public function isSuperAdmin()
	{
		if($this->current('REF_ROLE_ID') == 0 )
		{
			return true;
		}
		return false;
	}
	public function getAdmin($start	=	NULL,$end	=	NULL)
	{
		$this->db->where('REF_ROLE_ID !=',$this->superAdmin);
		if(is_numeric($start) && is_numeric($end))
		{
			$this->db->limit($end,$start);
		}
		$query	=	$this->db->get('tendoo_users');
		return $query->result_array();
	}
	public function setViewed($page)
	{
		$this->db->where('ID',$this->current('ID'))->update('tendoo_users',array($page =>	1));
	}
	public function getSpeAdmin($id)
	{
		$this->db->where('ID',$id);
		$query	=	$this->db->get('tendoo_users');
		$array	=	$query->result_array();
		if(count($array) > 0)
		{
			return $array[0];
		}
		return false;
	}
	public function getSpeAdminByPseudo($pseudo)
	{
		if($this->userExists($pseudo))
		{
			$this->db->where('PSEUDO',strtolower($pseudo));
			$query	=	$this->db->get('tendoo_users');
			$array	=	$query->result_array();
			return $array[0];
		}
		return false;
	}
	public function getUser($id)
	{
		$this->db->where('ID',$id);
		$query	=	$this->db->get('tendoo_users');
		$array	=	$query->result_array();
		if(count($array) > 0)
		{
			return $array[0];
		}
		return false;
	}
	public function setMenuStatus($status)
	{
		if(in_array($status,array('show_menu','hide_menu')))
		{
			$this->menuStatus	=	$status;
			return true;
		}
		return false;
	}
	public function getUserMenu()
	{
		if($this->isConnected() && $this->menuStatus == 'show_menu')
		{
			$this->load->library('tendoo_admin');
		?>
        	<div id="tendoo_userbar">
            	<span class="logo">
                    <img src="<?php echo $this->url->img_url('tendoo_darken.png');?>" />
                </span>
                <ul>
                <?php
				if($this->isAdmin() || $this->isSuperAdmin())
				{
				?>
                	<li><a href="<?php echo $this->url->site_url(array('admin','index'));?>">Espace administration</a></li>
				<?php
				}
				?>
                <li><a href="<?php echo $this->url->site_url(array('account'));?>">Mon profil</a></li>
                <li><a href="<?php echo $this->url->site_url(array('account','messaging','home'));?>">Messagerie 
                <?php
                $unread	=	$this->getUnreadMsg();
                if($unread > 0)
                {
                ?><span class="counter"><?php echo $unread;?></span>
                <?php
                }
                ?>
                </a>
                </li>
                <?php
				if(is_array(get('declared_shortcuts')) && count(get('declared_shortcuts')) > 0)
				{
				?>
                <li><a href="javascript:void(0);"> + Raccourcis</a>
                    <ul>
                    <?php
					foreach(get('declared_shortcuts') as $s)
					{
						?>
						<li>
							<a href="<?php echo $s['link'];?>"><?php echo $s['text'];?></a>
						</li>
						<?php
					}
					?>
                    </ul>
                </li>
                <?php
					if($this->isAdmin() || $this->isSuperAdmin())
					{
					?>
					<li><a href="javascript:void(0);"> + Tâches </a>
						<ul>
                        	<?php
							if($this->tendoo_admin->adminAccess('system','gestpa',$this->current('REF_ROLE_ID')) || $this->isSuperAdmin())
							{
								?>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','controllers'));?>">Contrôleurs</a>
                                </li>
                                <?php
							}
							?>
                            <?php
							if($this->tendoo_admin->adminAccess('system','gestmo',$this->current('REF_ROLE_ID')) || $this->isSuperAdmin())
							{
								?>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','modules'));?>">Modules</a>
                                </li>
                                <?php
							}
							?>
                            <?php
							if($this->tendoo_admin->adminAccess('system','gestheme',$this->current('REF_ROLE_ID')) || $this->isSuperAdmin())
							{
								?>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','themes'));?>">Thèmes</a>
                                </li>
                                <?php
							}
							?>
                            <?php
							if($this->tendoo_admin->adminAccess('system','gestapp',$this->current('REF_ROLE_ID')) || $this->isSuperAdmin())
							{
								?>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','installer'));?>">Ajouter une App</a>
                                </li>
                                <?php
							}
							?>
                            <?php
							if($this->isSuperAdmin())
							{
								?>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','system','createAdmin'));?>">Créer un utilisateur</a>
                                </li>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','system','users'));?>">Liste des utilisateurs</a>
                                </li>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','system','create_role'));?>">Créer un privilège</a>
                                </li>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','system','privilege_list'));?>">Liste des privilèges</a>
                                </li>
                                <li>
                                <a href="<?php echo $this->url->site_url(array('admin','system','manage_actions'));?>">Gérer les actions</a>
                                </li>
                                <?php
							}
							?>
						</ul>
					</li>
					<?php
					}
				}
				?>
            </ul>
            <ul style="float:right">
            	<li>
                	<a href="<?php echo $this->url->site_url(array('logoff'));?>" style="text-decoration:none;color:#F90;">Deconnexion</a>
                </li>
            </ul>
        </div>
        <?php
		}
	}
	public function deleteSpeAdmin($pseudo)
	{
		if($this->isSuperAdmin())
		{
			return $this->db->where('PSEUDO',strtolower($pseudo))->delete('tendoo_users');
		}
		return false;
	}
	public function setAdminPrivilege($priv,$pseudo,$email)
	{
		if($this->isSuperAdmin())
		{
			$current	=	$this->getSpeAdminByPseudo($pseudo);
			if($this->emailExist($email) && $email	!=	$current['EMAIL'])
			{
				return "emailUsed";
			}
			if($this->isAllowedPrivilege($priv) || $priv 	==	'USER')
			{
				if($this->db->where('PSEUDO',strtolower($pseudo))->update('tendoo_users',
					array('EMAIL'	=>	$email,'REF_ROLE_ID'=>$priv)
				))
				{
					return 'done';
				}
			}
			return 'unallowedPrivilege';
		}
		return 'notAllowed';
	}
	public function setUserElement($element, $value)
	{
		return set_user_meta( $element , $value );
	}
	/**
	*	Implémentation de la fonction tendoo.switchButton()
	**/
	public function setAdminWidgets($data)
	{
		if(is_array($data))
		{
			$data['widget_action']	=	array_key_exists('widget_action',$data) ? $data['widget_action'] : array();
			$final_values	=	array_diff($data['widget_namespace'],$data['widget_action']);
			// Retreive all widgets
			$widget[0]		=	get_user_meta( 'widget_0' );			
			$widget[1]		=	get_user_meta( 'widget_1' );
			$widget[2]		=	get_user_meta( 'widget_2' );
			// Fill null values
			$widget[0]		=	is_array($widget[0]) ? $widget[0] : array();
			$widget[1]		=	is_array($widget[1]) ? $widget[1] : array();
			$widget[2]		=	is_array($widget[2]) ? $widget[2] : array();
			// Adding activated to admin dashboard if doesn't exist
			foreach($data['widget_action'] as $w)
			{
				if(is_array($widget[0]))
				{
					// Si le widget n'existe dans aucun section des widgets (3)
					if(!in_array($w,$widget[1]) && !in_array($w,$widget[0]) && !in_array($w,$widget[2]))
					{
						$widget[0][]	=	$w;
					}
				}
			}
			set_user_meta( 'widget_0' , $widget[0] );
			// Removed unactivated to admin dashboard position ifset 	
			for($i = 0;$i < 3;$i++)
			{
				if(array_key_exists($i,$widget))
				{
					if(is_array($widget[ $i ]))
					{
						$restoring	=	array();
						foreach($widget[ $i ] as $_w)
						{
							if(!in_array($_w,$final_values,true))
							{
								$restoring[]	=	$_w;
							}
						}
						$widget[ $i ] = $restoring;
					}
					set_user_meta('widget_'.$i, $widget[ $i ] );
				}
			}
			$this->refreshUser();
			return $this->setUserElement('ADMIN_WIDGETS_DISABLED',json_encode($final_values,JSON_FORCE_OBJECT));
		}
		return false;
	}
	public function updatePassword($old,$new)
	{
		if($this->current('PASSWORD')	==	sha1($old) && sha1( $new ) != $this->current( 'PASSWORD' ) )
		{
			return $this->db->where('ID',$this->current('ID'))->update('tendoo_users',array('PASSWORD'=>sha1($new)));
		}
		return false;
	}
	public function recoverPassword($account,$old,$new)
	{
		$user							=	$this->getUser($account);
		if($user['PASSWORD']	==	$old)
		{
			if($this->db->where('ID',$user['ID'])->update('tendoo_users',array('PASSWORD'=>sha1($new))))
			{
				return 'passwordChanged';
			}
			return 'error_occurred';
		}
		return 'samePassword';
	}
	public function countMessage()
	{
		$query_string	=	'SELECT * FROM '.DB_ROOT.'tendoo_users_messaging_title WHERE AUTHOR = '.$this->db->escape($this->current('ID')).' OR RECEIVER =	'.$this->db->escape($this->current('ID')).'';
		$query	=	$this->db->query($query_string);
		return count($query->result_array());
	}
	public function getMessage($start,$end)
	{
		$query_string	=	'SELECT * FROM '.DB_ROOT.'tendoo_users_messaging_title WHERE (AUTHOR = '.$this->db->escape($this->current('ID')).') OR (RECEIVER	= '.$this->db->escape($this->current('ID')).') ORDER BY ID DESC LIMIT '.$start.', '.$end;
		$query	=	$this->db->query($query_string);
		$result	=	$query->result_array();
		return $result;
	}
	public function getMsgPreview($ref_id)
	{
		$query			=	$this->db->where('MESG_TITLE_REF',$ref_id)->limit(1,0)->order_by('ID','desc')->get('tendoo_users_messaging_content');
		return $query->result_array();
	}
	public function deleteConversation($id)
	{
		$query	=	$this->db->where('ID',$id)->where('AUTHOR',$this->current('ID'))->or_where('RECEIVER',$this->current('ID'))->get('tendoo_users_messaging_title');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			$this->db->where('ID',$id)->delete('tendoo_users_messaging_title');
			$this->db->where('MESG_TITLE_REF',$id)->delete('tendoo_users_messaging_content');
			return true;
		}
		return false;
	}
	public function write($to,$message)
	{
		$users		=	$this->getUserByPseudo(strtolower($to));
		if(!$users)
		{
			return 'receiverDontExist';
		}
		if(strtolower($to)	!=	$this->current('PSEUDO'))
		{
			$post_date				=	$this->instance->date->datetime();
			$array_1				=	array(
				'AUTHOR'			=>	$users[0]['ID'],
				'RECEIVER'			=>	$this->current('ID')
			);
			$array_2				=	array(
				'AUTHOR'			=>	$this->current('ID'),
				'RECEIVER'			=>	$users[0]['ID']
			);
			$string_query			=	'SELECT * FROM '.DB_ROOT.'tendoo_users_messaging_title WHERE (AUTHOR	=	'.$this->db->escape($this->current('ID')).' AND  RECEIVER='.$this->db->escape($users[0]['ID']).') OR (AUTHOR = '.$this->db->escape($users[0]['ID']).' AND RECEIVER = '.$this->db->escape($this->current('ID')).')';
			$query	=	$this->db->query($string_query);
			$result	=	$query->result_array();
			if(count($result) > 0)
			{
				$data					=	array(
					'MESG_TITLE_REF'	=>	$result[0]['ID'],
					'CONTENT'			=>	$message,
					'AUTHOR'			=>	$this->current('ID'),
					'DATE'				=>	$post_date
				);
				$this->db->insert('tendoo_users_messaging_content',$data);
				return 'posted';
			}
			else
			{
				$data	=	array(
					'AUTHOR'			=>	$this->current('ID'),
					'RECEIVER'			=>	$users[0]['ID'],
					'CREATION_DATE'		=>	$post_date,
					'STATE'				=>	0
				);
				$this->db->insert('tendoo_users_messaging_title',$data);
				$query				=	$this->db->where('AUTHOR',$this->current('ID'))->order_by('ID','desc')->get('tendoo_users_messaging_title');
				$last_id			=	$query->result_array();
				$data					=	array(
					'MESG_TITLE_REF'	=>	$last_id[0]['ID'],
					'CONTENT'			=>	$message,
					'AUTHOR'			=>	$this->current('ID'),
					'DATE'				=>	$post_date
				);
				$this->db->insert('tendoo_users_messaging_content',$data);
				return 'posted';
			}
		}
		return 'cantSendMsgToYou';
	}
	public function countMsgContent($ref_id)
	{
		$query	=	$this->db->where('ID',$ref_id)->where('AUTHOR',$this->current('ID'))->or_where('RECEIVER',$this->current('ID'))->get('tendoo_users_messaging_title');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			$query	=	$this->db->where('MESG_TITLE_REF',$ref_id)->order_by('ID','desc')->get('tendoo_users_messaging_content');
			return count($query->result_array());
		}
		return 0;
	}
	public function getMsgContent($ref_id,$start,$end)
	{
		$query	=	$this->db->where('ID',$ref_id)->where('AUTHOR',$this->current('ID'))->or_where('RECEIVER',$this->current('ID'))->get('tendoo_users_messaging_title');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			$query	=	$this->db->where('MESG_TITLE_REF',$ref_id)->order_by('ID','desc')->limit($end,$start)->get('tendoo_users_messaging_content');
			return array(
				'title'		=>	$result,
				'content'	=>	$query->result_array()
			);
		}
		return false;
	}
	public function addPost($ref_id,$content)
	{
		$query	=	$this->db->where('ID',$ref_id)->where('AUTHOR',$this->current('ID'))->or_where('RECEIVER',$this->current('ID'))->get('tendoo_users_messaging_title');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			$this->db->where('ID',$ref_id)->update('tendoo_users_messaging_title',array('STATE'=>0));
			return $this->db->insert('tendoo_users_messaging_content',array(
				'CONTENT'			=>	$content,
				'AUTHOR'			=>	$this->current('ID'),
				'DATE'				=>	$this->instance->date->datetime(),
				'MESG_TITLE_REF'	=>	$ref_id
				)
			);
		}
		return false;
	}
	public function getUnreadMsg()
	{
		$query_string	=	'SELECT * FROM '.DB_ROOT.'tendoo_users_messaging_title WHERE (AUTHOR = '.$this->db->escape($this->current('ID')).') OR (RECEIVER	= '.$this->db->escape($this->current('ID')).') ORDER BY ID DESC ';
		$query	=	$this->db->query($query_string);
		$result	=	$query->result_array();
		$unread	=	0;
		foreach($result as $r)
		{
			$getPrev	=	$this->getMsgPreview($r['ID']);
			if($getPrev[0]['AUTHOR']	!= $this->current('ID'))
			{
				$unread++;
			}
		}
		return $unread;
	}
	public function editThemeStyle($e)
	{
		$int	=	is_numeric((int)$e) && in_array((int)$e,array(0,1,2,3,4,5,6))  ? $e : 0; // If there is new theme just add it there
		return set_user_meta( 'dashboard_theme' , $int );
	}
	private function hasAccessToConv($ref_id)
	{
		$query	=	$this->db->where('ID',$ref_id)->where('AUTHOR',$this->current('ID'))->or_where('RECEIVER',$this->current('ID'))->get('tendoo_users_messaging_title');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			return true;
		}
		return false;
	}
	public function editStatus($ref_id)
	{
		if($this->hasAccessToConv($ref_id))
		{
			$lastMsg	=	$this->getMsgPreview($ref_id);
			if($lastMsg[0]['AUTHOR'] != $this->current('ID'))
			{
				return $this->db->where('ID',$ref_id)->update('tendoo_users_messaging_title',array('STATE'=>1));
			}
			return false;
		}
		return false;
	}
	public function convertCurrentPrivilege($priv)
	{
		switch($priv)
		{
			case 'USER' : return 'Utilisateur';break;
		}
	}
	/*
		Active / Désactive la visite gusetAdminWidgetsidé (lors de la première visite)
			retourne true/false
	*/
	public function toggleFirstVisit()
	{
		if( $this->current('new_comer') === true )
		{
			return set_user_meta( 'new_comer' , false );
		}
		else
		{
			return set_user_meta( 'new_comer' , true );
		}
	}
	/*
		Tendoo.0.9.7
			Recupère la classe du thème sélectionné dans les paramètres "admin/settings".
	*/
	public function getCurrentThemeClass()
	{
		$options	=	get_user_meta( 'dashboard_theme' );
		if((int)$options == 0) // darken
		{
			return "bg-dark";
		}
		else if((int)$options == 1) // Bubble show case
		{
			return "bg-primary";
		}
		elseif((int)$options == 2) // Green Day
		{
			return "bg-success";
		}
		elseif((int)$options == 3) // red Hord
		{
			return "bg-danger";
		}
		elseif((int)$options == 4) // Selective Orange
		{
			return "bg-warning";
		}
		elseif((int)$options == 5) // skies
		{
			return "bg-info";
		}
		elseif((int)$options == 6) // Blurry T098
		{
			return "bg-primary";
		}
	}
	/*
		Tendoo.0.9.7
			Recupère la classe du bouton de validation en fonction du thème sélectionné
	*/
	public function getCurrentThemeButtonClass()
	{
		$options	=	get_user_meta( 'dashboard_theme' );
		if((int)$options == 0) // darken
		{
			return "btn-dark";
		}
		else if((int)$options == 1) // Bubble show case
		{
			return "btn-primary";
		}
		elseif((int)$options == 2) // Green Day
		{
			return "btn-success";
		}
		elseif((int)$options == 3) // red Hord
		{
			return "btn-danger";
		}
		elseif((int)$options == 4) // Selective Orange
		{
			return "btn-warning";
		}
		elseif((int)$options == 5) // skies
		{
			return "btn-info";
		}
		elseif((int)$options == 6) // Blurry
		{
			return "btn-primary";
		}
	}
	/*
		Tendoo.0.9.8
			Recupère la classe du bouton d'infirmation en fonction du thème séléctionné.
	*/
	public function getCurrentThemeButtonFalseClass()
	{
		$options	=	get_user_meta( 'dashboard_theme' );
		if((int)$options == 0) // darken
		{
			return "btn-warning";
		}
		else if((int)$options == 1) // Bubble show case
		{
			return "btn-warning";
		}
		elseif((int)$options == 2) // Green Day
		{
			return "btn-warning";
		}
		elseif((int)$options == 3) // red Hord
		{
			return "btn-primary";
		}
		elseif((int)$options == 4) // Selective Orange
		{
			return "btn-primary";
		}
		elseif((int)$options == 5) // skies
		{
			return "btn-primary";
		}
		elseif((int)$options == 6) // Blurry
		{
			return "btn-white";
		}
	}
	/* 
		Tendoo.0.9.7
			Recupère la couleur d'arrière plan en fonction du thème séléctionné.
	*/
	public function getCurrentThemeBackgroundColor()
	{
		$options	=	get_user_meta( 'dashboard_theme' );
		if((int)$options == 0) // darken
		{
			return "#F9F9F9";
		}
		else if((int)$options == 1) // Bubble show case
		{
			return "#EEEDF7";
		}
		elseif((int)$options == 2) // Green Day
		{
			return "#F0F7EA";
		}
		elseif((int)$options == 3) // red Hord
		{
			return "#F9F3F2";
		}
		elseif((int)$options == 4) // Selective Orange
		{
			return "#FCF4E5";
		}
		elseif((int)$options == 5) // skies
		{
			return "#E6F3F7";
		}
		elseif((int)$options == 6) // Blurry
		{
			return "url(".img_url('bg.jpg').")";
		}
	}
	/**
	*	isWidgetEnabled
	**/
	public function isAdminWidgetEnabled($widget_id)
	{
		$adminWidgetsDisabled	=	current_user( 'ADMIN_WIDGETS_DISABLED' );
		$adminWidgetsDisabled	=	$adminWidgetsDisabled	==	null ? array() : $adminWidgetsDisabled;
		// var_dump( current_user('ADMIN_WIDGETS_DISABLED') );
		if(in_array($widget_id,array_values($adminWidgetsDisabled)))
		{
			return false;
		}
		return true;
	}
	public function adminWidgetHasWidget(){
		if( !get_meta('widget_0', 'from_user_meta' ) && !get_meta('widget_1', 'from_user_meta' ) && !get_meta('widget_2', 'from_user_meta' ) ){
			return false;
		}
		return true;
	}
	/**
	*	resetUserWidgetInterface : Reorganise les widgets sur le tableau de bord
	**/ 
	public function resetUserWidgetInterface()
	{
		// Suppression préalable
		set_user_meta('widget_0',array());
		set_user_meta('widget_1',array());
		set_user_meta('widget_2',array());
		// Boucle la !!!
		for($i = 0;$i < 3;$i++)
		{
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=
			if(array_key_exists('widget_'.$i,$_POST))
			{
				$values			=	array();
				if( is_array( $_POST[ 'widget_'.$i ] ) )
				{
					$values		=	array_values( $_POST[ 'widget_'.$i ] );
				}
				set_user_meta( 'widget_'.$i , $values );
			}
		}
	}
	// Tendoo 1.4
	public function can( $action )
	{
		$this->load->library( 'roles' );
		return $this->isSuperAdmin() ? true : $this->roles->can( $this->current[ 'REF_ROLE_ID' ] , $action );
	}
	public function cannot( $action )
	{
		return ! $this->can( $action );
	}
}