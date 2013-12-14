<?php
	if(class_exists('hubby_admin'))
	{
		class Pages_admin
		{
			private $data;
			private $dir;
			private $cp_dir;
			private $core;
			private $hubby;
			private $hubby_admin;
			public function __construct($data)
			{
				$this->core			=	Controller::instance();
				$this->data			=	$data;
				$this->hubby		=&	$this->core->hubby;
				$this->hubby_admin	=&	$this->core->hubby_admin;
				$this->dir			=	__DIR__;
				if(!is_dir($this->dir.'\created_pages'))
				{
					mkdir($this->dir.'\created_pages');
				}
				$this->cp_dir = $this->dir.'\created_pages';
			}
			public function datetime()
			{
				return $this->hubby->datetime();
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
				return $this->core->db		->insert('hubby_pages',$datas);
			}
			public function edit($id,$title,$desc,$contenu)
			{
				$query						=	$this->core->db->where('ID',$id)->get('hubby_pages');
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
											->update('hubby_pages',$datas);
			}
			public function getPages($start = '',$end = '')
			{
				if(is_numeric($start) && is_numeric($end))
				{
					$this->core->db->limit($end,$start);
				}
				$query	=	$this->core->db->get('hubby_pages');
				return $query->result_array();
			}
			public function getSpePage($id)
			{
				$query	= $this->core->db->where('ID',$id)->get('hubby_pages');
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
				$cur_page					=	$this->core->db->where('ID',$id)->get('hubby_pages');
				$array						=	$cur_page->result_array();
				$dir						=	opendir($this->cp_dir);
				if(is_file($this->cp_dir.'/'.$array[0]['FILE_NAME']))
				{
					unlink($this->cp_dir.'/'.$array[0]['FILE_NAME']);
					return $this->core->db->where('ID',$id)->delete('hubby_pages');
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
