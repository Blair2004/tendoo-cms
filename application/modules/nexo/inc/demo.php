<?php
// Collection

$this->db->insert( 'nexo_arrivages', array(
	'TITRE'			=>	__( 'Collection 1', 'nexo' ),
	'DESCRIPTION'	=> 	__( 'Collection spéciale pour vêtements d\'hiver', 'nexo' ),
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id(),
	'FOURNISSEUR_REF_ID'	=>	1
) );

$this->db->insert( 'nexo_arrivages', array(
	'TITRE'			=>	__( 'Collection 2', 'nexo' ),
	'DESCRIPTION'	=> 	__( 'Collection spéciale pour vêtements d\'été', 'nexo' ),
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id(),
	'FOURNISSEUR_REF_ID'	=>	2
) );

// Fournisseurs

$this->db->insert( 'nexo_fournisseurs', array(
	'NOM'			=>	__( 'Fournisseurs 1', 'nexo' ),
	'EMAIL'			=>	'vendor@tendoo.org',
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id(),
) );

$this->db->insert( 'nexo_fournisseurs', array(
	'NOM'			=>	__( 'Fournisseurs 2', 'nexo' ),
	'EMAIL'			=>	'vendor@tendoo.org',
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id(),
) );

$this->db->insert( 'nexo_fournisseurs', array(
	'NOM'			=>	__( 'Fournisseurs 3', 'nexo' ),
	'EMAIL'			=>	'vendor@tendoo.org',
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id(),
) );

$this->db->insert( 'nexo_fournisseurs', array(
	'NOM'			=>	__( 'Fournisseurs 4', 'nexo' ),
	'EMAIL'			=>	'vendor@tendoo.org',
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id(),
) );

// Rayons création

$this->db->insert( 'nexo_rayons', array(
	'TITRE'			=>	__( 'Hommes', 'nexo' ),
	'DESCRIPTION'	=>	__( 'Rayon des hommes', 'nexo' ),
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id()
) );

$this->db->insert( 'nexo_rayons', array(
	'TITRE'			=>	__( 'Femmes', 'nexo' ),
	'DESCRIPTION'	=>	__( 'Rayon des Femmes', 'nexo' ),
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id()
) );

$this->db->insert( 'nexo_rayons', array(
	'TITRE'			=>	__( 'Enfants', 'nexo' ),
	'DESCRIPTION'	=>	__( 'Rayon des enfants', 'nexo' ),
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id()
) );

$this->db->insert( 'nexo_rayons', array(
	'TITRE'			=>	__( 'Cadeaux', 'nexo' ),
	'DESCRIPTION'	=>	__( 'Rayon des cadeaux', 'nexo' ),
	'DATE_CREATION'	=>	date_now(),
	'AUTHOR'		=>	User::id()
) );

// Creation des catégories

$this->db->insert( 'nexo_categories', array(
	'NOM'			=>		__( 'Hommes', 'nexo' ),
	'DESCRIPTION'	=>		__( 'Catégorie pour articles d\'hommes.', 'nexo' ),
	'AUTHOR'		=>		User::id(),
	'DATE_CREATION'	=>		date_now()
) );

$this->db->insert( 'nexo_categories', array(
	'NOM'			=>		__( 'Femmes', 'nexo' ),
	'DESCRIPTION'	=>		__( 'Catégorie pour articles de femmes.', 'nexo' ),
	'AUTHOR'		=>		User::id(),
	'DATE_CREATION'	=>		date_now()
) );

$this->db->insert( 'nexo_categories', array(
	'NOM'			=>		__( 'Enfants', 'nexo' ),
	'DESCRIPTION'	=>		__( 'Catégorie pour articles pour enfants.', 'nexo' ),
	'AUTHOR'		=>		User::id(),
	'DATE_CREATION'	=>		date_now()
) );

$this->db->insert( 'nexo_categories', array(
	'NOM'			=>		__( 'Cadeaux', 'nexo' ),
	'DESCRIPTION'	=>		__( 'Catégorie pour articles en cadeaux.', 'nexo' ),
	'AUTHOR'		=>		User::id(),
	'DATE_CREATION'	=>		date_now()
) );

// Products 1

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 1', 'nexo' ),
	'REF_RAYON'			=>		1, // Hommes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		1, // Hommes
	'QUANTITY'			=>		20,
	'SKU'				=>		'UGS1',
	'QUANTITE_RESTANTE'	=>	20,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	65, // $
	'PRIX_DE_VENTE'		=>	100,
	'TAUX_DE_MARGE'		=>	( ( 100 - ( 65 + 5 ) ) / 65 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	5, // $
	'COUT_DACHAT'		=>	65 + 5, // PA + FA
	'TAILLE'			=>	38, // Pouce
	'POIDS'				=>	300, //g
	'COULEUR'			=>	__( 'Rouge', 'nexo' ),
	'HAUTEUR'			=>	25, // cm
	'LARGEUR'			=>	8, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-1.jpg',
	'CODEBAR'			=>	147852
) );

