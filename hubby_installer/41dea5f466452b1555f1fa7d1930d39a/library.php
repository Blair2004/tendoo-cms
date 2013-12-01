<?php
	if(class_exists('hubby_admin'))
	{
		class Index_mod_admin
		{
			private $data;
			private $core;
			private $newsModule;
			private $newsOptFile;
			private $elementOptFile;
			private $newsOpt;
			private $elementOpt;
			private $access;
			public function __construct($data)
			{
				$this->newsOptFile		=	MODULES_DIR.$data['module'][0]['ENCRYPTED_DIR'].'/news_options.php';
				$this->elementOptFile	=	MODULES_DIR.$data['module'][0]['ENCRYPTED_DIR'].'/element_options.php';
				if(!is_file($this->newsOptFile) && !is_file($this->elementOptFile))
				{
					$this->access  	= FALSE;
				}
				else
				{
					include_once($this->newsOptFile);
					include_once($this->elementOptFile);
					$this->newsOpt		=&	$OPTIONS;
					$this->elementOpt	=&	$ELEMENT_OPTIONS;
					$this->access		= 	TRUE;
				}
				$this->data				= 	$data;
				$this->core				=	$this->data['core'];
				$this->newsModule		=	$this->core->hubby_admin->getSpeMod('news',FALSE);
			}
			public function &getNewsOpt()
			{
				return $this->newsOpt;
			}
			public function &getElementOpt()
			{
				return $this->elementOpt;
			}
			public function getAccess()
			{
				return $this->access;
			}
			public function getMenu()
			{
			}
			public function setNewsOpt($NEW_OPTIONS)
			{
				$file	=	fopen($this->newsOptFile,'w+');
				$options_string	=	'<?php ';
				foreach($NEW_OPTIONS as $k => $val)
				{
					$options_string	.= ' $OPTIONS["'.$k.'"]	=	';
					if(is_array($val))
					{
						$start	=	0;
						$options_string	.= 'array(';
						foreach($val as $_k => $v)
						{
							if(is_bool($v))
							{
								$str_v	=	($v === TRUE) ? 'TRUE' : 'FALSE';
							}
							else
							{
								$str_v	=	$v;
							}
							if($start == (count($val) -1))
							{
								$options_string	.=	'"'.$_k.'" => '.$str_v;
							}
							else
							{
								$options_string	.=	'"'.$_k.'" => '.$str_v.',';
							}
							$start++;
						}
						$options_string	.= ');';
					}
					else
					{
						$options_string	.= $val.';';
					}
				}
				fwrite($file,$options_string);
				fclose($file);
				eval(substr($options_string,5));
				$this->newsOpt	=	$OPTIONS;
			}
			public function toggleElement($element)
			{
				switch($element)
				{
					case 'CAROUSSEL'			:	$this->elementOpt['CAROUSSEL']				= ($this->elementOpt['CAROUSSEL'] === TRUE) ? FALSE : TRUE;break;
					case 'ONTOP'				:	$this->elementOpt['ONTOP']					= ($this->elementOpt['ONTOP'] === TRUE) 	? FALSE : TRUE;break;
					case 'INFOSMALLDETAILS'		:	$this->elementOpt['INFOSMALLDETAILS']		= ($this->elementOpt['INFOSMALLDETAILS'] === TRUE) 	? FALSE : TRUE;break;
				}
				$file	=	fopen($this->elementOptFile,'w+');
				fwrite($file,$this->sprawnElementCode($this->elementOpt));
				fclose($file);
			}
			private function sprawnElementCode($array)
			{
				$options_string	=	'<?php ';
				foreach($this->elementOpt as $k => $val)
				{
					$options_string	.= ' $ELEMENT_OPTIONS["'.$k.'"]	=	';
					if(is_array($val))
					{
						$options_string	.= 'array(';
						foreach($val as $_k => $v)
						{
							if(next($val) === FALSE)
							{
								$options_string	.=	'"'.$_k.'" => '.$v;
							}
							else
							{
								$options_string	.=	'"'.$_k.'" => '.$v.',';
							}
						}
						$options_string	.= ');';
					}
					else
					{
						$final_value	=	'';
						if(is_bool($val))
						{
							$final_value	=	 ($val === TRUE) ? 'TRUE' : 'FALSE';
						}
						$options_string	.= $final_value.';';
					}
				}
				return $options_string;
			}
			public function getNewsModule()
			{
				return $this->newsModule;
			}
			public function setNewsOptions($options)
			{
			}
		}
	}
	if(class_exists('hubby'))
	{
		class Index_mod_user
		{
			private $core;
			public function __construct()
			{
				$this->core	=	Controller::instance();
			}
			public function getNews($start,$end)
			{
				$query	=	$this->core->db->limit($end,$start)->where('ETAT','1')->order_by('ID','desc')->get('hubby_news');
				return $query->result_array();
			}
			public function getControllerNameAttachedToNewsMod()
			{
				$query	=	$this->core->db->where('PAGE_MODULES','news')->get('hubby_controllers');
				return $query->result_array();
			}
		}	
	}
