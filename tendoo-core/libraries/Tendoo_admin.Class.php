<?php
class Tendoo_admin extends Libraries
{
	protected $getpages;
	private $heritedObj					=	array(); // 0.9.7
	public function __construct()
	{
		parent::__construct();
		__extends($this);
		$this->instance					=	get_instance();
	}
/**********************************************************************************************************************
												Controlers Methods
**********************************************************************************************************************/
	private $reservedControllers			=	array('admin','login','logoff','install','account','error','registration','tendoo_index');
	public function countPages()
	{
		$query	=	$this->db->get('tendoo_controllers');
		return $query->num_rows();
	}
	public function get_pages($e= '')
	{
		return $this->tendoo->getPage($e);
	}
	public function controller($name,$cname,$mod,$title,$description,$main,$obj = 'create',$id = '',$visible	=	'TRUE',$childOf= 'none',$page_link	=	'',$keywords = '')
	{
		if(in_array($cname,$this->reservedControllers)): return 'cantUserReservedCNames'; endif; // ne peut utiliser les cname reservés.
		if($childOf == strtolower($cname)) : return 'cantHeritFromItSelf' ;endif; // Ne peut être sous menu de lui même
		$currentPosition=	$childOf;
		if($main == 'TRUE' && $childOf != 'none'):return 'cantSetChildAsMain';endif; // Il ne faut pas définir un sous menu comme page principale
		$this		->db->select('*')
					->from('tendoo_controllers');
		$query		=	$this->db->get();
		
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $q)
			{
				if(strtolower($q['PAGE_CNAME'])	==	strtolower($cname) && $obj == 'create')
				{
					return 'c_name_already_found';
				}
				if(strtolower($q['PAGE_NAMES']) == strtolower($name) && $obj == 'create')
				{
					return 'name_already_found';
				}
				if($q['PAGE_MAIN'] == 'TRUE' && $main == 'TRUE')
				{
					if($main == 'TRUE' && $childOf == 'none')
					{
						$e['PAGE_MAIN']	=	'FALSE';
						$this 	->db->where('ID',$q['ID'])
										->update('tendoo_controllers',$e);
					}
				}
			}
		}
		$e['PAGE_CNAME']		=	strtolower($cname);
		$e['PAGE_NAMES']		=	strtolower($name);
		$e['PAGE_TITLE']		=	$title;
		$e['PAGE_DESCRIPTION']	=	$description;
		$e['PAGE_MAIN']			=	$query->num_rows > 0 ? $main == 'TRUE' && $childOf != 'none' ? 'FALSE' : $main : 'TRUE'; // Les sous menu ne devrait pas intervenir en tant que principale.
		$e['PAGE_MODULES']		=	$mod; // SI le controleur doit rediriger vers une page, alors on enregistre la page sinon on enregistre le module.
		$e['PAGE_VISIBLE']		=	$visible;
		$e['PAGE_PARENT']		=	$childOf == $name ? 'none' : $childOf;
		$e['PAGE_LINK']			=	$page_link;
		$e['PAGE_KEYWORDS']		=	$keywords;
		// var_dump($e);
		// Nous créons plus les positions via l'interface PHP, mais directement depuis javaScript
		if($obj == 'create')
		{
			if($this->db->insert('tendoo_controllers',$e))
			{
				$query			=	$this->db->where('PAGE_MAIN','TRUE')->get('tendoo_controllers');
				if($query->num_rows == 0): 		
					return "no_main_controller_created";
				endif;
					return 'controler_created';
			}
		}
		return 'error-occured';
	}
	public function getChildren($child,$compress = FALSE)
	{
		if(is_array($child))
		{
			foreach($child as $g)
			{
				if($compress == FALSE)
				{
				?>
				<li class="dd-item" controllers c_id="<?php echo $g['ID'];?>" c_name="<?php echo $g['PAGE_NAMES'];?>" c_cname="<?php echo $g['PAGE_CNAME'];?>" c_title="<?php echo $g['PAGE_TITLE'];?>">
					<input type="hidden" controller_title name="controller[title][]" value="<?php echo $g['PAGE_TITLE'];?>">
					<input type="hidden" controller_description name="controller[description][]" value="<?php echo $g['PAGE_DESCRIPTION'];?>">
					<input type="hidden" controller_main name="controller[main][]" value="<?php echo $g['PAGE_MAIN'];?>">
					<input type="hidden" controller_module name="controller[module][]" value="<?php echo is_array($g['PAGE_MODULES']) ? $g['PAGE_MODULES'][ 'namespace' ] : $g['PAGE_MODULES'];?>">
					<input type="hidden" controller_parent name="controller[parent][]" value="<?php echo $g['PAGE_PARENT'];?>">
					<input type="hidden" controller_name name="controller[name][]" value="<?php echo $g['PAGE_NAMES'];?>">
					<input type="hidden" controller_cname name="controller[cname][]" value="<?php echo $g['PAGE_CNAME'];?>">
					<input type="hidden" controller_keywords name="controller[keywords][]" value="<?php echo $g['PAGE_KEYWORDS'];?>">
					<input type="hidden" controller_link name="controller[link][]" value="<?php echo $g['PAGE_LINK'];?>">
					<input type="hidden" controller_visible name="controller[visible][]" value="<?php echo $g['PAGE_VISIBLE'];?>">
					<input type="hidden" controller_id name="controller[id][]" value="<?php echo $g['ID'];?>">
					<div class="dd-handle"><?php echo $g['PAGE_NAMES'];?>
						<span id="controller_priority_status">
						<?php
						if($g['PAGE_MAIN'] == 'TRUE')
						{
							?>
							- <small>Index</small>
							<?php
						}
						?>
						</span>
						<span class="controller_name">
						</span>
						<div style="float:right">
							<button class="edit_controller dd-nodrag btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i></button>
							<button class="remove_controller dd-nodrag btn btn-warning btn-sm" type="button"><i class="fa fa-times"></i></button>												
						</div>
					</div>
					<ol class="dd-list">
						<?php
						$this->getChildren($g['PAGE_CHILDS']);
						?>
					</ol>
				</li>
				<?php
				}
				else
				{
					?><li class="dd-item" controllers c_id="<?php echo $g['ID'];?>" c_name="<?php echo $g['PAGE_NAMES'];?>" c_cname="<?php echo $g['PAGE_CNAME'];?>" c_title="<?php echo $g['PAGE_TITLE'];?>"><input type="hidden" controller_title name="controller[title][]" value="<?php echo $g['PAGE_TITLE'];?>"><input type="hidden" controller_description name="controller[description][]" value="<?php echo $g['PAGE_DESCRIPTION'];?>"><input type="hidden" controller_main name="controller[main][]" value="<?php echo $g['PAGE_MAIN'];?>"><input type="hidden" controller_module name="controller[module][]" value="<?php echo is_array($g['PAGE_MODULES']) ? $g['PAGE_MODULES']['namespace'] : $g['PAGE_MODULES'];?>"><input type="hidden" controller_parent name="controller[parent][]" value="<?php echo $g['PAGE_PARENT'];?>"><input type="hidden" controller_name name="controller[name][]" value="<?php echo $g['PAGE_NAMES'];?>"><input type="hidden" controller_cname name="controller[cname][]" value="<?php echo $g['PAGE_CNAME'];?>"><input type="hidden" controller_keywords name="controller[keywords][]" value="<?php echo $g['PAGE_KEYWORDS'];?>"><input type="hidden" controller_link name="controller[link][]" value="<?php echo $g['PAGE_LINK'];?>"><input type="hidden" controller_visible name="controller[visible][]" value="<?php echo $g['PAGE_VISIBLE'];?>"><input type="hidden" controller_id name="controller[id][]" value="<?php echo $g['ID'];?>"><div class="dd-handle"><?php echo $g['PAGE_NAMES'];?><span id="controller_priority_status"><?php
					if($g['PAGE_MAIN'] == 'TRUE')
					{
						?>- <small>Index</small><?php
					}
					?></span><span class="controller_name"></span><div style="float:right"><button class="edit_controller dd-nodrag btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i></button> <button class="remove_controller dd-nodrag btn btn-warning btn-sm" type="button"><i class="fa fa-times"></i></button></div></div><ol class="dd-list"><?php 
					$this->getChildren($g['PAGE_CHILDS'],TRUE); ?></ol></li><?php
				}
				
			}
		}
	}
	public function get_controller($id)
	{
		$query	=	$this->db->where('ID',$id)->get('tendoo_controllers');
		return $query->result_array();
	}
	public function createControllers($controller)
	{
		if(is_array($controller))
		{
			$restructured_controllers	=	array();
			$keys	=	array_keys($controller);
			foreach($keys as $v)
			{
				$id		=	0;
				foreach($controller[$v] as $s)
				{
					$restructured_controllers[$id][$v]	=	$controller[$v][$id];
					$id++;
				}
			}
			// Raccourcis
			$s	=	$restructured_controllers;
			// var_dump(count($s));
			// Supprimer les controlleurs déjà existant
			$this->db->where('ID >',0)->delete('tendoo_controllers');
			// Création des nouveaux controlleurs
			if($s)
			{
				$arraynotice	=	array();
				foreach($s as $_s)
				{
					// var_dump($_s);
					$arraynotice[]	=	$this->controller(
						$name	=	$_s['name'],
						$cname	=	$_s['cname'],
						$mod	=	$_s['module'],
						$title	=	$_s['title'],
						$description	=	$_s['description'],
						$main	=	$_s['main'] == '' ? 'FALSE' : $_s['main'],
						$obj 	= 'create',
						$id 	= '',
						$visible	=	$_s['visible'],
						$childOf	= 	$_s['parent'],
						$page_link	=	$_s['link'],
						$keywords 	= 	$_s['keywords']
					);
				}
				// Création terminé
				return $arraynotice;
			}
		}
		return false;
	}
