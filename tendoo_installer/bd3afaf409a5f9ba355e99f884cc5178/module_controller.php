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
					$this->data['theme']->defineRightWidget($w['WIDGET_TITLE'],$w['WIDGET_PARAMETERS']);
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
							array(), // valeur envoyé au controlleur d widget.
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
					$this->data['theme']->defineBottomWidget($w['WIDGET_TITLE'],$w['WIDGET_PARAMETERS']);
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
							array(), // valeur envoyé au controlleur d widget.
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
		
		return;
		if(count($this->data['ttActivWid']) > 0 && is_array($this->data['ttActivWid']))
		{
			foreach($this->data['ttActivWid'] as $w) // Récupération des widgets activé depuis l'espace d'admin (ESAD)
			{
				if($w['WIDGET_REFERING_OBJ_NAMESPACE'] == '') // Si aucun module n'est indexé, alors c un simple widget.
				{
					$this->data['theme']->defineWidget($w['WIDGET_HEAD'],$w['WIDGET_CONTENT']);
				}
				else // Sinon
				{
					$module			=	$this->instance->tendoo->getSpeMod($w['WIDGET_REFERING_OBJ_NAMESPACE'],FALSE); // Recuperation du module en question
					$module			=&	$module[0];	// Modification de la variable.
					$path			=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/'; // Chemin d'accès
					$configFile		=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/config/widget_config.php'; // Chemin d'accès configuration
					if(is_file($configFile)) // Test sur l'exitence des fichiers.
					{
						include_once($configFile); // Intégration des fichiers testé
						if(array_key_exists($w['WIDGET_REFERING_NAME'],$WIDGET_CONFIG)) // verification sur l'existence de la clé porteuse d'un tableau
						{
							$WIDGET_CONFIG[$w['WIDGET_REFERING_NAME']]['WIDGET_MODULE']		=&	$module; // AJoute le module concerné au widget
							$WIDGET_CONFIG[$w['WIDGET_REFERING_NAME']]['WIDGET_INFO']		=&	$w; // Ajoute les informations spécifies par l'utilisatuer
							$this->data['currentWidget']	=&	$WIDGET_CONFIG[$w['WIDGET_REFERING_NAME']]; // Ajoute les informations sur widget au super tablea $this->data, qui sera utilisé plus tard.
							include_once($path.$WIDGET_CONFIG[$w['WIDGET_REFERING_NAME']]['WIDGET_FILES']); // Include widget controller;
							$w_output	=	$this->instance->tendoo->interpreter(
								$w['WIDGET_REFERING_NAME'].'_'.$module['NAMESPACE'].'_common_widget',
								'index',
								array(), // valeur envoyé au controlleur d widget.
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
}
?>