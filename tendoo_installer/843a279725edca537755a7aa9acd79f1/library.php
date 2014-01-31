<?php
global $NOTICE_SUPER_ARRAY;
/// -------------------------------------------------------------------------------------------------------------------///
$or['fileReplaced']			=	tendoo_success('Le fichier &agrave; &eacute;t&eacute; correctement modifi&eacute;.');

/// -------------------------------------------------------------------------------------------------------------------///
$NOTICE_SUPER_ARRAY = $or;
	if(class_exists('Tendoo_admin'))
	{
		class file_contentAdmin
		{
			private $data;
			private $dir;
			private $cp_dir;
			private $core;
			private $Tendoo;
			private $Tendoo_admin;
			private $users_global;
			public function __construct($data)
			{
				$this->core			=	Controller::instance();
				$this->data			=	$data;
				$this->tendoo		=&	$this->core->tendoo;
				$this->tendoo_admin	=&	$this->core->tendoo_admin;
				$this->users_global	=&	$this->core->users_global;
				$this->dir			=	'tendoo_modules/'.$this->data['module'][0]['ENCRYPTED_DIR'];
				if(!is_dir($this->dir.'/content_repository'))
				{
					mkdir($this->dir.'/content_repository');
				}
				$this->cp_dir = $this->dir.'/content_repository';
			}
			public function datetime()
			{
				return $this->tendoo->datetime();
			}
			public function getName()
			{
				return 'Tendoo_content_'.rand(0,9).date('Y').date('m').date('d').date('H').date('i').date('s').rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
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
						'DATE'				=>		$this->core->tendoo->datetime(),
						'TITLE'				=>		$title,
						'DESCRIPTION'		=>		$description,
						'AUTHOR'			=>		$this->users_global->current('ID')
					);
					return $this->core->db->insert('Tendoo_contents',$array);
				}
				return false;				
			}
			public function countUploadedFiles()
			{
				$query	=	$this->core->db->get('Tendoo_contents');
				return count($query->result_array());
			}
			public function getUploadedFiles($start	='',$end	='')
			{
				if(is_numeric($start) && is_numeric($end))
				{
					$this->core->db->limit($end,$start);
				}
				if(is_numeric($start ) && !is_numeric($end))
				{
					$this->core->db->where('ID',$start);
				}
				$query	=	$this->core->db->order_by("ID", "desc")->get('Tendoo_contents');
				return	$query->result_array();
			}
			public function fileReplace($image_id,$uploaded_file)
			{
				$file	=	$this->getUploadedFiles($image_id);
				$file_l	=	$this->cp_dir.'/'.$file[0]['FILE_NAME'];
				if(file_exists($file_l))
				{
					unlink($file_l);
				}
				$namesansext				=	explode('.',$file[0]['FILE_NAME']);
				$namesansext				=	$namesansext[0];
				$config['upload_path'] 		= $this->cp_dir;
				$config['allowed_types'] 	= 'gif|jpg|png|avi|mp3|mp4|ogg|zip|rar|docx|doc|pdf';
				$config['max_size'] 		= '500000';
				$config['file_name']		= $namesansext;
				$config['overwrite']		=	TRUE;
				$this->core->load->library('upload',$config);
				if($this->core->upload->do_upload($uploaded_file))
				{
					$file_data				=	$this->core->upload->data();
					$this->core->db->where('ID',$image_id)->update('Tendoo_contents',
						array(
							'FILE_NAME'	=>	$file_data['file_name'],
							'FILE_TYPE'	=>	substr($file_data['file_ext'],1),
							'AUTHOR'	=>	$this->core->users_global->current('ID')
						)
					); // un finished
					return 'fileReplaced';
				}
				return 'error_occured';
			}
			public function fileDrop($id)
			{
				$f		=	$this->getUploadedFiles($id);
				if(count($f) > 0)
				{
					$this->core->db->where('ID',$id)->delete('Tendoo_contents');
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
						'DATE'			=>	$this->core->tendoo->datetime(),
						'AUTHOR'		=>	$this->core->users_global->current('ID')
					);
					return $this->core->db->where('ID',$thefile[0]['ID'])->update('Tendoo_contents',$array);
				}
				return false;
			}
			public function overwrite_image($image_id,$x1,$y1,$x2,$y2,$w,$h)
			{
				$image	=	$this->getUploadedFiles($image_id);
				if($image)
				{
					$config['image_library'] 	= 'gd2';
					$config['source_image']		= $this->cp_dir.'/'.$image[0]['FILE_NAME'];
					$config['create_thumb'] 	= FALSE;
					$config['maintain_ratio'] 	= FALSE;
					$config['width']	 		= $w;
					$config['height']			= $h;
					$config['quality']			=	'100%';
					$config['x_axis'] 			= $x1;
					$config['y_axis'] 			= $y1;
					
					$this->core->load->library('image_lib');
					$this->core->image_lib->initialize($config); 
					$this->core->image_lib->crop();
					$notice						=	$this->core->image_lib->display_errors();
					if($notice != '')
					{
					$this->core->notice->push_notice(notice($notice));
					}
					return true;
				}
				return false;
			}
			public function create_new_image($image_id,$image_name,$x1,$y1,$x2,$y2,$w,$h)
			{
				$image	=	$this->getUploadedFiles($image_id);
				if($image)
				{
					$config['image_library'] 	= 'gd2';
					$config['source_image']		= $this->cp_dir.'/'.$image[0]['FILE_NAME'];
					$config['new_image']		= $this->cp_dir.'/'.$image_name.'.'.strtolower($image[0]['FILE_TYPE']);
					$config['create_thumb'] 	= FALSE;
					$config['maintain_ratio'] 	= FALSE;
					$config['width']	 		= $w;
					$config['height']			= $h;
					$config['quality']			=	'100%';
					$config['x_axis'] 			= $x1;
					$config['y_axis'] 			= $y1;
					$this->core->load->library('image_lib');
					$this->core->image_lib->initialize($config); 
					$this->core->image_lib->crop();
					$notice						=	$this->core->image_lib->display_errors();
					if($notice == '')
					{
						$date					=	$this->core->tendoo->datetime();
						$array	=	array(
							'FILE_NAME'			=>		$image_name.'.'.strtolower($image[0]['FILE_TYPE']),
							'FILE_TYPE'			=>		$image[0]['FILE_TYPE'],
							'DATE'				=>		$date,
							'TITLE'				=>		$image[0]['TITLE'],
							'DESCRIPTION'		=>		$image[0]['DESCRIPTION'],
							'AUTHOR'			=>		$this->users_global->current('ID')
						);
						$this->core->db->insert('Tendoo_contents',$array);
						return 'done';
					}
				}
				return 'error_occured';
			}
		}
	}
	if(class_exists('Tendoo'))
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
				$query	= $this->core->db->where('ID',$id)->get('Tendoo_pages');
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
