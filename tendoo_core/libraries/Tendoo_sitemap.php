<?php
class tendoo_sitemap
{
	public function __construct()
	{
		__extends($this); // getting tendoo code libs
		$this->__check_current_sitemap(); // check current site map.
	}
	public function __check_current_sitemap()
	{
		if(file_exists('sitemap.xml'))
		{
			$current_map			=	trim(file_get_contents('sitemap.xml'));
			$current_site_map		=	$this->create_sitemap_automatically(TRUE);
			$simulating_creation	=	trim($current_site_map);
			return;

			if($current_map != $simulating_creation)
			{
				$this->tendoo_admin->system_not(
					'V&eacute;rifiez votre sitemap', 
					'Le sitemap trouv&eacute; n\'est plus compatible avec l\'organisation de votre site web. Vous devez générer une autre.',
					$this->url->site_url(array('admin','tools','seo')), '10 mai 2013', null
				);
			}
		}
		else
		{
			$this->tendoo_admin->system_not(
				'V&eacute;rifiez vos outils', 
				'Votre site ne contient aucun sitemap. Veuillez cr&eacute;er un "sitemap" depuis l\'emplacement des param&egrave;tres.',
				$this->url->site_url(array('admin','tools','seo')), '10 mai 2013', null
			);
		}
	}
	function __loopController($controller,$priority = 1)
	{
		$body	=	'';
		foreach($controller as $r)
		{
			$body	.=	
'<url>
	<loc>'.$this->url->site_url(array($r['PAGE_CNAME'])).'</loc>
	<changefreq>daily</changefreq>
	<priority>'.$priority.'</priority>
</url>
';
			if(is_array($r['PAGE_CHILDS']))
			{
				$body.=	$this->__loopController($r['PAGE_CHILDS'],$priority / 2);
			}
		}
		return $body;
	}
	public function create_sitemap_automatically($return = FALSE)
	{
		$root_controller	=	$this->tendoo->get_pages(NULL,FALSE,FALSE);
		$sitemap_head		=	
'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
		$sitemap_end		=	'</urlset>';
		$sitemap_body		=	$this->__loopController($root_controller);
		
		if($return == FALSE)
		{
			file_put_contents('sitemap.xml',$sitemap_head.$sitemap_body.$sitemap_end);
			return true;
		}
		else
		{
			return $sitemap_head.$sitemap_body.$sitemap_end;
		}
	}
	public function create_sitemap_manually($content)
	{
		file_put_contents('sitemap.xml',$content);
	}
	public function getSitemap()
	{
		if(is_file('sitemap.xml'))
		{
			$file	=	file_get_contents('sitemap.xml');
			return $file;
		}
		return false;
	}
	public function remove_sitemap()
	{
		if(is_file('sitemap.xml'))
		{
			unlink('sitemap.xml');
		}
	}
}