// Produits 2

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 2', 'nexo' ),
	'REF_RAYON'			=>		4, // cadeaux
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		4, // cadeaux
	'QUANTITY'			=>		5,
	'SKU'				=>		'UGS2',
	'QUANTITE_RESTANTE'	=>	5,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	10, // $
	'PRIX_DE_VENTE'		=>	15,
	'TAUX_DE_MARGE'		=>	( ( 15 - ( 10 + 3 ) ) / 10 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	3, // $
	'COUT_DACHAT'		=>	10 + 3, // PA + FA
	'POIDS'				=>	10, //g
	'COULEUR'			=>	__( 'Jaune', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-2.jpg',
	'CODEBAR'			=>	258741
) );

// Produits 3

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 3', 'nexo' ),
	'REF_RAYON'			=>		3, // Enfants
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		3, // Enfants
	'QUANTITY'			=>		10,
	'SKU'				=>		'UGS3',
	'QUANTITE_RESTANTE'	=>	9,
	'DEFECTUEUX'		=>	1,
	'PRIX_DACHAT'		=>	100, // $
	'PRIX_DE_VENTE'		=>	150,
	'TAUX_DE_MARGE'		=>	( ( 150 - ( 100 + 20 ) ) / 100 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	20, // $
	'COUT_DACHAT'		=>	100 + 20, // PA + FA
	'POIDS'				=>	10, //g
	'COULEUR'			=>	__( 'Bleu', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-3.jpg',
	'CODEBAR'			=>	258963
) );

// Produits 4

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 4', 'nexo' ),
	'REF_RAYON'			=>		2, // Femmes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		2, // Hommes
	'QUANTITY'			=>		3,
	'SKU'				=>		'UGS4',
	'QUANTITE_RESTANTE'	=>	3,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	120, // $
	'PRIX_DE_VENTE'		=>	190,
	'TAUX_DE_MARGE'		=>	( ( 190 - ( 120 + 20 ) ) / 120 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	20, // $
	'COUT_DACHAT'		=>	120 + 20, // PA + FA
	'POIDS'				=>	10, //g
	'COULEUR'			=>	__( 'Rose', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-4.jpg',
	'CODEBAR'			=>	369852
) );

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 5', 'nexo' ),
	'REF_RAYON'			=>		2, // Femmes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		2, // Hommes
	'QUANTITY'			=>		3,
	'SKU'				=>		'UGS5',
	'QUANTITE_RESTANTE'	=>	3,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	120, // $
	'PRIX_DE_VENTE'		=>	190,
	'TAUX_DE_MARGE'		=>	( ( 190 - ( 120 + 20 ) ) / 120 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	20, // $
	'COUT_DACHAT'		=>	120 + 20, // PA + FA
	'POIDS'				=>	10, //g
	'COULEUR'			=>	__( 'Noir', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-5.jpg',
	'CODEBAR'			=>	987456
) );

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 6', 'nexo' ),
	'REF_RAYON'			=>		2, // Femmes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		2, // Hommes
	'QUANTITY'			=>		15,
	'SKU'				=>		'UGS6',
	'QUANTITE_RESTANTE'	=>	15,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	80, // $
	'PRIX_DE_VENTE'		=>	120,
	'TAUX_DE_MARGE'		=>	( ( 120 - ( 80 + 20 ) ) / 80 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	20, // $
	'COUT_DACHAT'		=>	80 + 20, // PA + FA
	'POIDS'				=>	8, //g
	'COULEUR'			=>	__( 'Noir', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-6.jpg',
	'CODEBAR'			=>	781124
) );

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 7', 'nexo' ),
	'REF_RAYON'			=>		2, // Femmes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		2, // Hommes
	'QUANTITY'			=>		15,
	'SKU'				=>		'UGS7',
	'QUANTITE_RESTANTE'	=>	15,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	80, // $
	'PRIX_DE_VENTE'		=>	120,
	'TAUX_DE_MARGE'		=>	( ( 120 - ( 80 + 20 ) ) / 80 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	20, // $
	'COUT_DACHAT'		=>	80 + 20, // PA + FA
	'POIDS'				=>	8, //g
	'COULEUR'			=>	__( 'Cyan', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-7.jpg',
	'CODEBAR'			=>	789654
) );

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 8', 'nexo' ),
	'REF_RAYON'			=>		2, // Femmes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		2, // Hommes
	'QUANTITY'			=>		15,
	'SKU'				=>		'UGS7',
	'QUANTITE_RESTANTE'	=>	15,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	120, // $
	'PRIX_DE_VENTE'		=>	300,
	'TAUX_DE_MARGE'		=>	( ( 300 - ( 120 + 20 ) ) / 120 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	15, // $
	'COUT_DACHAT'		=>	120 + 15, // PA + FA
	'POIDS'				=>	8, //g
	'COULEUR'			=>	__( 'Jaune', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-8.jpg',
	'CODEBAR'			=>	456987
) );

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 9', 'nexo' ),
	'REF_RAYON'			=>		2, // Femmes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		2, // Hommes
	'QUANTITY'			=>		15,
	'SKU'				=>		'UGS9',
	'QUANTITE_RESTANTE'	=>	15,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	120, // $
	'PRIX_DE_VENTE'		=>	300,
	'TAUX_DE_MARGE'		=>	( ( 300 - ( 120 + 20 ) ) / 120 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	15, // $
	'COUT_DACHAT'		=>	120 + 15, // PA + FA
	'POIDS'				=>	8, //g
	'COULEUR'			=>	__( 'Jaune', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-9.jpg',
	'CODEBAR'			=>	874569
) );

