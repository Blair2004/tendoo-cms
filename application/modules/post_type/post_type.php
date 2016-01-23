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
		if( ! Modules::is_active( 'aauth' ) )
		{
			$this->events->add_filter( 'ui_notices' , function( $notices ){
				$notices[]		=	array(
					'msg'		=>		__( 'Aauth Module is required, please install or enable it' ),
					'type'	=>		'warning',
					'icon'	=>		'users',
					'href'	=>		site_url( array( 'dashboard' , 'modules' ) )
				);
				return $notices;
			});
		}
		if( Modules::is_active( 'aauth' ) )
		{
			$this->load->language( 'blog_lang' );
			$this->load->helper( 'url_slug' );
			// including CustomQuery.php library file
			include_once( LIBPATH . '/CustomQuery.php' );
			include_once( dirname( __FILE__ ) . '/inc/setup.php' );
			
			$this->events->add_action( 'load_dashboard' , array( $this , '__register_page' ) );
			
			// Load Post Types			
			$this->events->do_action( 'load_post_types' , 15 );
		}
	}
	function __register_page()
	{
		$this->gui->register_page( 'posttype' , array( $this , '__posttype_controller' ) );
	}
	public function __posttype_controller( $namespace , $page = 'list' , $id = 0 , $taxonomy_arg1 = 'list' , $taxonomy_arg2 = 0 )
	{
		if( $this->current_posttype	= riake( $namespace , $this->config->item( 'posttypes' ) ) )
		{
			$data[ 'current_posttype' ]		= $this->current_posttype;
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
					array(
						'limit'		=>	array( 
							'start' 	=> riake( 'start' , $pagination ),
							'end' 		=> riake( 'end' , $pagination ) 
						)
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
				$this->form_validation->set_rules( 'submit_content' , __( 'Post title' ), 'required' );
				
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
				$this->form_validation->set_rules( 'submit_content' , __( 'Post title' ), 'required' );
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
						array( 'where' =>	array( 'id'	=>	$id ) )
					) ) )
				) , false );
			}
			else if( $page === 'taxonomy' )
			{
				// $id is taxonomy namespace here
				if( in_array( $id , array_keys( force_array( $taxonomy	=	$this->current_posttype->query->get_defined_taxonomies() ) ) ) )
				{
					$data					=	array();
					$data[ 'current_taxonomy' ]	=	$current_taxonomy	=	riake( $id , $taxonomy );
					$data[ 'taxonomy_namespace' ]	= 	$taxonomy_namespace	=	$id;					
					$data[ 'taxonomy' ]				= 	$taxonomy;
					$data[ 'taxonomy_list_label' ]=	riake( 'taxonomy-list-label' , $current_taxonomy );
					$data[ 'post_namespace' ]		=	$namespace;
					
					if( $taxonomy_arg1 === 'list' )
					{
						$taxonomy_limit		=	20;
						$taxonomy_arg2		=	$taxonomy_arg2 	=== 0 ? 1 : $taxonomy_arg2;
						
						$taxonomies_nbr 	=	count( $this->current_posttype->query->get_taxonomies( $taxonomy_namespace ) );
						$pagination =	pagination_helper( 
							$taxonomy_limit , 
							$taxonomies_nbr , 
							$taxonomy_arg2 , 
							site_url( array( 'dashboard' , 'posttype' , $namespace , $page , $id , $taxonomy_arg1 ) ) , 
							site_url( array('error','code','page-404' ) ) 
						);
						
						$data[ 'taxonomy_list_label' ]	=	riake( 'taxonomy-list-label' , $current_taxonomy );
						$data[ 'taxonomies' ]				=	$this->current_posttype->query->get_taxonomies( $taxonomy_namespace , $pagination[ 'start' ] , $pagination[ 'end' ] );
						$data[ 'taxonomies_nbr' ]			=	$taxonomies_nbr;
						$data[ 'pagination' ]				=	$pagination;
						$data[ 'current_taxonomy' ]		=	$current_taxonomy;
						
						$this->gui->set_title( riake( 'new-taxonomy-label' , $current_taxonomy ) );
						$this->load->view( '../modules/post_type/views/taxonomy-list' , $data );
					}
					else if( $taxonomy_arg1 === 'new' )
					{
						$this->load->library( 'form_validation' );
						$this->form_validation->set_rules( 'taxonomy_title' , __( 'Taxonomy Title' ) , 'required' );
						
						if( $this->form_validation->run() )
						{
							$result	=	$this->current_posttype->query->set_taxonomy( 
								$data[ 'taxonomy_namespace' ] , 
								$this->input->post( 'taxonomy_title' ) , 
								$this->input->post( 'taxonomy_content' ) , 
								in_array( $this->input->post( 'taxonomy_parent' ) , array( false , '' ) , TRUE ) ? null : $this->input->post( 'taxonomy_parent' )								
							);
							get_instance()->notice->push_notice( $this->lang->line( $result ) );
						}
						
						$this->gui->set_title( riake( 'new-taxonomy-label' , $current_taxonomy , __( 'New taxonomy' ) ) );
						$this->load->view( '../modules/post_type/views/taxonomy-create' , $data , false );
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
								$taxonomy_arg2,
								in_array( $this->input->post( 'taxonomy_parent' ) , array( false , '' ) , TRUE ) ? null : $this->input->post( 'taxonomy_parent' )	
							);
							
							get_instance()->notice->push_notice( $this->lang->line( 'taxonomy-set' ) );
						}
						
						$data[ 'taxonomy_id' ]	=	 $taxonomy_arg2;
						$data[ 'get_taxonomy' ]	=	 farray( $this->current_posttype->query->get_taxonomies( $taxonomy_namespace , $taxonomy_arg2 , 'as_id' ) );						
						
						$this->gui->set_title(  riake( 'edit-taxonomy-label' , $current_taxonomy , __( 'Edit taxonomy' ) ) );
						$this->load->view( '../modules/post_type/views/taxonomy-edit' , $data );
					}
				}
				else
				{
					redirect( array( 'dashboard' , 'error' , 'unknow-taxonomy' ) );
				}
			}
			else if( $page === 'comments' )
			{
				if( $id === 'approve' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 1 );
					if( $exec == 'comment-edited' )
					{
						redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
					
				}
				else if( $id === 'disapprove' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 4 );
					if( $exec == 'comment-edited' )
					{
						redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
				}
				else if( $id === 'trash' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 3 );
					if( $exec == 'comment-edited' )
					{
						redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
				}
				else if( $id === 'draft' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->comment_status( $taxonomy_arg1 , 0 );
					if( $exec == 'comment-edited' )
					{
						redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
				}
				else if( $id === 'delete' && $taxonomy_arg1 != 0 )
				{
					$exec	=	$this->current_posttype->query->delete_comment( $taxonomy_arg1 , 'as_id' );
					if( $exec == 'comment-edited' )
					{
						redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=' . $exec ) );
					}
					redirect( array( 'dashboard' , 'posttype' , $namespace , $page . '?notice=error-occured' ) );
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
			redirect( array( 'dashboard' , 'error' , 'unknow-post-type' ) );
		}
	}	
}
new post_type;