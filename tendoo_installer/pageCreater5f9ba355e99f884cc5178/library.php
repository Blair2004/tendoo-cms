<?php
	if(class_exists('Tendoo_admin'))
	{
		class Pages_admin
		{
			private $data;
			private $dir;
			private $cp_dir;
			private $core;
			private $Tendoo;
			private $Tendoo_admin;
			public function __construct($data)
			{
				$this->core			=	Controller::instance();
				$this->data			=	$data;
				$this->tendoo		=&	$this->core->tendoo;
				$this->tendoo_admin	=&	$this->core->tendoo_admin;
				$this->dir			=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'];
				if(!is_dir($this->dir.'/created_pages'))
				{
					mkdir($this->dir.'/created_pages');
				}
				$this->cp_dir = $this->dir.'/created_pages';
			}
			public function datetime()
			{
				return $this->tendoo->datetime();
			}
			public function create($title,$desc,$contenu)
			{
				$file_name	=	rand(0,9).rand(0,9).rand(0,9).rand(0,9).time().'.txt';
				$datas	=	array(
					'TITLE'					=>$title,
					'DESCRIPTION'			=>$desc,
					'FILE_NAME'				=>$file_name,
					'DATE'					=>$this->datetime(),
					'AUTHOR'				=>$this->core->users_global->current('ID')
				);
				$dos						=	opendir($this->cp_dir.'/');
				$file						=	fopen($this->cp_dir.'/'.$file_name,'w+');
												fwrite($file,$contenu);
												fclose($file);
												closedir($dos);
				return $this->core->db		->insert('Tendoo_pages',$datas);
			}
			public function edit($id,$title,$desc,$contenu)
			{
				$query						=	$this->core->db->where('ID',$id)->get('Tendoo_pages');
				$cur_page					=	$query					->result_array();
				$dir						=	opendir($this->cp_dir);
				$file						=	fopen($this->cp_dir.'/'.$cur_page[0]['FILE_NAME'],'w+');
				fwrite($file,$contenu);
				fclose($file);
				closedir($dir);
				$datas						=	array(
					'TITLE'					=>$title,
					'DESCRIPTION'			=>$desc,
					'DATE'					=>$this->datetime(),
					'AUTHOR'				=>$this->core->users_global->current('ID')
				);
				return $this->core->db		->where('ID',$id)
											->update('Tendoo_pages',$datas);
			}
			public function getPages($start = '',$end = '')
			{
				if(is_numeric($start) && is_numeric($end))
				{
					$this->core->db->limit($end,$start);
				}
				$query	=	$this->core->db->get('Tendoo_pages');
				return $query->result_array();
			}
			public function getSpePage($id)
			{
				$query	= $this->core->db->where('ID',$id)->get('Tendoo_pages');
				$ar	=	$query->result_array();
				$dos	=	opendir($this->cp_dir);
				$file	=	fopen($this->cp_dir.'/'.$ar[0]['FILE_NAME'],'r');
				$content=	fread($file,filesize($this->cp_dir.'/'.$ar[0]['FILE_NAME']));
				fclose($file);
				closedir($dos);
				$ar[0]['CONTENT']	=$content;
				return $ar;
			}
			public function deletePage($id)
			{
				$cur_page					=	$this->core->db->where('ID',$id)->get('Tendoo_pages');
				$array						=	$cur_page->result_array();
				$dir						=	opendir($this->cp_dir);
				if(is_file($this->cp_dir.'/'.$array[0]['FILE_NAME']))
				{
					unlink($this->cp_dir.'/'.$array[0]['FILE_NAME']);
					return $this->core->db->where('ID',$id)->delete('Tendoo_pages');
				}
				return false;
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
				$this->dir	=	MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'];
				if(!is_dir($this->dir.'/created_pages'))
				{
					mkdir($this->dir.'/created_pages');
				}
				$this->cp_dir = $this->dir.'/created_pages';
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
					if(is_file($this->cp_dir.'/'.$ar[0]['FILE_NAME']))
					{
						$file	=	fopen($this->cp_dir.'/'.$ar[0]['FILE_NAME'],'r');
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
