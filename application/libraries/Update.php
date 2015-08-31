<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Update
{
	private $github_page	=	'https://github.com/Blair2004/tendoo-cms';
	
	function check()
	{
		include_once( APPPATH . 'libraries/Requests.php' );
		
		Requests::register_autoloader();
		
		$headers = array('Accept' => 'application/json');
		// $options = array('auth' => array('blair2004', 'Afromaster_2004'));
		$request = Requests::get('https://api.github.com/repos/blair2004/tendoo-cms/issues', $headers /* , $options */ );
		
		var_dump($request->status_code);
		// int(200)
		
		var_dump($request->headers['content-type']);
		// string(31) "application/json; charset=utf-8"
		
		var_dump($request->body);
		// string(26891) "[...]"
		// return file_get_contents( 'https://api.github.com/repos/blair2004/tendoo-cms/issues' );
	}
}