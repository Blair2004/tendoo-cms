<?php
class post_type extends CI_model
{
	function __construct()
	{
		$this->version			=	'1.0';
		parent::__construct();
		$this->events->add_action( 'after_app_init' , array( $this , 'loader' ) );
		$this->events->add_action( 'tendoo_settings_tables' , function(){
			Modules::enable( 'post_type' );
		});
	}
	
	function loader()
	{
		if( Modules::is_active( 'aauth' ) )
		{
			if( ! $this->__is_installed() )
			{
				$this->__install_tables();
			}
			$this->load->language( 'blog_lang' );
			// including CustomQuery.php library file
			include_once( LIBPATH . '/CustomQuery.php' );
			
			$this->events->add_action( 'load_dashboard' , array( $this , '__register_page' ) );
			// include_once( LIBPATH . '/PostType.php' ); can be loaded using $this->load
			
			$this->events->do_action( 'load_post_types' );
		}
		else
		{
			$this->events->add_filter( 'ui_notices' , function( $notices ){
				return $notices[]		=	array(
					'msg'		=>		__( 'Aauth Module is required, please install or enable it' ),
					'type'	=>		'warning',
					'icon'	=>		'users',
					'href'	=>		site_url( array( 'dashboard' , 'modules' ) )
				);
			});
		}
	}
	private function __is_installed()
	{
		if( $this->options->get( 'post_type' ) != $this->version )
		{
			return false;
		}
		return true;
	}
	private function __install_tables()
	{
		$this->options->set( 'post_type' , $this->version );
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`NAMESPACE` varchar(255) NOT NULL,
			`TITLE` varchar(255),
			`CONTENT` text NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`AUTHOR` varchar(255) NOT NULL,
			`STATUS` int(11) NOT NULL,
			`PARENT_REF_ID` int(11) NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if( ! $this->db->query($sql) )
		{
			return false;
		};
		/* CREATE tendoo_query_attachment */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query_meta' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`QUERY_REF_ID` int(11) NOT NULL,
			`KEY` varchar(255),
			`VALUE` text NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_taxonomies */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query_taxonomies' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`NAMESPACE` varchar(255) NOT NULL,
			`QUERY_NAMESPACE` varchar(200) NOT NULL,
			`TITLE` varchar(255),
			`CONTENT` text NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`PARENT_REF_ID` int(11) NOT NULL,
			`AUTHOR` varchar(255) NOT NULL,
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_taxonomies */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `' . $this->db->dbprefix( 'query_taxonomies_relationships' ) . '` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`TAXONOMY_REF_ID` int(11) NOT NULL,
			`QUERY_REF_ID` int(11),
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
		/* CREATE tendoo_query_comments */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `'. $this->db->dbprefix( 'query_comments' ) .'` (
			`ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
			`AUTHOR` int(11) NOT NULL,
			`COMMENTS` text,
			`QUERY_NAMESPACE` varchar(200),
			`CUSTOM_QUERY_ID` int(11) NOT NULL,
			`STATUS` int(11) NOT NULL,
			`DATE` datetime NOT NULL,
			`EDITED` datetime NOT NULL,
			`REPLY_TO` int(11) NOT NULL,
			`AUTHOR_EMAIL` varchar(200),
			`AUTHOR_NAME` varchar(200),
		PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->db->query($sql))
		{
			return false;
		};
	}
	function __register_page()
	{
		$this->gui->register_page( 'posttype' , array( $this , '__posttype_controller' ) );
	}
	public function __posttype_controller( $namespace , $page = 'list' , $id = 0 , $taxonomy_arg1 = 'list' , $taxonomy_arg2 = 0 )
	{
		if( $this->current_posttype	= riake( $namespace , $this->config->item( 'posttypes' ) ) )
		{
			$data[ 'current_posttype' ]	= $this->current_posttype;
			$data[ 'post_namespace' ]		= $namespace;
						
			if( $page === 'list' )
			{
				$id			=	$id 	=== 0 ? 1 : $id;
				$post_limit	=	20;
				$post_nbr	=	count( $this->current_posttype->get() );
				
				
				$pagination	=	pagination_helper( 
					$post_limit , 
					$post_nbr , 
					$id , 
					site_url( array( 'dashboard' , 'posttype' , $namespace , 'list' ) ),
					site_url( array( 'error' , 'code' , 'page-404' ) ) 
				);
				
				$this->config->set_item( 'pagination_data' , $pagination );
				
				$post			=	$this->current_posttype->get( array(
					'limit'		=>	array( 
						'start' 	=> riake( 'start' , $pagination ),
						'end' 		=> riake( 'end' , $pagination ) 
					)
				) );
				
				$data[ 'post' ]				= $post;				
				$data[ 'post_list_label' ]	= $this->current_posttype->posts_list_label;
				
				$this->gui->set_title( $this->current_posttype->posts_list_label );
				$this->load->view( '../modules/post_type/views/list' , $data , false );
			}
			else if( $page === 'new' )
			{
				$data[ 'post_namespace' ] 	=	$namespace;
				$data[ 'new_post_label' ] 	=	$this->current_posttype->new_post_label;
				
				$this->load->library( 'form_validation' );
				$this->form_validation->set_rules( 'post_title' , __( 'Post title' ) );
				
				if( $this->form_validation->run() )
				{
					$return		=	$this->current_posttype->set( 
						$this->input->post( 'post_title' ) , 
						$this->input->post( 'post_content' ) , 
						riake( 'post_meta' , $_POST , array() ),
						riake( 'post_taxonomy' , $_POST , array() ),
						$this->input->post( 'post_status' ),
						$this->input->post( 'post_parent' ),
						$status = 'set' 
					);					
					
					if( riake( 'msg' , $return ) === 'custom-query-saved' )
					{
						redirect( 
							array( 'dashboard' , 'posttype' , $namespace , 'edit' , riake( 'id' , $return ) . '?notice=' . riake( 'msg' , $return ) )
						);
					}
					
					get_instance()->notice->push_notice( $this->lang->line( riake( 'msg' , $return ) ) );
				}			
				
				$this->gui->set_title( $this->current_posttype->new_post_label );
				$this->load->view( '../modules/post_type/views/create' , $data , false );
			}
			else if( $page === 'edit' )
			{				
				$this->load->library( 'form_validation' );
				$this->form_validation->set_rules( 'post_title' , __( 'Post title' ) );
				
				if( $this->form_validation->run() )
				{
					$return		=	$this->current_posttype->update( 
						$this->input->post( 'post_title' ) , 
						$this->input->post( 'post_content' ) , 
						riake( 'post_meta' , $_POST , array() ),
						riake( 'post_taxonomy' , $_POST , array() ),
						$this->input->post( 'post_status' ),
						$this->input->post( 'post_parent' ),
						$status = 'publish' , 
						$id 
					);					
					
					if( riake( 'msg' , $return ) === 'custom-query-saved' )
					{
						redirect( 
							array( 'dashboard' , 'posttype' , $namespace , 'edit' , riake( 'id' , $return ) . '?notice=' . riake( 'msg' , $return ) )
						);
					}
					
					get_instance()->notice->push_notice( $this->lang->line( riake( 'msg' , $return ) ) );
				}		
				
				// print_array( get_core_vars( 'post' ) );die;
							
				$this->gui->set_title( $this->current_posttype->edit_post_label );
				$this->load->view( '../modules/post_type/views/edit' , array(
					'post_namespace'		=>		$namespace,
					'new_post_label'		=>		$this->current_posttype->new_post_label,
					'current_posttype'	=>		$this->current_posttype,
					'post'					=>		farray( $this->current_posttype->get( array( 
						'where' =>	array( 'id'	=>	$id )
					) ) )
				) , false );
			}
			else if( $page === 'taxonomy' )
			{
				// $id is taxonomy namespace here
				if( in_array( $id , array_keys( force_array( $taxonomy	=	$this->current_posttype->query->get_defined_taxonomies() ) ) ) )
				{
					$this->config->set_item( 'current_taxonomy' , $current_taxonomy	=	riake( $id , $taxonomy ) );
					$this->config->set_item( 'taxonomy_namespace' , $taxonomy_namespace	=	$id );					
					$this->config->set_item( 'taxonomy' , $taxonomy );
					$this->config->set_item( 'taxonomy_list_label' , riake( 'taxonomy-list-label' , $current_taxonomy ) );
					
					if( $taxonomy_arg1 === 'list' )
					{
						$taxonomy_limit		=	20;
						$taxonomy_arg2		=	$taxonomy_arg2 	=== 0 ? 1 : $taxonomy_arg2;
						
						$this->config->set_item( 'taxonomies_nbr' , $taxonomies_nbr 	=	count( $this->current_posttype->query->get_taxonomies( $taxonomy_namespace ) ) ); 
						$this->config->set_item( 'pagination' , $pagination =	pagination_helper( 
							$taxonomy_limit , 
							$taxonomies_nbr , 
							$taxonomy_arg2 , 
							site_url( array( 'dashboard' , 'posttype' , $namespace , $page , $id , $taxonomy_arg1 ) ) , 
							site_url( array('error','code','page-404' ) ) ) 
						);
						$this->config->set_item( 'taxonomies' , $this->current_posttype->query->get_taxonomies( $pagination[ 'start' ] , $pagination[ 'end' ] ) );
						
						set_page( 'title' ,  riake( 'new-taxonomy-label' , $current_taxonomy ) , 'Post List Label [#Unexpected error occured]' );
						$this->load->view( 'admin/posttypes/taxonomy-list' , false );
					}
					else if( $taxonomy_arg1 === 'new' )
					{
						$this->load->library( 'form_validation' );
						$this->form_validation->set_rules( 'taxonomy_title' , __( 'Taxonomy Title' ) , 'required' );
						
						if( $this->form_validation->run() )
						{
							$result	=	$this->current_posttype->query->set_taxonomy( 
								$id , 
								$this->input->post( 'taxonomy_title' ) , 
								$this->input->post( 'taxonomy_content' ) , 
								in_array( $this->input->post( 'taxonomy_parent' ) , array( false , '' ) , TRUE ) ? null : $this->input->post( 'taxonomy_parent' )								
							);
							get_instance()->notice->push_notice( $this->lang->line( $result ) );
						}
						
						set_page( 'title' ,  riake( 'new-taxonomy-label' , $current_taxonomy , __( 'New taxonomy' ) ) , 'Post List Label [#Unexpected error occured]' );
						$this->load->view( 'admin/posttypes/taxonomy-create' , false );
					}
					else if( $taxonomy_arg1 === 'edit' )
					{
						$this->load->library( 'form_validation' );
						$this->form_validation->set_rules( 'taxonomy_title' , __( 'Taxonomy Title' ) , 'required' );
						
						if( $this->form_validation->run() )
						{
							$result	=	$this->current_posttype->query->update_taxonomy( 
								$id , 
								$this->input->post( 'taxonomy_title' ) , 
								$this->input->post( 'taxonomy_content' ) , 
								in_array( $this->input->post( 'taxonomy_parent' ) , array( false , '' ) , TRUE ) ? null : $this->input->post( 'taxonomy_parent' ),
								$taxonomy_arg2 // Since this is the taxonomy id					
							);
							get_instance()->notice->push_notice( $this->lang->line( 'taxonomy-set' ) );
						}
						
						$this->config->set_item( 'taxonomy_id' , $taxonomy_arg2 );
						$this->config->set_item( 'get_taxonomy' , farray( $this->current_posttype->query->get_taxonomies( $taxonomy_namespace , $taxonomy_arg2 , 'as_id' ) ) );						
						set_page( 'title' ,  riake( 'edit-taxonomy-label' , $current_taxonomy , __( 'Edit taxonomy' ) ) , 'Post List Label [#Unexpected error occured]' );
						$this->load->view( 'admin/posttypes/taxonomy-edit' , false );
					}
				}
				else
				{
					$this->url->redirect( array( 'error' , 'code' , 'unknow-taxonomy' ) );
				}
			}
			else if( $page === 'comments' )
			{
				if( $id === 'approve' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 1 );
					if( $exec == 'comment-edited' )
					{
						$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
					
				}
				else if( $id === 'disapprove' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 4 );
					if( $exec == 'comment-edited' )
					{
						$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
				}
				else if( $id === 'trash' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 3 );
					if( $exec == 'comment-edited' )
					{
						$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
				}
				else if( $id === 'draft' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 0 );
					if( $exec == 'comment-edited' )
					{
						$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
				}
				else if( $id === 'delete' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->delete_comment( $taxonomy_arg1 , 'as_id' );
					if( $exec == 'comment-edited' )
					{
						$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					$this->url->redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
				}
				// $this->current_posttype->query->post_comment( 1 , 'Custom' , $author = false , $mode = 'create' , $comment_id = null , $author_name = 'Blair' , $author_email = 'carlos@hoazd.de'  , $reply_to = false );
				
				$id				=	$id 	=== 0 ? 1 : $id;
				$comment_limit	=	10;
				$comments_nbr	=	count( $this->current_posttype->query->get_comments() );				
				
				$pagination		=	pagination_helper(
					$comment_limit,
					$comments_nbr,
					$id,
					site_url( array( 'dashboard' , 'posttype' , $namespace , 'comments' ) ),
					site_url( array( 'error' , 'code' , 'page-404' ) ) 
				);
				
				$comments		=	$this->current_posttype->query->get_comments( array( 
					'limit'		=>	array(
						'start'	=>	riake( 'start' , $pagination ),
						'end'	=>	riake( 'end' , $pagination )
					)
				) );
				
				$this->config->set_item( 'comments' , $comments );				
				$this->config->set_item( 'comments_list_label' , $this->current_posttype->comments_list_label );
				
				$this->gui->set_title( $this->current_posttype->comments_list_label );
				$this->load->view( '../modules/post_type/views/comments-list' , array(
					'pagination_data'		=>		$pagination,
					'post_namespace' 		=>		$namespace,
					'comments_list_label'=>		$this->current_posttype->comments_list_label,
					'comments'				=>		$comments
				) , false );
			}
			else if( $page === 'comment-edit' )
			{
			}
		}
		else
		{
			$this->url->redirect( array( 'error' , 'code' , 'unknow-post-type' ) );
		}
	}	
}
new post_type;