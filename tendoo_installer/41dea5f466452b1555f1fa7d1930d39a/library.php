<?php
class tendoo_index_manager_library
{
	public function __construct()
	{
		__extends($this);
	}
	public function getOptions()
	{
		$query	=	$this->db->get('tendoo_index_manager');
		return $query->result_array();
	}
	public function setFirstOptions($showCarroussel,$showAboutUs,$showFeatures,$showGallery,$showLastest,$showPartners,$showSmallDetails,$showTabShowCase)
	{
		$options	=	$this->getOptions();
		$value		=	array(
				'SHOW_CAROUSSEL'		=>		in_array((int)$showCarroussel,array(1,0)) 	? $showCarroussel 	: 0,
				'SHOW_FEATURED'			=>		in_array((int)$showFeatures,array(1,0)) 	? $showFeatures 	: 0,
				'SHOW_GALLERY'			=>		in_array((int)$showGallery,array(1,0)) 		? $showGallery 		: 0,
				'SHOW_LASTEST'			=>		in_array((int)$showLastest,array(1,0)) 		? $showLastest 		: 0,
				'SHOW_PARTNERS'			=>		in_array((int)$showPartners,array(1,0)) 	? $showPartners 	: 0,
				'SHOW_SMALLDETAILS'		=>		in_array((int)$showSmallDetails,array(1,0)) ? $showSmallDetails	: 0,
				'SHOW_TABSHOWCASE'		=>		in_array((int)$showTabShowCase,array(1,0)) 	? $showTabShowCase 	: 0,
				'SHOW_ABOUTUS'			=>		in_array((int)$showAboutUs,array(1,0)) 	? $showAboutUs 	: 0,
		);
		if(count($options) > 0)
		{
			return	$this->db->update('tendoo_index_manager',$value);
		}
		else
		{
			return	$this->db->insert('tendoo_index_manager',$value);
		}
		return false;
	}
	public function setSecondOptions($aboutUsTitle,$partnersTitle,$galshowCaseTitle,$featuredTitle,$carousselTitle,$smallDetailsTItle,$tabShowCaseTitle,$lastestTitle)
	{
		$options	=	$this->getOptions();
		$values		=	array(
			'ABOUTUS_TITLE'				=>		$aboutUsTitle,
			'PARTNER_TITLE'				=>		$partnersTitle,
			'GALSHOWCASE_TITLE'			=>		$galshowCaseTitle,
			'FEATURED_TITLE'			=>		$featuredTitle,
			'LASTEST_TITLE'				=>		$lastestTitle,
			'CAROUSSEL_TITLE'			=>		$carousselTitle,
			'SMALLDETAIL_TITLE'			=>		$smallDetailsTItle,
			'TABSHOWCASE_TITLE'			=>		$tabShowCaseTitle
		);
		if(count($options) > 0)
		{
			return $this->db->update('tendoo_index_manager',$values);
		}
		else
		{
			return $this->db->insert('tendoo_index_manager',$values);
		}
		return false;
	}
	public function setThridOptions($onCaroussel,$onFeatured,$onGallery,$onLastest,$smallDetails,$onTabShowCase)
	{
		$options	=	$this->getOptions();
		$values		=	array(
			'ON_CAROUSSEL'		=>	$onCaroussel,
			'ON_FEATURED'		=>	$onFeatured,
			'ON_GALLERY'		=>	$onGallery,
			'ON_LASTEST'		=>	$onLastest,
			'ON_SMALLDETAILS'	=>	$smallDetails,
			'ON_TABSHOWCASE'	=>	$onTabShowCase
		);
		if(count($options) > 0)
		{
			return $this->db->update('tendoo_index_manager',$values);
		}
		else
		{
			return $this->db->insert('tendoo_index_manager',$values);
		}
	}
	public function setQuadOptions($abousUsText)
	{
		$options	=	$this->getOptions();
		$values		=	array(
			'ABOUTUS_CONTENT'		=>	$abousUsText
		);
		if(count($options) > 0)
		{
			return $this->db->update('tendoo_index_manager',$values);
		}
		else
		{
			return $this->db->insert('tendoo_index_manager',$values);
		}
	}
	public function setSixOptions($partnersText)
	{
		$options	=	$this->getOptions();
		$values		=	array(
			'PARTNERS_CONTENT'		=>	$partnersText
		);
		if(count($options) > 0)
		{
			return $this->db->update('tendoo_index_manager',$values);
		}
		else
		{
			return $this->db->insert('tendoo_index_manager',$values);
		}
	}
	public function setFiftOptions($carousselLimit,$featuredLimit,$lastestLimit,$galleryLimit,$tabShowCaseLimit,$smallDetailsLimit)
	{
		$options	=	$this->db->get('tendoo_index_manager');
		$values		=	array(
			'CAROUSSEL_LIMIT'		=>		$carousselLimit,
			'FEATURED_LIMIT'		=>		$featuredLimit,
			'GALLERY_LIMIT'			=>		$galleryLimit,
			'LASTEST_LIMIT'			=>		$lastestLimit,
			'SMALLDETAILS_LIMIT'	=>		$smallDetailsLimit,
			'TABSHOWCASE_LIMIT'		=>		$tabShowCaseLimit
		);
		if(count($options) > 0)
		{
			return $this->db->update('tendoo_index_manager',$values);
		}
		else
		{
			return $this->db->insert('tendoo_index_manager',$values);
		}
	}
	public function getApiModules() // permet la récupération de certains éléments d'un module.
	{
		$query	=	$this->db->where('HAS_API',1)->get('tendoo_modules');
		$result	=	$query->result_array();
		if($result)
		{
			$final	=	array();
			foreach($result as $module)
			{
				$file	=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/config/api_config.php';
				if(is_file($file))
				{
					include($file);
					foreach($API_CONFIG as $api)
					{
						$final[]	=	$api;
					}
				}
			}
			return $final;
		}
		return false;
	}
}