/**********************************************************************************************************************
												End Controlers Methods
**********************************************************************************************************************/
/**********************************************************************************************************************
												File Manager Methods
**********************************************************************************************************************/
	private $system_dir	=	array('tendoo-themes/','tendoo-core/','tendoo-installer/','tendoo-modules/','tendoo-assets/');
	public function drop($source)
	{
		if(in_array($source,$this->system_dir))
		{
			return false;
		}
		if(is_dir($source))
		{
			if($open	=	opendir($source))
			{
				while(($content	=	readdir($open)) !== FALSE)
				{
					if(is_file($source.'/'.$content))
					{
						unlink($source.'/'.$content);
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						$this->drop($source.'/'.$content);
					}
				}
				closedir($open);
			}
			rmdir($source);
		}
		return true;
	}
	public function extractor($source,$destination,$dir_limit = 10)
	{
		if(!is_dir($destination))
		{
			mkdir($destination);
		}
		if(is_file($source))
		{
			copy($source,$destination);
			unlink($source);
		}
		if(is_dir($source))
		{
			if($open	=	opendir($source))
			{
				while(($content	=	readdir($open)) !== FALSE)
				{
					if(is_file($source.'/'.$content))
					{
						copy($source.'/'.$content,$destination.'/'.$content);
						unlink($source.'/'.$content);
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						if($dir_limit > 0)
						{
							if(!is_dir($destination.'/'.$content))
							{
								mkdir($destination.'/'.$content);
							}
							$this->extractor($source.'/'.$content,$destination.'/'.$content,$dir_limit-1);
						}
						else
						{
							$this->drop($source.'/'.$content);
						}
					}
				}
				closedir($open);
			}
		}
		if(!rmdir($source))
		{
			$this->drop($source);
		}
	}
	public function copy($source,$destination,$dir_limit = 10)
	{
		if(!is_dir($destination))
		{
			mkdir($destination);
		}
		if(is_dir($source))
		{
			if($open	=	opendir($source))
			{
				while(($content	=	readdir($open)) !== FALSE)
				{
					if(is_file($source.'/'.$content))
					{
						copy($source.'/'.$content,$destination.'/'.$content);
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						if($dir_limit > 0)
						{
							if(!is_dir($destination.'/'.$content))
							{
								mkdir($destination.'/'.$content);
							}
							$this->copy($source.'/'.$content,$destination.'/'.$content,$dir_limit-1);
						}
					}
				}
				closedir($open);
			}
		}
	}
