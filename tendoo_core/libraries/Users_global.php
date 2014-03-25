<?php
Class users_global
{
	private $core;
	private $current;
	private $user_connected;
	private $connection_status;
	private $superAdmin;
	public function __construct()
	{
		$this->superAdmin	=	'NADIMERPUS';
		$this->user			=	'RELPIMSUSE';
		$this->core		=	Controller::instance();
		$this->session	=&	$this->core->session;
		$this->db		=&	$this->core->db;
		$this->tendoo	=&	$this->core->tendoo;

		$this->connection_status	=	FALSE;
		if($this->cookiesLogin() == FALSE) // in case there is no cookies created else autUser will be called with encrypt process disabled.
		{
			// log user if not yet connected
			if($this->session->started())
			{
				$this->authUser(
					$this->session->userdata('PSEUDO'),
					$this->session->userdata('PASSWORD')
				);
			}
		}
		
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
		$this->core->input->set_cookie($cookie_pseudo);
		$cookie_password	=	array(
		    'name'   => 'UPSW',
		    'value'  => $password,
		    'expire' => '86500',
		    'domain' => '',
		    'path'   => '/',
		    'prefix' => '',
		    'secure' => FALSE
		);
		$this->core->input->set_cookie($cookie_password);
	}
	public function systemPrivilege()
	{
		return array($this->superAdmin,$this->user);
	}
	public function hasAdmin()
	{
		$query	=	$this->db->where('PRIVILEGE','NADIMERPUS')->get('tendoo_users');
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
			$array['PRIVILEGE']	=	'NADIMERPUS';
			$array['REG_DATE']	=	$this->tendoo->datetime();
			$array['ACTIVE']	=	'TRUE';
			$this->db->insert('tendoo_users',$array);
			return 'userCreated';
		}
		return 'userExists';
	}
	public function createUser($pseudo,$password,$sexe,$email,$active	=	'FALSE',$priv_id = 'RELPIMSUSE')
	{
		if(!$this->userExists($pseudo))
		{
			if($this->emailExist($email))
			{
				return 'emailUsed';
			}
			$this->core->load->library('Tendoo_admin');
			if(!$this->core->tendoo_admin->isPublicPriv($priv_id)) // Si le priv n'est pa public
			{
				$priv_id = 'RELPIMSUSE';
			}
			$array['PSEUDO']	=	strtolower($pseudo);
			$array['PASSWORD']	=	sha1($password);
			$array['SEX']		=	($sexe	==	'MASC') ? 'MASC' : 'FEM';
			$array['EMAIL']		=	$email;
			$array['PRIVILEGE']	=	$priv_id;
			$array['REG_DATE']	=	$this->tendoo->datetime();
			$array['ACTIVE']	=	$active;
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
			if(!$this->isAllowedPrivilege($privilege) && $privilege	!=	'RELPIMSUSE')
			{
				return 'notAllowedPrivilege';
			}
			$array['PSEUDO']	=	strtolower($pseudo);
			$array['PASSWORD']	=	sha1($password);
			$array['EMAIL']		=	$email;
			$array['SEX']		=	($sexe	==	'MASC') ? 'MASC' : 'FEM';
			$array['PRIVILEGE']	=	($privilege == 'NADIMERPUS') ? 'RELPIMSUSE' : $privilege;
			$array['REG_DATE']	=	$this->tendoo->datetime();
			$array['ACTIVE']	=	$active;
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
		return $this->core->db->where('ID',$id)->update('tendoo_users',array('ACTIVE'=>'TRUE'));
	}
	public function authUser($pseudo,$password,$stay = FALSE,$encrypt_password = TRUE)
	{

		if($encrypt_password == TRUE)
		{
			$query	=	$this->db->where('PSEUDO',strtolower($pseudo))->where('PASSWORD',sha1($password))->get('tendoo_users');
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
				$this->current['PRIVILEGE']		=	$data[0]['PRIVILEGE'];
				$this->current['LAST_ACTIVITY']	=	$data[0]['LAST_ACTIVITY'];
				$this->current['NAME']			=	($data[0]['NAME'] == "") ? "Non sp&eacute;cifi&eacute;" : $data[0]['NAME'];
				$this->current['SURNAME']		=	($data[0]['SURNAME'] == "") ? "Non sp&eacute;cifi&eacute;" : $data[0]['SURNAME'];
				$this->current['STATE']			=	($data[0]['STATE'] == "") ? "Non sp&eacute;cifi&eacute;" : $data[0]['STATE'];
				$this->current['TOWN']			=	($data[0]['TOWN'] == "") ? "Non sp&eacute;cifi&eacute;" : $data[0]['TOWN'];
				$this->current['PHONE']			=	($data[0]['PHONE'] == "") ? "Non sp&eacute;cifi&eacute;" : $data[0]['PHONE'];
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
				$this->session->set_userdata(array('PASSWORD'	=>$password));
				$this->connection_status	=	TRUE;
				return 'userLoggedIn';
			}
		}
		return 'PseudoOrPasswordWrong';
	}
	public function sendValidationMail($email)
	{
		$option	=	$this->core->tendoo->getOptions();
		$user	=	$this->emailExist($email);
		if($user)
		{
			if($user['PRIVILEGE']	==	'NADIMERPUS')
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
<a href="'.$this->core->url->site_url(array('login','activate',$user['EMAIL'],$this->core->tendoo->timestamp() + 172800,$user['PASSWORD'])).'">Activer votre compte '.$user['PSEUDO'].'</a>.<br>

Ce mail à été envoyé à l\'occassion d\'une inscription sur le site <a href="'.$this->core->url->main_url().'">'.$this->core->url->main_url().'</a>.
			';
			
			$this->core->load->library('email');
			$this->email	=&	$this->core->email;
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
		$option	=	$this->core->tendoo->getOptions();
		$user	=	$this->emailExist($email);
		if($user)
		{
			if($user['PRIVILEGE']	==	'NADIMERPUS')
			{
				return 'actionProhibited';
			}
			$mail	=	 '
<h4>Syst&egrave;me de r&eacute;cup&eacute;ration de mot de passe.</h4>

Changer votre mot de passe en acc&egrave;dant &agrave; cette adresse :
<a href="'.$this->core->url->site_url(array('login','passchange',$user['EMAIL'],$this->core->tendoo->timestamp() + 10800,$user['PASSWORD'])).'">Changer le mot de passe</a>.<br>

Ce mail à été envoyé à l\'occassion d\'une tentative r&eacute;cuperation de mot de passe. Si vous pensez qu\'il s\'agisse d\'une erreur, nous vous prions de ne point donner de suite &agrave; ce message etant donn&eacute; que l\'opération n\'est valide que pour 3h.
			';
			$this->core->load->library('email');
			$this->email	=&	$this->core->email;
			$config = array (
				'mailtype' => 'html',
				'charset'  => 'utf-8',
				'priority' => '1'
			);
			$this->email->initialize($config);
			$this->email->from('noreply@'.$_SERVER['HTTP_HOST'], $option[0]['SITE_NAME']);
			$this->email->to($user['EMAIL']); 
			
			$this->email->subject($option[0]['SITE_NAME'].' - Changer votre mot de passe');
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
			return false;
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
		$query	=	$this->core->db->select('PRIV_ID')->from('tendoo_admin_privileges')->get();
		$result	=	$query->result_array();
		if(count($result)> 0)
		{
			$privilege	=	array();
			foreach($result as $r)
			{
				$privilege[]	=	$r['PRIV_ID'];
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
		if(in_array($this->current('PRIVILEGE'),$this->allowedAdminPrivilege()) || $this->current('PRIVILEGE') == $this->superAdmin)
		{
			return true;
		}
		return false;
	}
	public function isSuperAdmin()
	{
		if($this->current('PRIVILEGE') == 'NADIMERPUS')
		{
			return true;
		}
		return false;
	}
	public function getAdmin($start	=	NULL,$end	=	NULL)
	{
		$this->db->where('PRIVILEGE !=',$this->superAdmin);
		if($start != NULL && $end != NULL)
		{
			$this->db->limit($end,$start);
		}
		$query	=	$this->db->get('tendoo_users');
		return $query->result_array();
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
	public function getUserMenu()
	{
		if($this->isConnected())
		{
		?>
            <div id="user_menu">
                <div class="logo">
                    <img src="<?php echo $this->core->url->img_url('logo_minim.png');?>" />
                </div>
                <ul>
                <?php
				if($this->isAdmin() || $this->isSuperAdmin())
				{
				?>
                	<li><a href="<?php echo $this->core->url->site_url(array('admin','index'));?>">Espace administration</a></li>
				<?php
				}
				?>
                    <li><a href="<?php echo $this->core->url->site_url(array('account'));?>">Mon profil</a></li>
                    <li><a href="<?php echo $this->core->url->site_url(array('account','messaging','home'));?>">Messagerie 
                    <?php
					$unread	=	$this->getUnreadMsg();
					if($unread > 0)
					{
                    ?><em class="number"><?php echo $unread;?></em>
                    <?php
					}
					?>
					</a></li>
                </ul>
                <div style="line-height:30px;float:right;margin-right:20px;">
                    <a href="<?php echo $this->core->url->site_url(array('logoff'));?>" style="text-decoration:none;color:#F90;">Deconnexion</a>
                </div>
            </div>            
            <style type="text/css">
			.number
			{
				margin:0 5px;
				border:solid 1px #B70000;
				background:#F00000;
				background:-moz-linear-gradient(top,#F40000,#C10000);
				background:-webkit-linear-gradient(top,#F40000,#C10000);
				background:-o-linear-gradient(top,#F40000,#C10000);
				background:-ms-linear-gradient(top,#F40000,#C10000);
				color:#FFF;
				line-height:normal;
				padding:2px 5px;
				font-style:normal;
				text-shadow:0px 0px 1px #333;
				border-radius:10px;
			}
			.logo
			{
				margin: 5px;
				line-height: 20px;
				height: 20px;
				float:left;
				padding: 0;
				font-weight: normal;
				font-size: 10pt;
				color: #fff;
				margin-left:20px;
				margin-right:20px;
			}
			.logo img
			{
				float: left;
				height: 30px;
				position: relative;
				top:-5px;
			}
			#user_menu
			{
				height:30px;
				width:100%;
				position:fixed;
				top:0;
				left:0;
				background: url(data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAIAAAAmkwkpAAAAGklEQVR42mMQhAEJCQkGOAtIMsBZIA6cBQQAW5wDhYzvi1MAAAAASUVORK5CYII%3D) repeat;
				z-index:9000;
				border:solid 1px #000;
				box-shadow:0px 1px 2px #333;
			}
            #user_menu ul
			{
				float:left;
				margin:0;
				padding:0;
				list-style: none;
			}
			#user_menu ul li
			{
				float:left;
			}
			#user_menu ul li a
			{
				height:30px;
				line-height:30px;
				padding:0 10px;
				text-decoration:none;
				color:#FFF;
				display:block;
			}
			#user_menu ul li a:hover
			{
				box-shadow:inset 0px 1px 1px #333;
				background:#F2F2F2;
				background:-moz-linear-gradient(top,#F2F2F2,#DDD);
				background:-webkit-linear-gradient(top,#F2F2F2,#DDD);
				background:-ms-linear-gradient(top,#F2F2F2,#DDD);
				background:-o-linear-gradient(top,#F2F2F2,#DDD);
				color:#333;
			}
            </style>
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
			if($this->isAllowedPrivilege($priv) || $priv 	==	'RELPIMSUSE')
			{
				if($this->db->where('PSEUDO',strtolower($pseudo))->update('tendoo_users',
					array('EMAIL'	=>	$email,'PRIVILEGE'=>$priv)
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
		if($this->current($element))
		{
			return $this->db->where('ID',$this->current('ID'))->update('tendoo_users',array($element=>$value));
		}
		return false;
	}
	public function updatePassword($old,$new)
	{
		if($this->current('PASSWORD')	==	sha1($old))
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
			return 'error_occured';
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
			$post_date				=	$this->tendoo->datetime();
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
				'DATE'				=>	$this->tendoo->datetime(),
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
			case 'RELPIMSUSE' : return 'Utilisateur';break;
		}
	}
}