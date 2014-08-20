<?php
Class Url
{
	private $request_uri;
	private $site_name;
	private $controller;
	private $method;
	private $splited_url;
	private $script_url;
	private $parameters	=	array();
	private $rewrite	=	FALSE;

	public function __construct()
	{
		if( defined( 'REWRITE_URL' ) )
		{
			$this->rewrite	=	REWRITE_URL;					
		}
		$host	=	(in_array($_SERVER['HTTP_HOST'],array('localhost','127.0.0.1'))) ? 
						(($_SERVER['HTTP_HOST'] == 'localhost') ? 
							'localhost/' : '127.0.0.1/')
						: $_SERVER['HTTP_HOST'].'/';
		// Attribution des  valeurs.
		$this->request_uri			=	'http://'.$host.substr($_SERVER['REQUEST_URI'],1);
		$this->explode_get			=	explode('?',$this->request_uri);
		$this->splited_url			=	explode('/',substr($this->explode_get[0],7));
		$this->execution_dir		=	getcwd();
		$this->projet_dir			=	'';

		// Si la re-écriture est activé, on réduit l'index. 
		$index	=	($this->rewrite	==	true) ? 1 : 0;
		if(preg_match("#\\\#",$this->execution_dir))
		{
			$splitDir				=	explode('\\',$this->execution_dir);
			$this->projet_dir		=	$splitDir[count($splitDir) -1];
		}
		else
		{
			$splitDir				=	explode('/',$this->execution_dir);
			$this->projet_dir		=	$splitDir[count($splitDir) -1];
		}
		$rootKey					=	0;
		$newSpliterUrl				=	array();
		$copy_new_url				=	false;
		if(!in_array($this->projet_dir,$this->splited_url))
		{
			// Lorsque le dossier d'exécution n'existe pas dans l'url. Alors il faut copier l'URL depuis le début
			// La copie sera lancé au tout début de la boucle.
			$copy_new_url			=	true;
		}
		// Splited URL restructuration. To detect Base Root on URL
		// Supprésion des paramètres qui n'ont aucune valeur
		foreach($this->splited_url as $key => $p)
		{
			if($p == 'index.php')
			{
				$index				=	0;
			}
			if($p	==	 $this->projet_dir || $copy_new_url == true)
			{
				$newSpliterUrl[]	=	$p;
				$copy_new_url		= 	TRUE;
			}
			// Suppréssion des paramètres vides exemple http://exemple.com/index.php/foo////bar
			if( $p == ''){
				unset( $this->splited_url[ $key ] );
			}
		}
		if(in_array($this->projet_dir,$this->splited_url))
		{
			$this->splited_url		=		$newSpliterUrl;
		}
		$this->site_name			=	$_SERVER['HTTP_HOST'];
		if(in_array($this->splited_url[0],array('localhost','127.0.0.1')))
		{
			if(array_key_exists(2-$index,$this->splited_url)) // Si n'existe pas, nous ne somme pas censé nous trouver sous un environnement local.
			{
				if($this->splited_url[2-$index] == '')
				{
					$this->controller	=	'index';
					$this->method		=	(array_key_exists(3-$index,$this->splited_url)) ? $this->splited_url[3-$index]	:	'index';
					for($i=(4-$index);$i<count($this->splited_url);$i++)
					{
						if($this->splited_url[$i] != '')
						{
							array_push($this->parameters,$this->splited_url[$i]);
						}
					}
				}
				else if($this->splited_url[2-$index] == 'index.php')
				{
					if(array_key_exists(3-$index,$this->splited_url))
					{
						if($this->splited_url[3-$index] == '')
						{
							$this->controller	=	'index';
						}
						else
						{
							$this->controller	=	$this->splited_url[3-$index];
						}
						if(array_key_exists(4-$index,$this->splited_url))
						{
							if($this->splited_url[4-$index] != '')
							{
								$this->method	=	$this->splited_url[4-$index];
							}
							else
							{
								$this->method	=	'index';
							}
						}
						else
						{
							$this->method		=	'index';
						}
						for($i=(5-$index);$i<count($this->splited_url);$i++)
						{
							if($this->splited_url[$i] != '')
							{
								array_push($this->parameters,$this->splited_url[$i]);
							}
						}
					}
					else
					{
						$this->controller	=	'index';
						if(array_key_exists(3-$index,$this->splited_url))
						{
							if($this->splited_url[3-$index] != '')
							{
								$this->method	=	$this->splited_url[3-$index];
							}
							else
							{
								$this->method	=	'index';
							}
						}
						else
						{
							$this->method		=	'index';
						}
						for($i=(5-$index);$i<count($this->splited_url);$i++)
						{
							if($this->splited_url[$i] != '')
							{
								array_push($this->parameters,$this->splited_url[$i]);
							}
						}
					}
				}
				else
				{
					$this->controller	=	$this->splited_url[2-$index];
					if(array_key_exists(3-$index,$this->splited_url))
					{
						if($this->splited_url[3-$index] != '')
						{
							$this->method	=	$this->splited_url[3-$index];
						}
						else
						{
							$this->method	=	'index';
						}
					}
					else
					{
						$this->method		=	'index';
					}
					for($i=(4-$index);$i<count($this->splited_url);$i++)
					{
						if($this->splited_url[$i] != '')
						{
							array_push($this->parameters,$this->splited_url[$i]);
						}
					}
				}
			}
		}
		else // S'applique dans ce cas.
		{
			if(array_key_exists(1-$index,$this->splited_url))
			{
				if($this->splited_url[1-$index] == '')
				{
					$this->controller	=	'index';
					if(array_key_exists(2-$index,$this->splited_url))
					{
						if($this->splited_url[2-$index] != '')
						{
							$this->method	=	$this->splited_url[2-$index];
						}
						else
						{
							$this->method	=	'index';
						}
					}
					else
					{
						$this->method		=	'index';
					}
					for($i=(3-$index);$i<count($this->splited_url);$i++)
					{
						if($this->splited_url[$i] != '')
						{
							array_push($this->parameters,$this->splited_url[$i]);
						}
					}
				}
				else if($this->splited_url[1-$index] == 'index.php')
				{
					if(array_key_exists(2-$index,$this->splited_url))
					{
						if($this->splited_url[2-$index] == '')
						{
							$this->controller	=	'index';
						}
						else
						{
							$this->controller	=	$this->splited_url[2-$index];
						}
						if(array_key_exists(3-$index,$this->splited_url))
						{
							if($this->splited_url[3-$index] != '')
							{
								$this->method	=	$this->splited_url[3-$index];
							}
							else
							{
								$this->method	=	'index';
							}
						}
						else
						{
							$this->method		=	'index';
						}
						for($i=(4-$index);$i<count($this->splited_url);$i++)
						{
							array_push($this->parameters,$this->splited_url[$i]);
						}
					}
					else
					{
						$this->controller	=	'index';
						if(array_key_exists(2-$index,$this->splited_url))
						{
							if($this->splited_url[2-$index] != '')
							{
								$this->method	=	$this->splited_url[2-$index];
							}
							else
							{
								$this->method	=	'index';
							}
						}
						else
						{
							$this->method		=	'index';
						}
						for($i=(3-$index);$i<count($this->splited_url);$i++)
						{
							if($this->splited_url[$i] != '')
							{
								array_push($this->parameters,$this->splited_url[$i]);
							}
						}
					}
				}
				else
				{
					if($this->splited_url[2-$index] == 'index.php')
					{
						$this->controller	=	!array_key_exists(3-$index,$this->splited_url) ? 
							(($this->splited_url[3-$index] != '') ? $this->splited_url[3-$index] : 'index') :
								'index';
						if(array_key_exists(4-$index,$this->splited_url))
						{
							if(!in_array($this->splited_url[4-$index],array('','index.php')))
							{
								$this->method	=	$this->splited_url[4-$index];
							}
							else
							{
								$this->method	=	'index';
							}
						}
						else
						{
							$this->method		=	'index';
						}
						for($i=5;$i<count($this->splited_url);$i++)
						{
							if($this->splited_url[$i] != '')
							{
								array_push($this->parameters,$this->splited_url[$i]);
							}
						}
					}
					else
					{
						$this->controller	=	$this->splited_url[2-$index] != '' ? $this->splited_url[2-$index] : 'index';
						if(array_key_exists(3-$index,$this->splited_url))
						{
							if(!in_array($this->splited_url[3-$index],array('','index.php')))
							{
								$this->method	=	$this->splited_url[3-$index];
							}
							else
							{
								$this->method	=	'index';
							}
						}
						else
						{
							$this->method		=	'index';
						}
						for($i=(4-$index);$i<count($this->splited_url);$i++)
						{
							if($this->splited_url[$i] != '')
							{
								array_push($this->parameters,$this->splited_url[$i]);
							}
						}
					}
				}
			}
			else
			{
				$this->controller		=	'index';
				$this->method			=	'index';
			}
		}
	}
	public function getRewrite()
	{
		return $this->rewrite;
	}
	public function getSplitedUrl()
	{
		return $this->splited_url;
	}
	public function http_request($ARRAY_TYPE	=	FALSE) // Correct this method for product usage
	{
		if($ARRAY_TYPE	==	FALSE)
		{
			$request 		=	'';
			$start			=	1;
			for($i = 2;$i< count($this->splited_url);$i++)
			{
				if($this->splited_url[$i] != 'index.php')
				{
					if($start == 1)
					{
						$request 		.=	$this->splited_url[$i];
					}
					else
					{
						$request 		.=	'/'.$this->splited_url[$i];
					}
					$start++;
				}
			}
			return $request;
		}
		else if($ARRAY_TYPE == TRUE)
		{
			$request			=	array();
			for($i = 2;$i< count($this->splited_url);$i++)
			{
				if(!in_array($this->splited_url[$i],array('index.php','')))
				{
					array_push($request,$this->splited_url[$i]);
				}
				else if($this->splited_url[$i] == '')
				{
					array_push($request,'index');
				}
			}
			return $request;
		}
	}
	public function controller()
	{
		return $this->controller;
	}
	public function method()
	{
		return $this->method;
	}
	public function parameters($startFromIndex= 0)
	{
		if($startFromIndex != 0 && is_numeric($startFromIndex))
		{
			$startCopy	=	false;
			$index		=	0;
			$newArray	=	array();
			foreach($this->parameters as $p)
			{
				if($index == $startFromIndex)
				{
					$startCopy = TRUE;
				}
				if($startCopy == true)
				{
					$newArray[]	=	$p;
				}
				$index++;
			}
			return $newArray;
		}
		else
		{
			return $this->parameters;
		}
	}
	public function site_name()
	{
		return $this->site_name;
	}
	public function base_url()
	{
		if (isset($_SERVER['HTTP_HOST']))
		{
			$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			$base_url .= '://'. $_SERVER['HTTP_HOST'];
			$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
		}

		else
		{
			$base_url = 'http://localhost/';
		}
		// Lorsque le fichier de reécriture est présent, supprimer "index.php".
		return $this->rewrite	== true ? $base_url : $base_url.'index.php/';
	}
	public function main_url()
	{
		if (isset($_SERVER['HTTP_HOST']))
		{
			$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			$base_url .= '://'. $_SERVER['HTTP_HOST'];
			$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
		}

		else
		{
			$base_url = 'http://localhost/';
		}
		return $base_url;
	}
	public function site_url($uri = '')
	{
		if ($uri == '')
		{
			return $this->base_url().$this->http_request();
		}
		elseif(is_string($uri))
		{
			if(preg_match('#^http?://#i',$uri))
			{
				return $uri;
			}
			return $this->base_url().$uri;
		}
		elseif(is_array($uri))
		{
			$complete	=	$this->array2Url($uri);
			return $this->base_url().$complete;
		}		
	}
	public function array2Url($array)
	{
		if(is_array($array) && $array)
		{
			$complete		=	'';
			$start			=	1;
			foreach($array as $u)
			{
				if($start == 1)
				{
					$complete	.=$u;
				}
				else
				{
					$complete	.='/'.$u;
				}
				$start++;
			}
			return $complete;
		}
		return false;
	}
	public function index_page()
	{
		return $this->instance->url->base_url();
	}
	public function redirect($uri,$method	=	'location')
	{
		if(is_string($uri))
		{
			if ( ! preg_match('#^https?://#i', $uri))
			{
				$url	=	$this->site_url($uri);
			}
			else
			{
				$url	=	$this->site_url($uri);
			}
		}
		else if(is_array($uri))
		{
			if ( ! preg_match('#^https?://#i', $this->site_url($uri)))
			{
				$url	=	$this->site_url($uri);
			}
			$url	=	$this->site_url($uri);
		}
		
		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$url);
				break;
			default			: header("Location: ".$url, TRUE);
				break;
		}
		exit;
		die();
	}
	public function img_url($img)
	{
		return $this->main_url().'tendoo_assets/img/'.$img;
	}
	public function segment($segment) // unused
	{
		var_dump($this->method);
	}
	public function request_uri()
	{
		return $this->request_uri;
	}
	public function font_url($font)
	{
		return $this->main_url().'tendoo_assets/font/'.$font;
	}
	public function get_controller_url()
	{
		$this->instance	=	get_instance();
		$details	=	$this->http_request(TRUE);
		if(array_key_exists(0,$details))
		{
			$controller	=	$this->instance->tendoo->getPage();
			if(is_array($controller))
			{
				return $this->site_url(array($controller[0]['PAGE_CNAME']));
			}
			return $controller;
		}
	}
}