/**********************************************************************************************************************
												End File Methods
**********************************************************************************************************************/
/**********************************************************************************************************************
												Privilege Methods
**********************************************************************************************************************/
	public function get_global_info()
	{
		// About Controllers;
		$this	->db->select('*')
				->from('tendoo_controllers');
		$query = $this->db->get();
		// About Themes
		$themes		=	get_themes( 'filter_active' );
		// Array Error Contener
		$array	=	array();
		if( ! $themes )
		{
			$array[]	= 'no_theme_selected';
		}
		if($query->num_rows == 0)
		{
			$array[]	= 'no-controller-set';
		}
		else
		{
			foreach($query->result() as $r)
			{
				$result[]	=	$r->PAGE_MAIN;
			}
			if(!in_array('TRUE',$result))
			{
				$array[]	=	'no_main_page_set';
			}
		}
		return $array;					
	}
/**********************************************************************************************************************
												End Privilege Methods
**********************************************************************************************************************/
/**********************************************************************************************************************
												System Methods
**********************************************************************************************************************/
	private $sys_not_array	=	array();
	public function system_not($title,$content,$link,$date,$thumb)
	{
		$this->sys_not_array[]	=	array(
			'TITLE'				=>	$title,
			'CONTENT'			=>	$content,
			'LINK'				=>	$link,
			'DATE'				=>	$date,
			'THUMB'				=>	$thumb
		);
	}
	public function get_sys_not()
	{
		return $this->sys_not_array;
	}
