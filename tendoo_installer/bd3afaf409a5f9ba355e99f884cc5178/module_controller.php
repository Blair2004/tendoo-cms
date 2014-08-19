<?php
class tendoo_widget_administrator_module_controller
{
	protected 	$data;
	private 	$news;
	private 	$core;
	private 	$tendoo;
	
	public function __construct($data)
	{
		$this->instance					=		get_instance();
		$this->data					=		$data;
		$this->tendoo				=&		$this->instance->tendoo;
		$this->lib					=		new widhandler_common($this->data);
		$this->data['widgetHandler']=&		$this->lib;
		$this->data['getRightWidget']=		$this->lib->getWidgets('RIGHT');
		// var_dump($this->data['getRightWidget']);
		foreach($this->data['getRightWidget'] as $w)
		{
			// Get System Widget
			if(strtolower($w['WIDGET_MODNAMESPACE']) == 'system')
			{
				if($w['WIDGET_NAMESPACE'] == 'texte')
				{
					set_widget( "right" , $w['WIDGET_TITLE'] , $w['WIDGET_PARAMETERS'] , "text" );
				}
			}
			else 
			{
				$module				=	$this->tendoo->getSpeModuleByNamespace($w['WIDGET_MODNAMESPACE']);
				$module				=&	$module[0];	// Modification de la variable.
				$configFile			=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/config/widget_config.php';
				$path				=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/'; // Chemin d'accès
				if(is_file($configFile)) // Test sur l'exitence des fichiers.
				{
					include_once($configFile); // Intégration des fichiers testé
					if(array_key_exists($w['WIDGET_NAMESPACE'],$WIDGET_CONFIG)) // verification sur l'existence de la clé porteuse d'un tableau
					{
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_MODULE']		=&	$module; // AJoute le module concerné au widget
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_INFO']		=&	$w; // Ajoute les informations spécifies par l'utilisatuer
						$this->data['currentWidget']								=&	$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]; // Ajoute les informations sur widget au super tablea $this->data, qui sera utilisé plus tard.
						$this->data['widgets']['requestedZone']						=	'RIGHT'; // Set Requested Zone
						include_once($path.$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_FILES']); // Include widget controller;
						$w_output	=	$this->instance->tendoo->interpreter(
							$w['WIDGET_NAMESPACE'].'_'.$w['WIDGET_MODNAMESPACE'].'_common_widget',
							'index',
							array(),
							$this->data					
						);
					}
				}
				else
				{
					$this->instance->notice->push_notice('<strong>Une erreur s\'est produite durant le chargement des widgets');
				}
				
			}
		}
		// Bottom widgets
		$this->data['getBottomWidget']=		$this->lib->getWidgets('BOTTOM');
		// var_dump($this->data['getRightWidget']);
		foreach($this->data['getBottomWidget'] as $w)
		{
			if(strtolower($w['WIDGET_MODNAMESPACE']) == 'system')
			{
				if($w['WIDGET_NAMESPACE'] == 'texte')
				{
					set_widget( "bottom" , $w['WIDGET_TITLE'] , $w['WIDGET_PARAMETERS'] , "text" );
				}
			}
			else
			{
				$module				=	$this->tendoo->getSpeModuleByNamespace($w['WIDGET_MODNAMESPACE']);
				$module				=&	$module[0];	// Modification de la variable.
				$configFile			=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/config/widget_config.php';
				$path				=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/'; // Chemin d'accès
				if(is_file($configFile)) // Test sur l'exitence des fichiers.
				{
					include_once($configFile); // Intégration des fichiers testé
					if(array_key_exists($w['WIDGET_NAMESPACE'],$WIDGET_CONFIG)) // verification sur l'existence de la clé porteuse d'un tableau
					{
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_MODULE']		=&	$module; // AJoute le module concerné au widget
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_INFO']		=&	$w; // Ajoute les informations spécifies par l'utilisatuer
						$this->data['currentWidget']								=&	$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]; // Ajoute les informations sur widget au super tablea $this->data, qui sera utilisé plus tard.
						$this->data['widgets']['requestedZone']						=	'BOTTOM'; // Set Requested Zone
						include_once($path.$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_FILES']); // Include widget controller;
						$w_output	=	$this->instance->tendoo->interpreter(
							$w['WIDGET_NAMESPACE'].'_'.$w['WIDGET_MODNAMESPACE'].'_common_widget',
							'index',
							array(),
							$this->data
						);
					}
				}
				else
				{
					$this->instance->notice->push_notice('<strong>Une erreur s\'est produite durant le chargement des widgets');
				}
			}
		}
		// End Bootom widgets
		$this->data['getLeftWidget']=		$this->lib->getWidgets('LEFT');
		foreach($this->data['getLeftWidget'] as $w)
		{
			if(strtolower($w['WIDGET_MODNAMESPACE']) == 'system')
			{
				if($w['WIDGET_NAMESPACE'] == 'texte')
				{
					set_widget( "left" , $w['WIDGET_TITLE'] , $w['WIDGET_PARAMETERS'] , "text" );
				}
			}
			else
			{
				$module				=	$this->tendoo->getSpeModuleByNamespace($w['WIDGET_MODNAMESPACE']);
				$module				=&	$module[0];	// Modification de la variable.
				$configFile			=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/config/widget_config.php';
				$path				=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/'; // Chemin d'accès
				if(is_file($configFile)) // Test sur l'exitence des fichiers.
				{
					include_once($configFile); // Intégration des fichiers testé
					if(array_key_exists($w['WIDGET_NAMESPACE'],$WIDGET_CONFIG)) // verification sur l'existence de la clé porteuse d'un tableau
					{
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_MODULE']		=&	$module; // AJoute le module concerné au widget
						$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_INFO']		=&	$w; // Ajoute les informations spécifies par l'utilisatuer
						$this->data['currentWidget']								=&	$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]; // Ajoute les informations sur widget au super tablea $this->data, qui sera utilisé plus tard.
						$this->data['widgets']['requestedZone']						=	'BOTTOM'; // Set Requested Zone
						include_once($path.$WIDGET_CONFIG[$w['WIDGET_NAMESPACE']]['WIDGET_FILES']); // Include widget controller;
						$w_output	=	$this->instance->tendoo->interpreter(
							$w['WIDGET_NAMESPACE'].'_'.$w['WIDGET_MODNAMESPACE'].'_common_widget',
							'index',
							array(),
							$this->data
						);
					}
				}
				else
				{
					$this->instance->notice->push_notice('<strong>Une erreur s\'est produite durant le chargement des widgets');
				}
			}
		}
	}
}
?>