$this->db->insert( 'nexo_articles', array(
	'DESIGN'			=>		__( 'Article 10', 'nexo' ),
	'REF_RAYON'			=>		2, // Femmes
	'REF_SHIPPING'		=>		1, // Sample Shipping
	'REF_CATEGORIE'		=>		2, // Hommes
	'QUANTITY'			=>		15,
	'SKU'				=>		'UGS10',
	'QUANTITE_RESTANTE'	=>	15,
	'QUANTITE_VENDU'	=>	0,
	'DEFECTUEUX'		=>	0,
	'PRIX_DACHAT'		=>	120, // $
	'PRIX_DE_VENTE'		=>	300,
	'TAUX_DE_MARGE'		=>	( ( 300 - ( 120 + 20 ) ) / 120 ) * 100,
	'FRAIS_ACCESSOIRE'	=>	15, // $
	'COUT_DACHAT'		=>	120 + 15, // PA + FA
	'POIDS'				=>	8, //g
	'COULEUR'			=>	__( 'Jaune', 'nexo' ),
	'HAUTEUR'			=>	3, // cm
	'LARGEUR'			=>	1, // cm
	'AUTHOR'			=>	User::id(),
	'DATE_CREATION'		=>	date_now(),
	'APERCU'			=>	'../modules/nexo/images/produit-10.jpg',
	'CODEBAR'			=>	896547
) );

// Paiements

$this->db->query( "INSERT INTO `{$this->db->dbprefix}nexo_paiements` (`ID`, `DESIGN`, `DESCRIPTION`) VALUES
(1, '" . __( 'Espèces', 'nexo' ) . "', ''),
(2, '" . __( 'Chèque', 'nexo' ) . "', ''),
(3, '" . __( 'MTN Mobile Money', 'nexo' ) . "', ''),
(4, '" . __( 'Orange Money', 'nexo' ) . "', ''),
(5, '" . __( 'Carte Bancaire', 'nexo' ) . "', '');" );

// Clients

$this->db->query( "INSERT INTO `{$this->db->dbprefix}nexo_clients` (`ID`, `NOM`, `PRENOM`, `POIDS`, `TAILLE`, `PREFERENCE`, `TEL`, `EMAIL`, `DESCRIPTION`, `DATE_NAISSANCE`, `ADRESSE`, `NBR_COMMANDES`, `DISCOUNT_ACTIVE`) VALUES
(1, '". __( 'Compte Client', 'nexo' ) ."', 	'', 0, 0, '', 0, 'user@tendoo.org', 				'', '0000-00-00 00:00:00', '', 0, 0),
(2, '". __( 'John Doe', 'nexo' ) ."', 		'', 0, 0, '', 0, 'johndoe@tendoo.org', 				'',	'0000-00-00 00:00:00', '', 0, 0),
(3, '". __( 'Jane Doe', 'nexo' ) ."', 		'', 0, 0, '', 0, 'janedoe@tendoo.org', 				'',	'0000-00-00 00:00:00', '', 0, 0),
(4, '". __( 'Blair Jersyer', 'nexo' ) ."', 	'', 0, 0, '', 0, 'carlosjohnsonluv2004@gmail.com', 	'',	'0000-00-00 00:00:00', '', 0, 0);" );

// Type des commandes

$this->db->insert( 'nexo_types_de_commandes', array(
	'DESIGN'		=>		__( 'Comptant', 'nexo' ),
	'DESCRIPTION'	=>		__( 'Pour les commandes dont le montant perçu est supérieure ou également à la valeur réelle de la commande', 'nexo' )
) );

$this->db->insert( 'nexo_types_de_commandes', array(
	'DESIGN'		=>		__( 'Avance', 'nexo' ),
	'DESCRIPTION'	=>		__( 'Pour les commandes dont le montant perçu est supérieure à 0 et inférieure à la valeur réelle de la commande', 'nexo' )
) );

$this->db->insert( 'nexo_types_de_commandes', array(
	'DESIGN'		=>		__( 'Devis', 'nexo' ),
	'DESCRIPTION'	=>		__( 'Pour les commandes dont le montant perçu est égal à 0', 'nexo' )
) );

// Options
$this->load->model( 'Options' );
$this->options		=	new Options;
// Commande Comptant
$this->options->set( 'nexo_order_comptant', 1, true );

// Commande Avance
$this->options->set( 'nexo_order_advance', 2, true );

// Commande devis
$this->options->set( 'nexo_order_devis', 3, true );

$this->options->set( 'nexo_currency', '$', true );

$this->options->set( 'nexo_currency_position', 'before', true );

$this->options->set( 'default_payment_means', 1, true );

$this->options->set( 'nexo_enable_sound', 'enable' ); 

// Disabling discount
$this->options->set( 'discount_type', 'disable', true );