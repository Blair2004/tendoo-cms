<?php
class Install
{
	private $data;
	private $hubby_instance;
	public function __construct()
	{
		$this->core				=	Controller::instance();
		$this->load				=	$this->core->load;
		$this->load->library('notice');
		$this->data['notice']	=	'';
		$this->data['error']	=	'';
		$this->load->library('file');
		$this->load->library('form_validation');
$this->core->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><i style="font-size:18px;margin-right:5px;" class="icon-warning-sign"></i>', '</div>');
		$this->core->file->css_push('app.v2');
		$this->core->file->css_push('css1');
		$this->core->file->css_push('css2');
		$this->core->file->css_push('hubby_global');

		$this->core->file->js_push('jquery');
		$this->core->file->js_push('app.v2');
	}
	public function index($i = 1,$e = '')
	{
		$this->etape($i,$e);
	}
	public function etape($i = 1,$e = '')
	{
		$this->data['etape']	=	$i;
		$this->data['InstallError'] = '';
		if($i == 1)
		{
			$_SESSION['secur_access'] = 1;
			if(isset($_POST['submit']))
			{
				$_SESSION['secur_access'] = 2;
				$this->core->url->redirect(array('install','etape',2));
			}
			$this->core->hubby->setTitle('Hubby - Installation');
			$this->load->view('header',$this->data);
			$this->load->view('install/step/1/homebody',$this->data);
		}
		else if($i == 2)
		{
			if(!isset($_SESSION['secur_access']))
			{
				$this->core->url->redirect(array('install','etape',1));
			}
			else
			{
				if(!in_array($_SESSION['secur_access'],array(2)))
				{
					$this->core->url->redirect(array('install','etape',1));
				}
			}
			if(isset($_POST['host_name'],$_POST['user_name']))
			{
				$this->core->form_validation->set_rules('host_name','Nom de l\'hôte','trim|required|min_length[3]');
				$this->core->form_validation->set_rules('user_name','Nom de l\'utilisateur','trim|required');
				$this->core->form_validation->set_rules('host_password','mot de passe','trim|required');
				$this->core->form_validation->set_rules('db_name','nom de la base de donn&eacute;e','trim|required');
				$this->core->form_validation->set_rules('db_type','type du serveur','trim|required');
				if($this->core->form_validation->run())
				{
					$connexion	=	$this->core->hubby->attemptConnexion(
										$this->core->input->post('host_name'),
										$this->core->input->post('user_name'),
										$this->core->input->post('host_password'),
										$this->core->input->post('db_name'),
										$this->core->input->post('db_type'));
					if($connexion === TRUE)
					{
						$_SESSION['secur_access'] = 3;
						$this->core->url->redirect(array('install','etape',3));
					}
				}
			}
			$this->core->hubby->setTitle('Hubby - Première etape');
			$this->load->view('header',$this->data);
			$this->load->view('install/step/2/homebody',$this->data);
		}
		else if($i == 3)
		{
			if(isset($_SESSION['db_datas']))
			{
				if(!isset($_SESSION['secur_access']))
				{
					$this->core->url->redirect('install/etape/1');
				}
				else
				{
					if($_SESSION['secur_access'] != 3)
					{
						$this->core->url->redirect('install/etape/1');
					}
				}
				$this->core->hubby->setTitle('Hubby - Segonde etape');
				$this->load->view('header',$this->data);
				$this->core->load->view('install/step/3/homebody',$this->data);
			}
			else
			{
				$this->core->url->redirect('install/etape/1/installError');
			}
		}
		else if($i == 4)
		{
			if(!isset($_SESSION['secur_access']))
			{
				$this->core->url->redirect('install/etape/1');
			}
			else
			{
				if($_SESSION['secur_access'] != 4)
				{
					$this->core->url->redirect('install/etape/1');
				}
			}
			if(isset($_POST['web_access']))
			{
				// Execute control
				unset($_SESSION['secur_access']);
				$this->core->hubby->createConfigFile(); // Créer le fichier de configuration.
				$this->core->url->redirect('index');
			}
			if(isset($_POST['admin_access']))
			{
				// Execute control
				unset($_SESSION['secur_access']);
				$this->core->hubby->createConfigFile(); // Créer le fichier de configuration.
				$this->core->url->redirect('admin');
			}
			$this->core->hubby->setTitle('Hubby - Bravo votre site web est pr&ecirc;t');
			$this->load->view('header',$this->data);
			$this->load->view('install/step/4/homebody',$this->data);
		}
	}
	public function createTables()
	{
		if(isset($_POST['site_name']))
		{
			
			$this->core->form_validation->set_rules('site_name','Nom du site','trim|required|min_length[4]');
			if($this->core->form_validation->run())
			{
				if(!$this->core->hubby->createTables())
				{
					echo 'false'; // Table creation failed, redirect so
				}
				else
				{
					if($this->core->hubby->setOptions($this->core->input->post('site_name')))
					{
						$_SESSION['secur_access']	=	4;
						echo 'true';
					}
					else
					{
						echo 'false';
					}
				}
			}
			// Execute control
		}
		else
		{
			echo 'false';
		}
	}
	public function installApp($namespace)
	{
		$server	=	$_SESSION['db_datas'];
		$this->core->hubby->attemptConnexion($server['hostname'],$server['username'],$server['password'],$server['database'],$server['dbdriver']);
		$this->core->hubby->defaultsApp($namespace);
	}
}