<?php 
class Nexo_Install extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'do_enable_module', array( $this, 'enable' ) );
		$this->events->add_action( 'do_remove_module', array( $this, 'uninstall' ) );
		$this->events->add_action( 'tendoo_settings_tables', array( $this, 'install_tables' ) );
		$this->events->add_action( 'tendoo_settings_final_config', array( $this, 'final_config' ) );
	}
	function enable( $namespace )
	{ 
		if( $namespace === 'nexo' && $this->options->get( 'nexo_installed' ) == NULL ) {
			// Install Tables
			$this->install_tables();
			$this->final_config();
		}
	}
	
	/**
	 * Final Config
	 * 
	 * @return void
	**/
	
	function final_config()
	{		
		$this->load->model( 'Nexo_Checkout' );
		$this->Nexo_Checkout->create_permissions();		

		// Defaut options
		$this->options->set( 'nexo_installed', true, true );	
		$this->options->set( 'nexo_display_select_client', 'enable', true );
		$this->options->set( 'nexo_display_payment_means', 'enable', true );
		$this->options->set( 'nexo_display_amount_received', 'enable', true );
		$this->options->set( 'nexo_display_discount', 'enable', true );
		$this->options->set( 'nexo_currency_position', 'before', true );
		$this->options->set( 'nexo_receipt_theme', 'default', true );
		$this->options->set( 'nexo_enable_autoprinting', 'no', true );
		$this->options->set( 'nexo_devis_expiration', 7, true );
		$this->options->set( 'nexo_shop_street', 'Cameroon, Yaoundé Ngousso Av.', true );
		$this->options->set( 'nexo_shop_pobox', '45 Edéa Cameroon', true );
		$this->options->set( 'nexo_shop_email', 'carlosjohnsonluv2004@gmail.com', true );
		$this->options->set( 'how_many_before_discount', 0, true );
		$this->options->set( 'nexo_products_labels', 5, true );
		$this->options->set( 'nexo_codebar_height', 100, true );
		$this->options->set( 'nexo_bar_width', 3, true );
		$this->options->set( 'nexo_soundfx', 'enable', true );
		$this->options->set( 'nexo_currency', '$', true );
	}
	
	/**
	 * Install tables
	 * 
	 * @return void
	**/
	
	function install_tables()
	{
		// let's set this module active
		Modules::enable( 'grocerycrud' );
		Modules::enable( 'nexo' );
					
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_clients` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `NOM` varchar(200) NOT NULL,
		  `PRENOM` varchar(200) NOT NULL,
		  `POIDS` int(11) NOT NULL,
		  `TAILLE` int(11) NOT NULL,
		  `PREFERENCE` varchar(200) NOT NULL,
		  `TEL` int(11) NOT NULL,
		  `EMAIL` varchar(200) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `DATE_NAISSANCE` datetime NOT NULL,
		  `ADRESSE` text NOT NULL,
		  `NBR_COMMANDES` int NOT NULL,
		  `OVERALL_COMMANDES` int NOT NULL,
		  `DISCOUNT_ACTIVE` int NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;' );
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_clients_groups` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `NAME` varchar(200) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		  `DATE_MODIFICATION` datetime NOT NULL,
		  `AUTHOR` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;' );
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_paiements` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `DESIGN` varchar(200) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;' );
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_types_de_commandes` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `DESIGN` varchar(200) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;' );
		
		// Bon d'voir @since 2.1
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_bon_davoir` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `RAISON` varchar(200) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `TYPE` varchar(200) NOT NULL,
		  `COMMANDE_REF_ID` int(11) NOT NULL,
		  `MONTANT` int(11) NOT NULL,
		  `ARTICLE_CODEBAR` int(11) NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		   `DATE_MOD` datetime NOT NULL,
		  `AUTHOR` int(11) NOT NULL,  
		  `REF_CLIENT` int(11) NOT NULL,
		  `REF_PRODUCT_CODEBAR` varchar(200) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;' );
					
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_commandes` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `TITRE` varchar(200) NOT NULL, 
		  `DESCRIPTION` varchar(200) NOT NULL,
		  `CODE` varchar(250) NOT NULL,
		  `REF_CLIENT` int(50) NOT NULL,
		  `TYPE` int(50) NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		  `DATE_MOD` datetime NOT NULL,
		  `PAYMENT_TYPE` int(50) NOT NULL,
		  `AUTHOR` varchar(200) NOT NULL,  
		  `SOMME_PERCU` int(50) NOT NULL,
		  `REMISE` int(50) NOT NULL,
		  `RABAIS` int(50) NOT NULL,
		  `RISTOURNE` int(50) NOT NULL,			  
		  `TOTAL` int(50) NOT NULL,
		  `DISCOUNT_TYPE` varchar(200) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_commandes_produits` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `REF_PRODUCT_CODEBAR` varchar(250) NOT NULL, 
		  `REF_COMMAND_CODE` varchar(250) NOT NULL,
		  `QUANTITE` int(11) NOT NULL,
		  `PRIX` int NOT NULL,
		  `PRIX_TOTAL` int NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
					
		// Articles tables
		// 			  `REF_CODE` INT NOT NULL, 
		/*
			  `ACTIVER_PROMOTION` BOOLEAN NOT NULL, 
			  `DEBUT_PROMOTION` DATETIME NOT NULL, 
			  `FIN_PROMOTION` DATETIME NOT NULL,
		*/

		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_articles` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `DESIGN` varchar(200) NOT NULL,
		  `REF_RAYON` INT NOT NULL, 
		  `REF_SHIPPING` INT NOT NULL, 
		  `REF_CATEGORIE` INT NOT NULL,
		  `QUANTITY` INT NOT NULL,
		  `SKU` VARCHAR(220) NOT NULL,
		  `QUANTITE_RESTANTE` INT NOT NULL, 
		  `QUANTITE_VENDU` INT NOT NULL,
		  `DEFECTUEUX` INT NOT NULL, 
		  `PRIX_DACHAT` INT NOT NULL,
		  `FRAIS_ACCESSOIRE` INT NOT NULL, 
		  `COUT_DACHAT` INT NOT NULL,
		  `TAUX_DE_MARGE` DOUBLE NOT NULL, 
		  `PRIX_DE_VENTE` INT NOT NULL,
		  `TAILLE` varchar(200) NOT NULL,
		  `POIDS` VARCHAR(200) NOT NULL, 
		  `COULEUR` varchar(200) NOT NULL,
		  `HAUTEUR` VARCHAR(200) NOT NULL, 
		  `LARGEUR` VARCHAR(200) NOT NULL,
		  `PRIX_PROMOTIONEL` INT NOT NULL,
		  `DESCRIPTION` TEXT NOT NULL,
		  `APERCU` VARCHAR(200) NOT NULL,
		  `CODEBAR` varchar(200) NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		   `DATE_MOD` datetime NOT NULL,
		  `AUTHOR` int(50) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
					
		// Catégories d'articles
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_categories` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `NOM` varchar(200) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		   `DATE_MOD` datetime NOT NULL,
		  `AUTHOR` int(50) NOT NULL,
		  `PARENT_REF_ID` int(50) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
					
		// Fournisseurs table
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_fournisseurs` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `NOM` varchar(200) NOT NULL,
		  `BP` varchar(200) NOT NULL,
		  `TEL` varchar(200) NOT NULL,
		  `EMAIL` varchar(200) NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		   `DATE_MOD` datetime NOT NULL,
		  `AUTHOR` varchar(200) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
		
		// Log Modification
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_historique` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `TITRE` varchar(200) NOT NULL, 
		  `DETAILS` text NOT NULL,
		  `DATE_CREATION` datetime NOT NULL,
		   `DATE_MOD` datetime NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

		// Arrivage
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_arrivages` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `TITRE` varchar(200) NOT NULL, 
		  `DESCRIPTION` text NOT NULL,   
		  `DATE_CREATION` datetime NOT NULL,
		   `DATE_MOD` datetime NOT NULL,
		  `AUTHOR` int(50) NOT NULL, 
		  `FOURNISSEUR_REF_ID` int(50) NOT NULL, 
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
		
		$this->db->query( 'CREATE TABLE IF NOT EXISTS `'.$this->db->dbprefix.'nexo_rayons` (
		  `ID` int(50) NOT NULL AUTO_INCREMENT,
		  `TITRE` varchar(200) NOT NULL, 
		  `DESCRIPTION` text NOT NULL,   
		  `DATE_CREATION` datetime NOT NULL,
		   `DATE_MOD` datetime NOT NULL,
		  `AUTHOR` int(50) NOT NULL, 
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');
	}
	
	/**
	 * unistall Nexo
	 * 
	 * @return void
	**/
	
	function uninstall( $namespace )
	{
		// retrait des tables Nexo
		if( $namespace === 'nexo' ) {
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'bon_davoir`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_commandes`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_commandes_produits`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_articles`;' );
			
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_categories`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_fournisseurs`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_historique`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_arrivages`;' );
			
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_rayons`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_clients`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_paiements`;' );
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'nexo_bon_davoir`;' );
			
			$this->options->delete( 'nexo_installed' );
			$this->options->delete( 'nexo_saved_barcode' );
			$this->options->delete( 'order_code' );
			$this->options->delete( 'nexo_order_advance' );
			$this->options->delete( 'nexo_order_comptant' );
			$this->options->delete( 'nexo_order_devis' );
			
			$this->load->model( 'Nexo_Checkout' );
			$this->Nexo_Checkout->delete_permissions();
		}
	}
}
new Nexo_Install;