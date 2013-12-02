<?php
	if(class_exists('hubby_admin'))
	{
		class file_contentAdmin
		{
			private $data;
			private $dir;
			private $cp_dir;
			private $core;
			private $hubby;
			private $hubby_admin;
			private $users_global;
			public function __construct($data)
			{
				$this->core			=	Controller::instance();
				$this->data			=	$data;
				$this->hubby		=&	$this->core->hubby;
				$this->hubby_admin	=&	$this->core->hubby_admin;
				$this->users_global	=&	$this->core->users_global;
				$this->dir			=	'hubby_modules/'.$this->data['module'][0]['ENCRYPTED_DIR'];
				if(!is_dir($this->dir.'/content_repository'))
				{
					mkdir($this->dir.'/content_repository');
				}
				$this->cp_dir = $this->dir.'/content_repository';
			}
			public function datetime()
			{
				return $this->hubby->datetime();
			}
			public function getName()
			{
				return 'hubby_content_'.rand(0,9).date('Y').date('m').date('d').date('H').date('i').date('s').rand(0,9).rand(0,9).rand(0,9);
			}
			public function uploadFile($file,$title,$description)
			{
				$config['upload_path'] 		= $this->cp_dir;
				$config['allowed_types'] 	= 'gif|jpg|png|avi|mp3|mp4|ogg|zip|rar|docx|doc|pdf';
				$config['max_size'] 		= '500000';
				$config['file_name']		= $this->getName();
				$this->core->load->library('upload',$config);
				if($this->core->upload->do_upload($file))
				{
					$result	= $this->core->upload->data();
					$array	=	array(
						'FILE_NAME'			=>		$result['file_name'],
						'FILE_TYPE'			=>		substr($result['file_ext'],1),
						'DATE'				=>		$this->core->hubby->datetime(),
						'TITLE'				=>		$title,
						'DESCRIPTION'		=>		$description,
						'AUTHOR'			=>		$this->users_global->current('ID')
					);
					return $this->core->db->insert('hubby_contents',$array);
				}
				return false;				
			}
			public function countUploadedFiles()
			{
				$query	=	$this->core->db->get('hubby_contents');
				return count($query->result_array());
			}
			public function getUploadedFiles($start	='',$end	='')
			{
				if($start == '' && $end  == '')
				{
					$this->core->db->limit($end,$start);
				}
				if($start != '' && $end == '')
				{
					$this->core->db->where('ID',$start);
				}
				$query	=	$this->core->db->order_by("ID", "desc")->get('hubby_contents');
				return	$query->result_array();
			}
			public function fileDrop($id)
			{
				$f		=	$this->getUploadedFiles($id);
				if(count($f) > 0)
				{
					$this->core->db->where('ID',$id)->delete('hubby_contents');
					return unlink($this->cp_dir.'/'.$f[0]['FILE_NAME']);
				}
				return false;
			}
			public function editFile($id,$name,$description)
			{
				$thefile	=	$this->getUploadedFiles($id);
				if($thefile)
				{
					$array	=	array(
						'TITLE'			=>	$name,
						'DESCRIPTION'	=>	$description,
						'DATE'			=>	$this->core->hubby->datetime(),
						'AUTHOR'		=>	$this->core->users_global->current('ID')
					);
					return $this->core->db->update('hubby_contents',$array);
				}
				return false;
			}
		}
	}
	if(class_exists('hubby'))
	{
		class Pages_smart
		{
			private $data;
			private $ci;
			public function __construct($data)
			{
				$this->data	=	$data;
				$this->core	=	Controller::instance();
				$this->dir	=	__DIR__;
				if(!is_dir($this->dir.'\created_pages'))
				{
					mkdir($this->dir.'\created_pages');
				}
				$this->cp_dir = $this->dir.'\created_pages';
			}
			public function getPage($id)
			{
				$query	= $this->core->db->where('ID',$id)->get('hubby_pages');
				$ar	=	$query->result_array();
				if(is_dir($this->cp_dir))
				{
					if(count($ar) == 0)
					{
						$ar[]			=	array('TITLE'=>'Page Introuvable','DESCRIPTION'=>'','FILE_NAME'=>'');
					}
					$dos	=	opendir($this->cp_dir);
					if(is_file($this->cp_dir.'\\'.$ar[0]['FILE_NAME']))
					{
						$file	=	fopen($this->cp_dir.'\\'.$ar[0]['FILE_NAME'],'r');
						$content=	fread($file,filesize($this->cp_dir.'/'.$ar[0]['FILE_NAME']));
						fclose($file);
						closedir($dos);
						$ar[0]['CONTENT']	=$content;
					}
					else
					{
						$ar[0]['CONTENT']	= '<p class="warning">Le fichier lié à cette page est introuvable.</p>';
					}
				}
				return $ar;
			}
		}	
	}
