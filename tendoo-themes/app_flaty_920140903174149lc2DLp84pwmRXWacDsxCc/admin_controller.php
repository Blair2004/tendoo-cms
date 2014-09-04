<?php 
class flaty_theme_backend
{
	private $lib;
	public function __construct($data)
	{
		__extends($this);
        include_once($data['theme'][0]['encrypted_dir'].'/library.php');
        $this->lib	=	new nevia_theme_library($data);
        // Définition des chemins d'accès.
        $this->data['theme_details']	=&	$this->data['Spetheme'][0];
		$this->location					=&	$this->data['Spetheme']['encrypted_dir'];
        $this->loadAccess				=	$this->data['loadAccess']	=	THEMES_DIR.$this->location.'/';
        // LOADING VIEW //
        $this->data['tendoo_head']		=	$this->load->view(VIEWS_DIR.'/admin/inner_head',$this->data,true,TRUE);
		$this->data['tendoo_left_menu']	=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
	}
	public function index()
	{
    	// DEFINE THEME TITLE //
		set_page('title','2TB &raquo; Flaty - Gestion du thème');
        // END THEME TITLE //
        // DEFINE THEME DESCRIPTION //
        set_page('description','Thème cr&eacute;e avec 2TB');
        // END THEME DESCRIPTION //
        $this->data['body']			=		$this->load->view($this->loadAccess.'views/body',$this->data,true,true);
		return $this->data['body'];
	}
    public function about()
	{
    	// DEFINE THEME TITLE //
		set_page('title','2TB &raquo; A propos de  Nevia');
        // END THEME TITLE //
        // DEFINE THEME DESCRIPTION //
        set_page('description','Thème cr&eacute;e avec 2TB');
        // END THEME DESCRIPTION //
        $this->data['body']			=		$this->load->view($this->loadAccess.'views/about',$this->data,true,true);
		return $this->data['body'];
	}
}