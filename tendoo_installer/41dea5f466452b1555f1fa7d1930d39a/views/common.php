<?php 
if(is_array($lib_options) && count($lib_options) > 0)
{
	$o	=&	$lib_options[0];
	function api_retreiver($mod_namespace,$api_namespace,$mod_namespace_data,$limit)
	{
		if($mod_namespace_data) // Le module existe
		{
			$mod_folder		=	MODULES_DIR.$mod_namespace_data[0]['ENCRYPTED_DIR'];
			$config_file	=	$mod_folder.'/config/api_config.php';
			if(is_file($config_file)) // Le fichie de config api existe
			{
				include($config_file);
				if(is_array($API_CONFIG)) // Le table est existant
				{
					if(count($API_CONFIG) > 0) // il contient des éléments
					{
						if(array_key_exists($api_namespace,$API_CONFIG))
						{
							$api_file	=	$mod_folder.$API_CONFIG[$api_namespace]['API_CLASS_FILE'];
							if(is_file($api_file)) // le fichier indiqué existe
							{
								include_once($api_file);
								$params	=	array( // prépare quelque information utile pour l'objet
									'MODULE_NAMESPACE_DATA'	=>	$mod_namespace_data,
									'MODULE_DIR'			=>	$mod_folder
								);
								eval('$executer	=	new '.$mod_namespace.'_'.$api_namespace.'_api($params);');
								return $retreived		=	$executer->getDatas($limit);
							}
						}
					}
				}
				
			}
			return false;
		}
	}
	if($o['SHOW_CAROUSSEL'] == '1')
	{
		$datas				=	explode('/',$o['ON_CAROUSSEL']);
		$mod_namespace		=	$datas[0];
		$api_namespace		=	$datas[1];
		$mod_namespace_data	=	$this->instance->tendoo->getSpeModuleByNamespace($mod_namespace);
		$api_data			=	api_retreiver($mod_namespace,$api_namespace,$mod_namespace_data,$o['CAROUSSEL_LIMIT']);
		if(is_array($api_data))
		{
			$theme->defineCarousselTitle($o['CAROUSSEL_TITLE']);
			foreach($api_data as $a)
			{
				$theme->defineCaroussel(
					$a['TITLE'],
					$a['CONTENT'],
					$a['THUMB'],
					$a['LINK'],
					null
				);
			}
		}
	}
	if($o['SHOW_FEATURED'] == '1')
	{
		if($o['ON_FEATURED'] != '')
		{
			$datas				=	explode('/',$o['ON_FEATURED']);
			$mod_namespace		=	$datas[0];
			$api_namespace		=	$datas[1];
			$mod_namespace_data	=	$this->instance->tendoo->getSpeModuleByNamespace($mod_namespace);
			$api_data			=	api_retreiver($mod_namespace,$api_namespace,$mod_namespace_data,$o['FEATURED_LIMIT']);
			if(is_array($api_data))
			{
				$theme->defineOnTopContentTitle($o['FEATURED_TITLE']);
				foreach($api_data as $a)
				{
					$theme->defineOnTopContent($a['THUMB'],$a['TITLE'],$a['CONTENT'],$a['LINK'],$a['DATE']);
				}
			}
		}
	}
	if($o['ABOUTUS_CONTENT'] != '')
	{
		$theme->defineIndexAboutUsTitle($o['ABOUTUS_TITLE']);
		$theme->defineIndexAboutUs($o['ABOUTUS_CONTENT']);
	}
	if($o['SHOW_LASTEST'] == '1')
	{
		if($o['ON_LASTEST'] != '')
		{
			$datas				=	explode('/',$o['ON_LASTEST']);
			$mod_namespace		=	$datas[0];
			$api_namespace		=	$datas[1];
			$mod_namespace_data	=	$this->instance->tendoo->getSpeModuleByNamespace($mod_namespace);
			$api_data			=	api_retreiver($mod_namespace,$api_namespace,$mod_namespace_data,$o['LASTEST_LIMIT']);
			if(is_array($api_data))
			{
				$theme->defineLastestElementsTitle($o['LASTEST_TITLE']);
				foreach($api_data as $a)
				{
					$theme->defineLastestElements($a['THUMB'],$a['TITLE'],$a['CONTENT'],$a['LINK'],$a['DATE']);
				}
			}
		}
	}
	if($o['SHOW_SMALLDETAILS'] == '1')
	{
		if($o['ON_SMALLDETAILS'] != '')
		{
			$datas				=	explode('/',$o['ON_SMALLDETAILS']);
			$mod_namespace		=	$datas[0];
			$api_namespace		=	$datas[1];
			$mod_namespace_data	=	$this->instance->tendoo->getSpeModuleByNamespace($mod_namespace);
			$api_data			=	api_retreiver($mod_namespace,$api_namespace,$mod_namespace_data,$o['SMALLDETAILS_LIMIT']);
			if(is_array($api_data))
			{
				$theme->defineTextListTitle($o['SMALLDETAIL_TITLE']);
				foreach($api_data as $a)
				{
					$theme->defineTextList($a['TITLE'],$a['CONTENT'],$a['THUMB'],$a['LINK'],$a['DATE']);
				}
			}
		}
	}
	if($o['SHOW_TABSHOWCASE'] == '1')
	{
		if($o['ON_TABSHOWCASE'] != '')
		{
			$datas				=	explode('/',$o['ON_TABSHOWCASE']);
			$mod_namespace		=	$datas[0];
			$api_namespace		=	$datas[1];
			$mod_namespace_data	=	$this->instance->tendoo->getSpeModuleByNamespace($mod_namespace);
			$api_data			=	api_retreiver($mod_namespace,$api_namespace,$mod_namespace_data,$o['TABSHOWCASE_LIMIT']);
			if(is_array($api_data))
			{
				$theme->defineTabShowCaseTitle($o['TABSHOWCASE_TITLE']);
				foreach($api_data as $a)
				{
					$theme->defineTabShowCase($a['TITLE'],$a['CONTENT']);
				}
			}
		}
	}
	if($o['SHOW_GALLERY'] == '1')
	{
		if($o['ON_GALLERY'] != '')
		{
			$datas				=	explode('/',$o['ON_GALLERY']);
			$mod_namespace		=	$datas[0];
			$api_namespace		=	$datas[1];
			$mod_namespace_data	=	$this->instance->tendoo->getSpeModuleByNamespace($mod_namespace);
			$api_data			=	api_retreiver($mod_namespace,$api_namespace,$mod_namespace_data,$o['GALLERY_LIMIT']);
			if(is_array($api_data))
			{
				$theme->defineGalleryShowCaseTitle($o['GALSHOWCASE_TITLE']);
				foreach($api_data as $a)
				{
					$theme->defineGalleryShowCase($a['TITLE'],$a['CONTENT'],$a['THUMB'],$a['THUMB'],$a['LINK'],$a['DATE']);
				}
			}
		}
	}
	if($o['SHOW_PARTNERS'] == '1')
	{
		$theme->definePartnersTitle($o['PARTNER_TITLE']);
		$theme->definePartnersContent($o['PARTNERS_CONTENT']);
	}
	$theme->parseIndex();
}
