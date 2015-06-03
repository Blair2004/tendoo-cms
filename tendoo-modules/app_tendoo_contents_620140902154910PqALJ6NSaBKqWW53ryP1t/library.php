<?php
global $NOTICE_SUPER_ARRAY;
/// -------------------------------------------------------------------------------------------------------------------///
$or['fileReplaced']			=	tendoo_success('Le fichier &agrave; &eacute;t&eacute; correctement modifi&eacute;.');

/// -------------------------------------------------------------------------------------------------------------------///
$NOTICE_SUPER_ARRAY = $or;
	if(class_exists('tendoo_admin'))
	{
		class file_contentAdmin extends Libraries
		{
			public function __construct($data)
			{
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				parent::__construct();
				__extends($this);
				// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				$this->instance		=	get_instance();
				$this->data			=	$data;
				$this->tendoo		=&	$this->instance->tendoo;
				$this->tendoo_admin	=&	$this->instance->tendoo_admin;
				$this->users_global	=&	$this->instance->users_global;
				$module				=	get_core_vars( 'opened_module' );
				$this->dir			=	'tendoo-modules/'.$module['encrypted_dir'];
				if(!is_dir($this->dir.'/content_repository'))
				{
					mkdir($this->dir.'/content_repository');
				}
				$this->cp_dir = $this->dir.'/content_repository';
			}
			public function datetime()
			{
				return $this->instance->date->datetime();
			}
			public function getName()
			{
				return 'tendoo_content_'.rand(0,9).date('Y').date('m').date('d').date('H').date('i').date('s').rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
			}
			public function uploadFile($file,$title,$description)
			{
				$config['upload_path'] 		= $this->cp_dir;
				$config['allowed_types'] 	= 'gif|jpg|png|avi|mp3|mp4|ogg|zip|rar|docx|doc|pdf';
				$config['max_size'] 		= '500000';
				$config['file_name']		= $this->getName();
				$this->load->library('upload',$config);
				if($this->instance->upload->do_upload($file))
				{
					$_query					=	$this->instance->db->get('tendoo_contents');
					$_result				=	$_query->result_array(); // Counting uploaded files
					$ids					=	count($_result)+1;
					
					$result	= $this->instance->upload->data();
					$array	=	array(
						'ID'				=>		$ids,
						'FILE_NAME'			=>		$result['file_name'],
						'FILE_TYPE'			=>		substr($result['file_ext'],1),
						'DATE'				=>		$this->instance->date->datetime(),
						'TITLE'				=>		$title,
						'DESCRIPTION'		=>		$description,
						'AUTHOR'			=>		$this->users_global->current('ID')
					);
					$this->instance->db->insert('tendoo_contents',$array);
					return $this->_createThumb($ids);
				}
				return false;				
			}
			public function _createThumb($image_id)
			{
				$image 	=	$this->getUploadedFiles($image_id);
				$percent	=	0.5;
				if(strtolower($image[0]['FILE_TYPE']) == 'png')
				{
					list($width,$height) =	getimagesize($this->cp_dir.'/'.$image[0]['FILE_NAME']);
					$newWidth			=	$width * $percent;
					$newHeight			=	$height * $percent;
					
					$source_ressource	=	imagecreatefrompng($this->cp_dir.'/'.$image[0]['FILE_NAME']);
					$thumb				=	imagecreatetruecolor($newWidth,$newHeight);
					
					imagecopyresized($thumb, $source_ressource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
					return imagepng($thumb,$this->cp_dir.'/small_'.$image[0]['FILE_NAME']);
				}
				else if(strtolower($image[0]['FILE_TYPE']) == 'jpg')
				{
					list($width,$height) =	getimagesize($this->cp_dir.'/'.$image[0]['FILE_NAME']);
					$newWidth			=	$width * $percent;
					$newHeight			=	$height * $percent;
					
					$source_ressource	=	imagecreatefromjpeg($this->cp_dir.'/'.$image[0]['FILE_NAME']);
					$thumb				=	imagecreatetruecolor($newWidth,$newHeight);
					
					imagecopyresized($thumb, $source_ressource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
					return imagejpeg($thumb,$this->cp_dir.'/small_'.$image[0]['FILE_NAME']);
				}
				return false;
			}
			public function countUploadedFiles()
			{
				$query	=	$this->instance->db->get('tendoo_contents');
				return count($query->result_array());
			}
			public function getUploadedFiles($start	='',$end	='')
			{
				if(is_numeric($start) && is_numeric($end))
				{
					$this->instance->db->limit($end,$start);
				}
				if(is_numeric($start ) && !is_numeric($end))
				{
					$this->instance->db->where('ID',$start);
				}
				$query	=	$this->instance->db->order_by("ID", "desc")->get('tendoo_contents');
				return	$query->result_array();
			}
			public function fileReplace($image_id,$uploaded_file)
			{
				$file	=	$this->getUploadedFiles($image_id);
				$file_l	=	$this->cp_dir.'/'.$file[0]['FILE_NAME'];
				$file_1_thumb	=	$this->cp_dir.'/small_'.$file[0]['FILE_NAME'];
				if(file_exists($file_l))
				{
					unlink($file_l);
					unlink($file_1_thumb);
				}
				$namesansext				=	explode('.',$file[0]['FILE_NAME']);
				$namesansext				=	$namesansext[0];
				$config['upload_path'] 		= $this->cp_dir;
				$config['allowed_types'] 	= 'gif|jpg|png|avi|mp3|mp4|ogg|zip|rar|docx|doc|pdf';
				$config['max_size'] 		= '500000';
				$config['file_name']		= $namesansext;
				$config['overwrite']		=	TRUE;
				$this->load->library('upload',$config);
				if($this->instance->upload->do_upload($uploaded_file))
				{
					$file_data				=	$this->instance->upload->data();
					$this->instance->db->where('ID',$image_id)->update('tendoo_contents',
						array(
							'FILE_NAME'	=>	$file_data['file_name'],
							'FILE_TYPE'	=>	substr($file_data['file_ext'],1),
							'AUTHOR'	=>	$this->instance->users_global->current('ID')
						)
					); // un finished
					$this->_createThumb($image_id);
					return 'fileReplaced';
				}
				return 'error-occured';
			}
			public function fileDrop($id)
			{
				$f		=	$this->getUploadedFiles($id);
				if(count($f) > 0)
				{
					$this->instance->db->where('ID',$id)->delete('tendoo_contents');
					file_exists($this->cp_dir.'/small_'.$f[0]['FILE_NAME']) == TRUE ? unlink($this->cp_dir.'/small_'.$f[0]['FILE_NAME']) : false;
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
						'DATE'			=>	$this->instance->date->datetime(),
						'AUTHOR'		=>	$this->instance->users_global->current('ID')
					);
					return $this->instance->db->where('ID',$thefile[0]['ID'])->update('tendoo_contents',$array);
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
					
					$this->load->library('image_lib');
					$this->instance->image_lib->initialize($config); 
					$this->instance->image_lib->crop();
					$notice						=	$this->instance->image_lib->display_errors();
					$this->_createThumb($image_id);
					if($notice != '')
					{
					$this->instance->notice->push_notice(fetch_notice_output($notice));
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
					$this->load->library('image_lib');
					$this->instance->image_lib->initialize($config); 
					$this->instance->image_lib->crop();
					$notice						=	$this->instance->image_lib->display_errors();
					if($notice == '')
					{
						$_query					=	$this->instance->db->get('tendoo_contents');
						$_result				=	$_query->result_array(); // Counting uploaded files
						$ids					=	count($_result)+1;
						
						$date					=	$this->instance->date->datetime();
						$array	=	array(
							'ID'				=>		$ids,
							'FILE_NAME'			=>		$image_name.'.'.strtolower($image[0]['FILE_TYPE']),
							'FILE_TYPE'			=>		$image[0]['FILE_TYPE'],
							'DATE'				=>		$date,
							'TITLE'				=>		$image[0]['TITLE'],
							'DESCRIPTION'		=>		$image[0]['DESCRIPTION'],
							'AUTHOR'			=>		$this->users_global->current('ID')
						);
						$this->instance->db->insert('tendoo_contents',$array);
						$this->_createThumb($ids);
						return 'done';
					}
				}
				return 'error-occured';
			}
		}
	}
	if(class_exists('tendoo'))
	{
		class Pages_smart
		{
			private $data;
			private $ci;
			public function __construct($data)
			{
				$this->data	=	$data;
				$this->instance	=	get_instance();
				$this->dir	=	__DIR__;
				if(!is_dir($this->dir.'\created_pages'))
				{
					mkdir($this->dir.'\created_pages');
				}
				$this->cp_dir = $this->dir.'\created_pages';
			}
			public function getPage($id)
			{
				$query	= $this->instance->db->where('ID',$id)->get('tendoo_pages');
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
