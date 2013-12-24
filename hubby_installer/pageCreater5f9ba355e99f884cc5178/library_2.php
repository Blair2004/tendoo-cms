<?php
/// -------------------------------------------------------------------------------------------------------------------///
global $NOTICE_SUPER_ARRAY;
/// -------------------------------------------------------------------------------------------------------------------///
$or['noCategoryCreated']		=	'<span class="error"><i class="icon-warning"></i> Avant de publier un article, vous devez cr&eacute;er une cat&eacute;gorie.</span>';

/// -------------------------------------------------------------------------------------------------------------------///
$NOTICE_SUPER_ARRAY = $or;
/// -------------------------------------------------------------------------------------------------------------------///
	if(class_exists('hubby_admin'))
	{
		class refToPage_lib
		{
			private $data;
			private $user;
			public function __construct($data)
			{
				$this->core		=	Controller::instance();
				$this->data		=	$data;
				$this->user		=&	$this->core->users_global;
				$this->hubby	=&	$this->core->hubby;	
			}
			public function datetime()
			{
				return $this->hubby->datetime();
			}
			public function isAttached($page)
			{
				$query	=	$this->core->db->where('PAGE_CONTROLEUR',$page)->get('hubby_refTopage');
				$result	=	$query->result_array();
				if(count($result) > 0)
				{
					// Extra session retreiving data from other plugin, mean that if that plugin is not installed bug may occure
					$pageEditor	=	$this->core->hubby_admin->getSpeMod('Pages_editor',FALSE);
					if($pageEditor)
					{
						include_once(MODULES_DIR.$pageEditor[0]['ENCRYPTED_DIR'].'/library.php');
						$pageLib	=	new Pages_admin($this->data);
						return array(
							'PAGE_REFTOPAGE'	=>	$result[0],
							'PAGE_HTML'			=>	$pageLib->getSpePage($result[0]['PAGE_HTML']),
							'MODULE'			=>	$pageEditor[0]
						);
					}
				}
				return false;				
			}
			public function getContentList()
			{
				// Extra session retreiving data from other plugin, mean that if that plugin is not installed bug may occure
				$pageEditor	=	$this->core->hubby_admin->getSpeMod('Pages_editor',FALSE);
				if($pageEditor)
				{
					include_once(MODULES_DIR.$pageEditor[0]['ENCRYPTED_DIR'].'/library.php');
					$pageLib	=	new Pages_admin($this->data);
					return $pageLib->getPages();
				}
			}
			public function attach($page,$content)
			{
				$query	=	$this->core->db->where('PAGE_CONTROLEUR',$page)->get('hubby_refTopage');
				$result	=	$query->result_array();
				if(count($result) > 0)
				{
					return $this->core->db->where('PAGE_CONTROLEUR',$page)->update('hubby_refTopage',array('PAGE_HTML'=>$content,'AUTEUR'	=>	$this->core->users_global->current('ID')));
				}
				else
				{
					return $this->core->db->insert('hubby_refTopage',array(
							'PAGE_HTML'				=>	$content,
							'PAGE_CONTROLEUR'		=>	$page,
							'AUTEUR'				=>	$this->core->users_global->current('ID'),
							'DATE'					=>	$this->core->hubby->datetime()
						)
					);
				}
			}
		}
	}
	if(class_exists('hubby'))
	{
		class hubby_refTopage_smart
		{
			private $data;
			private $hubby;
			private $ci;
			public function __construct($data	=	array())
			{
				$this->core		=	Controller::instance();
				$this->data		=&	$data;
				$this->hubby	=&	$this->core->hubby;
				$this->users	=&	$this->core->users_global;
			}
			public function getContent($controller)
			{
				// Extra session retreiving data from other plugin, mean that if that plugin is not installed bug may occure
				$pageEditor	=	$this->core->hubby->getSpeModule('Pages_editor',FALSE);
				if($pageEditor)
				{
					$prequery	=	$this->core->hubby->getPage($controller);
					$query		=	$this->core->db->where('PAGE_CONTROLEUR',$prequery[0]['ID'])->get('hubby_refTopage');
					$result		=	$query->result_array();
					if(count($result) > 0)
					{
						include_once(MODULES_DIR.$pageEditor[0]['ENCRYPTED_DIR'].'/library.php');
						$pageLib	=	new Pages_smart($this->data);
						return 	$pageLib->getPage($result[0]['PAGE_HTML']);
					}
				}
				return false;
			}
		}	
	}
