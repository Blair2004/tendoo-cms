<?php
class tendoo_file_manager
{
	public function __construct()
	{
		__extends($this);
	}
	private $system_dir	=	array('tendoo_themes/','tendoo_core/','tendoo_installer/','tendoo_modules/','tendoo_assets/');
	private function drop($source)
	{
		if(in_array($source,$this->system_dir))
		{
			return false;
		}
		if(is_dir($source))
		{
			if($open	=	opendir($source))
			{
				while(($content	=	readdir($open)) !== FALSE)
				{
					if(is_file($source.'/'.$content))
					{
						unlink($source.'/'.$content);
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						$this->drop($source.'/'.$content);
					}
				}
				closedir($open);
			}
			rmdir($source);
		}
	}
	private function extractor($source,$destination,$dir_limit = 10)
	{
		if(!is_dir($destination))
		{
			mkdir($destination);
		}
		if(is_file($source))
		{
			copy($source,$destination);
			unlink($source);
		}
		if(is_dir($source))
		{
			if($open	=	opendir($source))
			{
				while(($content	=	readdir($open)) !== FALSE)
				{
					if(is_file($source.'/'.$content))
					{
						copy($source.'/'.$content,$destination.'/'.$content);
						unlink($source.'/'.$content);
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						if($dir_limit > 0)
						{
							if(!is_dir($destination.'/'.$content))
							{
								mkdir($destination.'/'.$content);
							}
							$this->extractor($source.'/'.$content,$destination.'/'.$content,$dir_limit-1);
						}
						else
						{
							$this->drop($source.'/'.$content);
						}
					}
				}
				closedir($open);
			}
		}
		if(!rmdir($source))
		{
			$this->drop($source);
		}
	}
	
}