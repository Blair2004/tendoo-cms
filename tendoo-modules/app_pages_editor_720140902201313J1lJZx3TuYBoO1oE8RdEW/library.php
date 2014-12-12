<?php
class page_library extends Libraries
{
	function __construct()
	{
		parent::__construct();
		__extends($this);
		$this->module 	=	get_modules( 'filter_namespace' , 'pages_editor' );
		$this->_before_boot();
	}
	function set_page( $title , $content , $description , $child_of , $controller_cname , $process_type = 'create' , $status = 0 , $edit_id = 0 )
	{
		$cnames	=	array();
		if( is_array( $array = $this->get_available_controllers( $edit_id ) ) ){
			foreach( $array as $_array ){
				$cnames[] 	=	return_if_array_key_exists( 'PAGE_CNAME' , $_array );
			}
		}
		// If Controller is not valid set it to 0 (unset)
		if( ! in_array( $controller_cname , $cnames ) ){
			$controller_cname =	'';
		}
		if( $process_type == 'edit' ){
			$child_of	=	( $child_of == $edit_id ) ? 0 : $child_of;
		}
		// if page doesnt exists
		$pre_query	=	$this->db->get( 'tendoo_pages' );
		$pre_result	=	$pre_query->result_array();
		$length_to_check	=	strlen( $title );
		$current_index		=	0;
		foreach( $pre_result as $_page){
			if( $process_type == 'edit' ){
				if( $_page[ 'ID' ] != $edit_id ){
					if( substr( $_page[ 'TITLE' ], 0 , $length_to_check ) == $title ){
						$current_index++;
					}
				}
			}
			else if( $process_type == 'create' ) {
				if( substr( $_page[ 'TITLE' ], 0 , $length_to_check ) == $title ){
					$current_index++;
				}
			}
		}
		if( $current_index > 0 ){
			$title		=	$title . ' (' . $current_index . ')';
		}
		/**
		*	Si la page existe, ou lui ajoute un nouvel identifiant
		**/
		$date		=	$this->date->datetime();
		$new_file = $this->_file( 'create' , $content );			
		$final		=	array(
			'TITLE'					=>		$title,
			'TITLE_URL'				=>		$this->string->urilizeText( $title ),
			'FILE_NAME'				=>		$new_file,
			'CONTROLLER_REF_CNAME'	=>		$controller_cname,
			'EDITION_DATE'			=>		$date,
			'AUTHOR'				=>		current_user( 'ID' ),
			'STATUS'				=>		(int) $status,
			'DESCRIPTION'			=>		$description,
			'PAGE_PARENT'			=>		$child_of			
		);
		if( $process_type == 'create' ){
			$final[ 'DATE' ]		=	 	$date;
			$this->db->insert( 'tendoo_pages' , $final );
			// Retreive page id
			$query	=	$this->db->where( 'TITLE' , $title )->get( 'tendoo_pages' );
			$result = $query->result_array();
			if( $query ){
				return $result[0];
			}
		} 
		else if( $process_type == 'edit' ){
			$this->db->where( 'ID' , $edit_id )->update( 'tendoo_pages' , $final );
			return 'successfully_updated';
		}
		return 'error-occured';
	}
	/**
	 * Create or Read Specific file and return namespace or content
	 *
	 * @var action
	 * @var content / namespace
	 */
	private function _file( $action = 'create' , $content = '')
	{
		if( $action == 'create' ){
			$Core 			=	get_instance();
			$stamp			=	strtotime( $Core->date->datetime() );
			$encrypted_name	=	$stamp . rand( 0 , 9 ) . rand( 0 , 9 ) . rand( 0 , 9 ) . rand( 0 , 9 ) . '.txt';
			file_put_contents( $this->module['uri_path'] . 'created_pages/' . $encrypted_name , $content );
			return $encrypted_name;
		}
		else if ( $action == 'get' ){
			if( is_file( $this->module['uri_path'] . 'created_pages/' . $content ) ){
				return file_get_contents( $this->module['uri_path'] . 'created_pages/' . $content );
			}
			return false;
		}
		else if ( $action == 'delete' ){
			if( is_file( $this->module['uri_path'] . 'created_pages/' . $content ) ){
				return unlink( $this->module['uri_path'] . 'created_pages/' . $content );
			}
			return false;
		}
	}
	/**
	 * Before class really boot, we do check somethings
	 *
	 * _before_boot()
	 *
	 */
	private function _before_boot()
	{
		if( !is_dir( $this->module['uri_path'] . '/created_pages' ) ){
			mkdir( $this->module['uri_path'] . '/created_pages' );
		}
	}
	/**
	 * Retreive each page created 
	 *
	 * get_pages
	 *
	 */
	function get_pages( $process = 'all_available' , $start_or_id = null , $end = null )
	{
		if( $process  == 'all_available' ) // && is_numeric( $start_or_id ) && is_numeric( $end )
		{
		 $query		=  $this->db->get( 'tendoo_pages' );
		 $result	=	$query->result_array();
		 foreach( $result as &$_result ){
			 // If file exist
			$_result[ 'FILE_CONTENT' ] = '';
			if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
				// add File content to each field
				if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
					$_result[ 'FILE_CONTENT' ] 	= $file_content;
					$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
				}
			}
		 }
		 // return result
		 return $result;
		} 
		else if( $process  == 'all_but_not' && is_numeric( $start_or_id ) )
		{
		 $query		=  $this->db->where( 'ID !=' , $start_or_id )->get( 'tendoo_pages' );
		 $result	=	$query->result_array();
		 foreach( $result as &$_result ){
			 // If file exist
			$_result[ 'FILE_CONTENT' ] = '';
			if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
				// add File content to each field
				if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
					$_result[ 'FILE_CONTENT' ] 	= $file_content;
					$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
				}
			}
		 }
		 // return result
		 return $result;
		}
		else if( $process  == 'all_limited' && is_numeric( $start_or_id ) && is_numeric( $end ) )
		{
		 $query		=  $this->db->order_by( 'DATE' , 'desc' )->limit( $end , $start_or_id )->get( 'tendoo_pages' );
		 $result	=	$query->result_array();
		 foreach( $result as &$_result ){
			 // If file exist
			$_result[ 'FILE_CONTENT' ] = '';
			if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
				// add File content to each field
				if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
					$_result[ 'FILE_CONTENT' ] 	= $file_content;
					$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
				}
			}
		 }
		 // return result
		 return $result;
		}
		else if( $process  == 'filter_id' && is_numeric( $start_or_id ) )
		{
			 $query		=  $this->db->where( 'ID' , $start_or_id )->get( 'tendoo_pages' );
			 $result	=	$query->result_array();
			 foreach( $result as &$_result ){
				 // If file exist
				$_result[ 'FILE_CONTENT' ] = '';
				if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
					// add File content to each field
					if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
						$_result[ 'FILE_CONTENT' ] 	= $file_content;
						$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
					}
				}
			 }
			 // return result
			 return $result;
		}
		else if( $process  == 'filter_title_url' &&  $start_or_id != null )
		{
			 $query		=  $this->db->where( 'TITLE_URL' , $start_or_id )->get( 'tendoo_pages' );
			 $result	=	$query->result_array();
			 foreach( $result as &$_result ){
				 // If file exist
				$_result[ 'FILE_CONTENT' ] = '';
				if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
					// add File content to each field
					if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
						$_result[ 'FILE_CONTENT' ] 	= $file_content;
						$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
					}
				}
			 }
			 // return result
			 return $result;
		}
		else if( $process  == 'filter_title_url_active' &&  $start_or_id != null )
		{
			 $query		=  $this->db->where( 'STATUS' , 1 )->where( 'TITLE_URL' , $start_or_id )->get( 'tendoo_pages' );
			 $result	=	$query->result_array();
			 foreach( $result as &$_result ){
				 // If file exist
				$_result[ 'FILE_CONTENT' ] = '';
				if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
					// add File content to each field
					if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
						$_result[ 'FILE_CONTENT' ] 	= $file_content;
						$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
					}
				}
			 }
			 // return result
			 return $result;
		}
		else if( $process  == 'filter_parents_active' )
		{
			 $query		=  $this->db->where( 'STATUS' , 1 )->where( 'PAGE_PARENT' , 0 )->get( 'tendoo_pages' );
			 $result	=	$query->result_array();
			 foreach( $result as &$_result ){
				 // If file exist
				$_result[ 'FILE_CONTENT' ] = '';
				if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
					// add File content to each field
					if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
						$_result[ 'FILE_CONTENT' ] 	= $file_content;
						$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
						$_result[ 'CHILDS' ]		=	$this->get_pages( 'filter_childs_active' , $_result[ 'ID' ] );
					}
				}
			 }
			 // return result
			 return $result;
		}
		else if( $process  == 'filter_childs_active' && is_numeric( $start_or_id ) )
		{
			 $query		=  $this->db->where( 'STATUS' , 1 )->where( 'PAGE_PARENT' , $start_or_id )->get( 'tendoo_pages' );
			 $result	=	$query->result_array();
			 foreach( $result as &$_result ){
				 // If file exist
				$_result[ 'FILE_CONTENT' ] = '';
				if( return_if_array_key_exists( 'FILE_NAME' , $_result ) ){
					// add File content to each field
					if( $file_content	=	$this->_file( 'get' , $_result[ 'FILE_NAME' ] ) ){
						$_result[ 'FILE_CONTENT' ] 	= $file_content;
						$_result[ 'THREAD' ] 		=	$this->get_thread( $_result[ 'TITLE_URL' ] );
						$_result[ 'CHILDS' ]		=	$this->get_pages( 'filter_childs_active' , $_result[ 'ID' ] );
					}
				}
			 }
			 // return result
			 return $result;
		}
	}
	private function page_exists( $page_id )
	{
		$query	=	$this->db->where( 'ID' , $page_id )->get( 'tendoo_pages' );
		$result = 	$query->result_array();
		if( $result ){
			return $result;
		}
		return false;
	}
	function delete_page( $page_id )
	{
		if( $page	= $this->page_exists( $page_id ) )
		{
			$this->db->where( 'ID' , $page_id )->delete( 'tendoo_pages' );
			$this->_file( 'delete' , $page[0][ 'FILE_NAME' ] );
		}
	}	
	function get_available_controllers( $page_id = null )
	{
		$controllers	=	$this->tendoo->getControllersAttachedToModule( $this->module['namespace'] );
		if( is_array( $controllers ) ){
			$available	=	array();
			foreach( $controllers as $_controller ){
				if( ! $this->_controllers_is_busy( $_controller[ 'PAGE_CNAME' ] ) ){
					array_push( $available , $_controller );
				}
			}
			// Add Controller used by current edited page
			if( is_numeric( $page_id ) ){
				if( $page = $this->page_exists( $page_id ) ){
					$spe_controller	=	$this->tendoo->get_controllers( 'filter_cname' , $page[0][ 'CONTROLLER_REF_CNAME' ] );
					if( return_if_array_key_exists( 0 , $spe_controller ) ){
						$available[]	=	$spe_controller[0];
					}
				}
			}
			return $available;
		}
		return false;
	}
	private function _controllers_is_busy( $controller_cname )
	{
		$query	=	$this->db->where( 'CONTROLLER_REF_CNAME' , $controller_cname )->get( 'tendoo_pages' );
		$result	= 	$query->result_array();
		if( count( $result ) > 0 ){
			return true;
		}
		return false;
	}
	private function _get_page_as_parent( $filter = 'filter_title_url' , $title_or_id )
	{
		$query	=	$this->db->where( 'PAGE_PARENT' , 0 );
	}
	function get_page_attached_to_controller( $filter = 'none' )
	{
		$current_controller	=	get_core_vars( 'page' );
		if( $filter == 'filter_active' ){
			$this->db->where( 'STATUS' , 1 );
		}
		$query	=	$this->db->where( 'CONTROLLER_REF_CNAME' , $current_controller[0][ 'PAGE_CNAME' ] )->get( 'tendoo_pages' );
		return $query->result_array();
	}
	function get_controller_attached_to_page( $filter = 'filter_id' , $id_or_title_url )
	{
		if( $filter == 'filter_id' ){
			
		}
	}
	function get_static_page( $controller )
	{
		// Nous ajoutons automatiquement le parent comme possédant le cname du controller, qui vaut l'espace nom "index"
		if( is_array( $controller ) ){
			if( count( $controller ) > 0 ){
				if( $controller[0] != 'index' ){
					array_unshift( $controller , 'index' );
				}
			}
		}
		// On parcours l'URL de façon décroissante. Du dernier paamètre au premier, afin de controller la hierarchie entre les pages
		if( is_array( $controller ) ){
			$thread	=	array();
			for( $i =  0 ; $i < count( $controller ) ; $i++ ){
				// Vérifier si l'on se trouve à la racine
				$status = 404;
				if( $i == 0 ){
					// Nous considérons qu'il ny a aucun autre paramètre sur l'URL autre que le cname du controller, ce qui génère "index" sur la classe URL
					if( $controller[ $i ] == 'index' ){
						if( $page	=	$this->get_page_attached_to_controller( 'filter_active' ) ){
							$status = 202;
						}
					}
					// Juste après le cname du controller, nous avons une autre nom, nous effectuons une recherche dessus.
					else{
						if( $page 	=	$this->get_pages( 'filter_title_url_active' , $controller[ $i ] ) ){
							$status	=	202;
						}
					}
				}
				else{
					if( $page 	=	$this->get_pages( 'filter_title_url_active' , $controller[ $i ] ) ){
						if( $controller[ $i - 1 ] != 'index' ){
							$parent	=	return_if_array_key_exists( 0 , $this->get_pages( 'filter_title_url_active' , $controller[ $i - 1 ] ) );
						}
						else{
							$parent	=	return_if_array_key_exists( 0 , $this->get_page_attached_to_controller( 'filter_active' ) );
						}
						// L'héritage s'accompli. On compare l'identifiant du parent réel de la page actuelle, à identifiant du parent sur l'URL
						if( ( $page[0][ 'PAGE_PARENT' ] == return_if_array_key_exists( 'ID' , $parent ) ) != false )
						{
							$status	=	202;
						}
					}
				}
				// Si la page d'actuelle n'existe pas, il ne faut plus continuer.
				//var_dump( $status );
				//var_dump( $controller );
				if( $status == 404 ){
					return $status;
				}
				$thread[] = $status;
				// S'il y a des donnée à traiter, nous supposons qu'il y a des sous page, dans le cas contraire, on affiche la dernière page
				if( ! isset( $controller[ $i + 1 ] ) ){
					if( $status == 202 && $thread[ count( $thread ) - 1 ] == 202){ // Si la page actuelle page existe et le dernier parent
						return $this->get_pages( 'filter_id' , $page[0][ 'ID' ] );
					} 
					else{
						return 404;
					}
				}
			}
		}
		return false;
	}
	function get_thread( $page_title )
	{
		$query	=	$this->db->where( 'TITLE_URL' , $page_title )->get( 'tendoo_pages' );
		if( $page = $query->result_array() ){
			$thread	=	array($page[0][ 'TITLE_URL' ]);
			$secure	=	0;
			while( true ){
				$parent_ref_id	=	$page[0][ 'PAGE_PARENT' ];
				if( $parent	= $this->page_exists( $parent_ref_id ) ){
					array_unshift( $thread , $parent[0][ 'TITLE_URL' ] );
					$page		=	$parent;
				}
				// Nous sommes arrivé au parent, car lui il n'a pas de parent
				// Au lieu d'utiliser title_url, nous utiliserons le cname auquel le parent est attaché
				else{
					if( is_array( $controller	=	$this->tendoo->get_controllers( 'filter_cname' , $page[0][ 'CONTROLLER_REF_CNAME' ] ) ) ){
						array_shift( $thread );
						array_unshift( $thread , $controller[0][ 'PAGE_CNAME' ] );
					}
					// Le controller n'est pas définit pour le parent, la famille est indisponible
					else{
						$thread		=	'Hiérarchie incorrecte. La parent initial n\'est attaché à aucun contrôleur';
					}
					break;
				}
				if( $secure == 100){
					break;
				}
				$secure++;
			}
			return $thread;
		}
	}
	function get_page_hierarchy()
	{
		
	}
}