/**********************************************************************************************************************
												End System Methods
**********************************************************************************************************************/
/**********************************************************************************************************************
												Install Methods
**********************************************************************************************************************/
	private $leftMenuExtentionBefore 	= '';
	private $leftMenuExtentionAfter 	= '';
	public function encrypted_name( $prefix = null )
	{
		$alphabet	=	array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
		$index		=	count($alphabet)-1;
		$prefixing	=	( $prefix != null ) ? $prefix . '_' : $prefix ;
		return 'app_' . $prefixing .rand(0,9).date('Y').date('m').date('d').date('H').date('i').date('s').$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)].$alphabet[rand(0,$index)];
	}
	public function _action_keys_is_allowed( $actions_keys )
	{
		foreach( $actions_keys as $key ){
			if( !in_array( $key , array( 'action' , 'action_name' , 'action_description' , 'mod_namespace' ) ) ){
				return false;
			}
		}
		return true;
	}
	public function _install_app( $source )
	{
		set_core_mode( 'maintenance' );
		// Setup Upload Class
		$config['upload_path'] 			= 	INSTALLER_DIR;
		$config['allowed_types'] 		= 	'zip';
		$config['max_size']				= 	'8000';
		$config['encrypt_name']			=	TRUE;
		$this->load->library('upload',$config);
		// 
		if($this->upload->do_upload($source))
		{
			$appFile	=	$this->_unzip_file( $file_unzip_location = INSTALLER_DIR . $this->upload->file_name );
			// If config.php exists, that mean we're installing a module app.
			if( file_exists( $file = INSTALLER_DIR . $appFile['temp_dir'] . '/config.php' ) ){
				include_once( $file );
				foreach( get_modules( 'from_maintenance_mode' ) as $namespace => $app_datas ){
					if( $app_datas[ 'compatible' ] == get( 'core_id' ) ){
						$module 		=	get_modules( 'filter_namespace' , $namespace );
						if( ! $module ){ // If module doesnt exist
							$this->copy( substr( $file_unzip_location , 0 , -4 ) , MODULES_DIR . $this->encrypted_name( $namespace ) );
							$this->drop( substr( $file_unzip_location , 0 , -4 ) );
							// Executing Sql queries
							if( is_array( $queries =	riake( 'sql_queries' , $app_datas ) ) ){
								foreach( $queries as $sql_line ){
									get_db()->query( $sql_line );
								}
							}
							// Registering Actions
							if( is_array( $actions	=	riake ( 'declared_actions' , $app_datas ) ) ){
								foreach( $actions  as $_action ){
									if( $this->_action_keys_is_allowed( array_keys( $_action ) ) ){
										foreach( $_action as $key => $value ){
											$$key	=	$value;
										}
										$this->createModuleAction($mod_namespace,$action,$action_name,$action_description);
									}
								}
							}
							set_core_mode( 'normal' );
							return 'module-has-been-installed';
							
						} else if (  $module[ 'version' ] < $app_datas[ 'version' ] ){
							// Updating
							$this->copy( substr( $file_unzip_location , 0 , -4 ) , $module[ 'uri_path' ] );
							// Drop Source
							$this->drop( substr( $file_unzip_location , 0 , -4 ) );
							set_core_mode( 'normal' );
							return 'module_updated';
						} else {
							// substr( $file_unzip_location , 0 , -4 ) coz $file_unzip_location is a uri path to a zip file, we just remove extension.
							$this->drop( substr( $file_unzip_location , 0 , -4 ) );
							set_core_mode( 'normal' );
							return 'module-already-exists';
						}
					} else {
						$this->drop( substr( $file_unzip_location , 0 , -4 ) );
						set_core_mode( 'normal' );
						return 'NoCompatibleModule';
					}
				}
			}
			// Checking if app is a theme
			if( file_exists( $file = INSTALLER_DIR . $appFile['temp_dir'] . '/theme-config.php' ) ){
				include_once( $file );
				foreach( get_themes( 'from_maintenance_mode' ) as $namespace => $app_datas ){
					if( $app_datas[ 'compatible' ] == get( 'core_id' ) ){
						$theme 		=	get_themes( 'filter_namespace' , $namespace );
						if( ! $theme ){ // If module doesnt exist
							$this->copy( substr( $file_unzip_location , 0 , -4 ) , THEMES_DIR . $this->encrypted_name( $namespace ) );
							$this->drop( substr( $file_unzip_location , 0 , -4 ) );
							// Executing Sql queries
							if( is_array( $queries =	riake( 'sql_queries' , $app_datas ) ) ){
								foreach( $queries as $sql_line ){
									get_db()->query( $sql_line );
								}
							}
							set_core_mode( 'normal' );
							return 'theme_installed';
							
						} else if (  $module[ 'version' ] < $app_datas[ 'version' ] ){
							// Updating
							$this->copy( substr( $file_unzip_location , 0 , -4 ) , $module[ 'uri_path' ] );
							// Drop Source
							$this->drop( substr( $file_unzip_location , 0 , -4 ) );
							set_core_mode( 'normal' );
							return 'theme_updated';
						} else {
							// substr( $file_unzip_location , 0 , -4 ) coz $file_unzip_location is a uri path to a zip file, we just remove extension.
							$this->drop( substr( $file_unzip_location , 0 , -4 ) );
							set_core_mode( 'normal' );
							return 'theme_alreadyExist';
						}
					} else {
						$this->drop( substr( $file_unzip_location , 0 , -4 ) );
						set_core_mode( 'normal' );
						return 'noCompatibleTheme';
					}
				}
			}
			set_core_mode( 'normal' );
			return 'invalid-app';
		}
		set_core_mode( 'normal' );
		return 'error-occured';
	}
	function _unzip_file($zip)
	{
		$myZip						=	new ZipArchive;
		$myZip->open($zip);
		if($myZip->getStatusString() == 'No error')
		{
			$installDir				=	INSTALLER_DIR;
			$temporaryDir			=	explode('.',$zip);
			$temporaryDir			=	explode('/',$temporaryDir[0]);
			$temporaryDir			=	$temporaryDir[1];
			if( ! is_dir( $installDir . $temporaryDir ) )
			{
				mkdir( $installDir . $temporaryDir );
			}
			if($myZip->extractTo( $installDir . $temporaryDir ) )
			{
				// $notice	=	 is_file( $installDir . $temporaryDir . '/notice.html' ) ? fopen( $installDir . $temporaryDir . '/notice.html','r') : '';
				$myZip->close();
				unlink($zip);
				return array(
					'temp_dir'		=> $temporaryDir,
					'notice'		=> '' // fread($notice,filesize($installDir . $temporaryDir . '/notice.html')) Depreacted
				);
			}
			else
			{
				$myZip->close();
				unlink($zip);
				$this->drop($installDir.$temporaryDir);
				return 'error-occured';
			}
			$myZip->close();
		}
		$myZip->close();
		if(is_file($zip))
		{
			unlink($zip);
		}
		return 'CorruptedArchive';
	}
}