<?php 
class tendoo_update
{
	// Expect tendoo_code
	function __construct(){
		__extends($this);
	}
	function getUpdateCoreNotification(){
		if(file_exists('tendoo_core/exec_file.php'))
		{
			include('tendoo_core/exec_file.php');
			ob_clean(); // Dans le cas ou il y aurait une réponse dans le fichier.
			// Find Warning
			$array								=	array();
			$array['tendoo_core_warning']		=	$tendoo_core_warning; // if exists
			$array['tendoo_themes_warning']		=	$tendoo_themes_warning; // if exists
			$array['tendoo_modules_warning']	=	$tendoo_modules_warning;
			$array['tendoo_security_warning']	=	$tendoo_security_warning;
			return $array;
		}
		return false;
	}
	/**
		Mise à jour du système sans affecter les modules. peut rendre certains modules incompatible.
		Opère suppression des dossiers "tendoo_assets" et "tendoo_core" et "index.php" remplacé par la version téléchargée.
	**/
	function updateCore(){
		
	}
}