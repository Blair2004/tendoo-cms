<?php 
class Nexo_Controller extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_filter( 'admin_menus', array( $this, 'menus' ) );
		$this->events->add_action( 'load_dashboard', array( $this, 'load_dashboard' ) );
		$this->events->add_action( 'load_frontend', array( $this, 'frontend' ) );
	}
	function frontend()
	{
		global $CurrentScreen, $CurrentMethod;
		if( $CurrentScreen == 'validate_license' ) {
			echo json_encode( array(
				'is_valid'			=>	true,
				'license_duration'	=>	60
			) );
		}
	}
	function menus( $final )
	{
		global $Nexo_Menus;
		
		$Nexo_Menus	=	array();
		
		$this->events->do_action( 'nexo_before_checkout', $Nexo_Menus );
		
		$Nexo_Menus[ 'caisse' ]        =    array(
            array(
                'title'            =>        __( 'Caisse', 'nexo' ), // menu title
                'icon'            =>        'fa fa-shopping-cart', // menu icon
                'href'            =>        site_url('dashboard/foo'), // url to the page,
				'disable'		=>	true
            ),
			array(
                'title'       =>	__( 'Liste des commandes', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	site_url('dashboard/nexo/commandes/lists'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Nouvelle commande', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	site_url('dashboard/nexo/commandes/lists/add'), // url to the page,
            ),
			/**
			array(
                'title'       =>	__( 'Liste des bons d\'avoir', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	'http://nexo.tendoo.org/get-premium', // url to the page, // site_url('dashboard/nexo/bon_davoir')
            ),
			array(
                'title'       =>	__( 'Nouveau bon d\'avoir', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	'http://nexo.tendoo.org/get-premium', // site_url('dashboard/nexo/bon_davoir/add'), // url to the page,
            ),
			**/
			array(
                'title'       =>	__( 'Liste des moyens de paiment', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	site_url('dashboard/nexo/paiements/lists'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Ajouter un moyen de paiment', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	site_url('dashboard/nexo/paiements/add'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Liste des types de commandes', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	site_url('dashboard/nexo/types_de_commandes/lists'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Ajouter un type de commande', 'nexo' ), // menu title
                'icon'        =>    'fa fa-star', // menu icon
                'href'        =>	site_url('dashboard/nexo/types_de_commandes/lists/add'), // url to the page,
            ),
        );  
		
		$this->events->do_action( 'nexo_before_customers', $Nexo_Menus );  
		
		$Nexo_Menus[ 'clients' ]		=	$this->events->apply_filters( 'nexo_customers_menu_array', array(
			array( 
				'title'		=>	__( 'Clients', 'nexo' ),
				'href'		=>	'#',
				'disable'	=>	true,
				'icon'		=>	'fa fa-users'
			),
			array( 
				'title'		=>	__( 'Liste des clients', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/clients/lists' ),
			),
			array( 
				'title'		=>	__( 'Ajouter un client', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/clients/add' ),
			),
			array( 
				'title'		=>	__( 'Groupes', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/clients/groups/list' ),
			),
			array( 
				'title'		=>	__( 'Ajouter un groupe', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/clients/groups/list/add' ),
			)
		) );
		
		$this->events->do_action( 'nexo_before_shipping', $Nexo_Menus );  
		
		$Nexo_Menus[ 'arrivages' ]	=	$this->events->apply_filters( 'nexo_shipping_menu_array', array(
			array( 
				'title'		=>	__( 'Arrivages', 'nexo' ),
				'href'		=>	'#',
				'disable'	=>	true,
				'icon'		=>	'fa fa-truck'
			),
			array( 
				'title'		=>	__( 'Liste des livraisons', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/arrivages/lists' ),
			),
			array( 
				'title'		=>	__( 'Nouvelle livraison', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/arrivages/add' ),
			),
			array( 
				'title'		=>	__( 'Liste des articles', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/produits/lists' ),
			),
			array( 
				'title'		=>	__( 'Ajouter un article', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/produits/add' ),
			),
			array( 
				'title'		=>	__( 'Liste des fournisseurs', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/fournisseurs/lists' ),
			),
			array( 
				'title'		=>	__( 'Ajouter un fournisseur', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/fournisseurs/add' ),
			),
			array( 
				'title'		=>	__( 'Liste des rayons', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/rayons/lists' ),
			),
			array( 
				'title'		=>	__( 'Ajouter un rayon', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/rayons/add' ),
			),
			array( 
				'title'		=>	__( 'Liste des catégories', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/categories/lists' ),
			),
			array( 
				'title'		=>	__( 'Ajouter une catégorie', 'nexo' ),
				'href'		=>	site_url( 'dashboard/nexo/categories/add' ),
			),
		) );
		
		$this->events->do_action( 'nexo_before_reports', $Nexo_Menus );  
		
		$Nexo_Menus[ 'rapports' ]	=	$this->events->apply_filters( 'nexo_reports_menu_array', array(
			array( 
				'title'		=>	__( 'Rapports & Statistiques', 'nexo' ),
				'href'		=>	'#',
				'disable'	=>	true,
				'icon'		=>	'fa fa-bar-chart'
			),
			array(
                'title'       =>	__( 'Rapport Journalier', 'nexo' ), // menu title
                'href'        =>	site_url('dashboard/nexo/rapports/journalier'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Rendement Mensuel', 'nexo' ), // menu title
                'href'        =>	'http://nexo.tendoo.org/get-premium', // site_url('dashboard/nexo/rapports/rendement_mensuel'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Statistiques des ventes', 'nexo' ), // menu title
                'href'        =>	'http://nexo.tendoo.org/get-premium', // site_url('dashboard/nexo/rapports/statistique_des_ventes'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Fiche de suivi de stocks général', 'nexo' ), // menu title
                'href'        =>	'http://nexo.tendoo.org/get-premium', // site_url('dashboard/nexo/rapports/fiche_de_suivi_de_stock'), // url to the page,
            ),
		) );
		
		$this->events->do_action( 'nexo_before_accounting', $Nexo_Menus );  
		
		$Nexo_Menus[ 'comptabilite' ]	=	$this->events->apply_filters( 'nexo_accounting_menu_array', array(
			array( 
				'title'		=>	__( 'Comptabilité', 'nexo' ),
				'href'		=>	'#',
				'disable'	=>	true,
				'icon'		=>	'fa fa-line-chart'
			),
			array(
                'title'       =>	__( 'Livre journal des ventes', 'nexo' ), // menu title
                'href'        =>	'http://nexo.tendoo.org/get-premium', // site_url('dashboard/nexo/comptabilite/livre_journal_des_ventes'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Livre journal du patrimoine', 'nexo' ), // menu title
                'href'        =>	'http://nexo.tendoo.org/get-premium' , // site_url('dashboard/nexo/comptabilite/livre_journal_du_patrimoine'), // url to the page,
            ),
			array(
                'title'       =>	__( 'Livre journal de l\'exploitation', 'nexo' ), // menu title
                'href'        =>	'http://nexo.tendoo.org/get-premium', // site_url('dashboard/nexo/comptabilite/livre_journal_dexploitation'), // url to the page,
            ),
		) );
		
		$this->events->do_action( 'nexo_before_history', $Nexo_Menus );  
		
		$Nexo_Menus[ 'activite' ]	=	$this->events->apply_filters( 'nexo_history_menu_array', array(
			array(
				'title'			=>	__( 'Maintenance & Historique', 'nexo' ),
				'icon'			=>	'fa fa-shield',
				'disable'		=>	true
			),
			array(
				'title'			=>	__( 'Historique des activités', 'nexo' ),
				'href'			=>	'http://nexo.tendoo.org/get-premium', // site_url( array( 'dashboard', 'nexo', 'history' ) ),
			),
			array(
				'title'			=>	__( 'Exportation', 'nexo' ),
				'href'			=>	'http://nexo.tendoo.org/get-premium', // site_url( array( 'dashboard', 'nexo', 'export_bdd' ) ),
			),
			array(
				'title'			=>	__( 'Importation', 'nexo' ),
				'href'			=>	'http://nexo.tendoo.org/get-premium', // site_url( array( 'dashboard', 'nexo', 'import_bdd' ) ),
			)
		) );
		
		$this->events->do_action( 'nexo_before_settings', $Nexo_Menus );  
		
		$Nexo_Menus[ 'nexo_settings' ]	=	$this->events->apply_filters( 'nexo_settings_menu_array', array(
			array(
				'title'			=>	__( 'Réglages Nexo', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	'#',
				'disable'		=>	true
			),
			array(
				'title'			=>	__( 'Général', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings' ) )
			),
			array(
				'title'			=>	__( 'Caisse', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings_checkout' ) )
			),
			array(
				'title'			=>	__( 'Articles', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings_items' ) )
			),
			array(
				'title'			=>	__( 'Détails de la boutique', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings_shop_details' ) )
			),
			array(
				'title'			=>	__( 'Clients', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings_customers' ) )
			),
			array(
				'title'			=>	__( 'Email', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings_email' ) )
			),
			array(
				'title'			=>	__( 'Interface de paiement', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings_paygateways' ) )
			),
			array(
				'title'			=>	__( 'Réinitialisation', 'nexo' ),
				'icon'			=>	'fa fa-gear',
				'href'			=>	site_url( array( 'dashboard', 'nexo', 'settings_reset' ) )
			)
			
		) );
		
		$start	=	array_slice( $final, 0, 1 );
		$end	=	array_slice( $final, 1 );
		$final 	=	array_merge( $start, $Nexo_Menus, $end );
        return $final;	
	}
	
	function load_dashboard()
	{
		$this->load->model( 'Nexo_Misc' );		
		$this->Gui->register_page( 'nexo', array( $this, 'load_controller' ) );
		$this->Gui->register_page( 'Nexo_license', array( $this, 'Nexo_license' ) );
	}
		
	function Nexo_license()
	{
		echo $this->Nexo_Misc->check_license_ajax();
	}
	function load_controller()
	{
		$this->args	=	func_get_args();
		if( is_array( $this->args ) && count( $this->args ) > 0 ) {
			$file	=	dirname( __FILE__ ) . '/../__controllers/' . $this->args[0] . '.php';
			if( is_file( $file ) ) {
				include_once( $file );
			} else {
				show_error( 'Unable to find this file : ' . $file );
			}
		}
	}
}
new Nexo_Controller;
