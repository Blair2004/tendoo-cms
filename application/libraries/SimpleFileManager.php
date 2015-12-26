<?php
/** 
 * Simple file manager, copied from 1.4 tendoo branch
**/
class SimpleFileManager 
{
	static function drop($source)
	{
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
						self::drop($source.'/'.$content);
					}
				}
				closedir($open);
			}
			rmdir($source);
		}
		return true;
	}
	static function extractor($source,$destination,$dir_limit = 10)
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
						copy( str_replace( '//', '/', $source.'/'.$content ), str_replace( '//', '/', $destination.'/'.$content ) );
						unlink( str_replace( '//', '/', $source.'/'.$content ) );
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						if($dir_limit > 0)
						{
							if(!is_dir($destination.'/'.$content))
							{
								mkdir( str_replace( '//', '/', $destination.'/'.$content ) );
							}
							self::extractor($source.'/'.$content,$destination.'/'.$content,$dir_limit-1);
						}
						else
						{
							self::drop($source.'/'.$content);
						}
					}
				}
				closedir($open);
			}
		}
		if(!rmdir($source))
		{
			self::drop($source);
		}
	}
	static function file_copy( $source , $destination )
	{
		if( is_file( $source ) )
		{
			$file_content	=	file_get_contents( $source );
			
			// Checks if all directory exists
			$path_explode 	=	explode( DIRECTORY_SEPARATOR , $destination );
			$path_progressive	=	'';
			foreach( $path_explode as $index => $file ){
				// last index is not handled
				if( $index < count( $path_explode ) - 1 )
				{
					$path_progressive	.= $file . DIRECTORY_SEPARATOR;
					if( ! is_dir( $path_progressive ) )
					{
						mkdir( str_replace( '//', '/', $path_progressive ) );
					}
				}
			}
			file_put_contents( $destination , $file_content );			
		}
		return false;
	}
	static function copy($source,$destination,$dir_limit = 10)
	{
		if(!is_dir($destination))
		{
			mkdir($destination);
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
					}
					if(is_dir($source.'/'.$content) && !in_array($content,array('..','.')))
					{
						if($dir_limit > 0)
						{
							if(!is_dir($destination.'/'.$content))
							{
								mkdir($destination.'/'.$content);
							}
							self::copy($source.'/'.$content,$destination.'/'.$content,$dir_limit-1);
						}
					}
				}
				closedir($open);
			}
		}
	}
}