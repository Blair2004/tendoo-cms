<?php
class Pages_editor_admin_controller extends Libraries
{
	public function __construct()
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->config();
		declare_notice( 'page_created' , tendoo_success( 'La page à correctement été créé.' ) );
		declare_notice( 'successfully_updated' , tendoo_success( 'La page à correctement été mise à jour.' ) );
		// --------------------------------------------------------------------
		$this->data						=	array();
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->opened_module			=	get_core_vars( 'opened_module' );
		$this->opened_module			=	$this->opened_module[0];
		$this->lib						=	new page_library;
	}
	private function config()
	{
		setup_admin_left_menu( 'Page Editor' , 'edit' );
		add_admin_left_menu( 'Accueil' , module_url( array( 'index' ) ) );
		add_admin_left_menu( 'Créer une page' , module_url( array( 'create' ) ) );
		add_admin_left_menu( 'Réglages' , module_url( array( 'settings' ) ) );
	}
	public function index($page = 1)
	{
		notice( 'push' , tendoo_info( 'Les fils d\'une page ne seront pas accéssibles sur l\'interface public, si cette page est un brouillon.' ) );
		if( isset( $_POST[ 'page_id' ] ) && return_if_array_key_exists( 'action' , $_POST ) == 'delete' ){
			if( is_array( $_POST[ 'page_id' ] ) ){
				foreach( $_POST[ 'page_id' ] as $_page_id ){
					$this->lib->delete_page( $_page_id );					
				}
				notice( fetch_error( 'done' ) );
			}
		}
		$totalPerPages = isset( $_GET[ 'limit' ] ) ? $_GET[ 'limit' ] : 10 ;
		
		set_core_vars( 'totalPages' , $totalPages = count( $this->lib->get_pages( 'all_available' ) ) );
		$paginate 		=	pagination_helper($totalPerPages,$totalPages,$page,module_url( array( 'index' ) ),$RedirectUrl = array('error','code','page404') ) ;
		set_core_vars( 'paginate' , $paginate );
		$get_pages		=	$this->lib->get_pages( 'all_limited' , $paginate[ 'start' ] , $paginate[ 'end' ] );
		set_core_vars( 'get_pages' , $get_pages );
		set_page( 'title' , 'Page Editor - Page d\'administration' );
		
		return $this->load->view($this->opened_module['URI_PATH'].'/views/main',$this->data,true,TRUE);
	}
	public function create()
	{
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'page_title' , 'Titre de la page' , 'trim|required' );
		$this->form_validation->set_rules( 'page_description' , 'Description de la page' , 'trim|required' );
		$this->form_validation->set_rules( 'page_content' , 'le champ du contenu' , 'trim|required' );
		if( $this->form_validation->run() ){
			$post_page	=	$this->lib->set_page( 
				$this->input->post( 'page_title' ) , 
				$this->input->post( 'page_content' ) , 
				$this->input->post( 'page_description' ) , 
				$this->input->post( 'page_parent' ) ? $this->input->post( 'page_parent' ) : 0 , 
				$this->input->post( 'page_controller_id' ) ? $this->input->post( 'page_controller_id' ) : 0 , 
				$process_type = 'create' , 
				( $this->input->post( 'page_status' ) ? 1 : 0 ) 
			);
			
			module_location( array( 'edit' , $post_page[ 'ID' ] . '?notice=page_created' ) );
		}
				
		set_page( 'title' , 'Page Editor - Créer une nouvelle page' );		
		set_core_vars( 'available_controllers' , $this->lib->get_available_controllers() );
		set_core_vars( 'available_pages' , $this->lib->get_pages( 'all_available' ) );
		
		$this->visual_editor->loadEditor(1);
		return $this->load->view($this->opened_module['URI_PATH'].'/views/create',$this->data,true,TRUE);
	}
	public function edit( $page_id )
	{
		$this->load->library( 'form_validation' );
		$this->form_validation->set_rules( 'page_title' , 'Titre de la page' , 'trim|required' );
		$this->form_validation->set_rules( 'page_id' , 'Identifiant de la page' , 'trim|required' );
		$this->form_validation->set_rules( 'page_description' , 'Description de la page' , 'trim|required' );
		$this->form_validation->set_rules( 'page_content' , 'le champ du contenu' , 'trim|required' );
		if( $this->form_validation->run() ){
			$post_page	=	$this->lib->set_page( 
				$this->input->post( 'page_title' ) , 
				$this->input->post( 'page_content' ) , 
				$this->input->post( 'page_description' ) , 
				$this->input->post( 'page_parent' ) ? $this->input->post( 'page_parent' ) : 0 , 
				$this->input->post( 'page_controller_id' ) ? $this->input->post( 'page_controller_id' ) : 0 , 
				$process_type = 'edit' , 
				( $this->input->post( 'page_status' ) ? 1 : 0 ),
				$this->input->post( 'page_id' )
			);
			notice( 'push' , fetch_error( $post_page ) );
		}
				
		set_page( 'title' , 'Page Editor - modifier une page' );		
		set_core_vars( 'available_controllers' , $this->lib->get_available_controllers( $page_id ) );
		set_core_vars( 'available_pages' , $this->lib->get_pages( 'all_but_not' , $page_id ) );
		set_core_vars( 'current_page' ,  $this->lib->get_pages( 'filter_id' , $page_id ) );
		
		$this->visual_editor->loadEditor(1);
		return $this->load->view($this->opened_module['URI_PATH'].'/views/edit',$this->data,true,TRUE);
	}
}
