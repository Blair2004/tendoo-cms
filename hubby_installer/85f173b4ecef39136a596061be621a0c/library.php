<?php
class modus_lib
{
	public function __construct()
	{
		$this->core	=	Controller::instance();
	}
	public function updateNetworking($facebook,$twitter,$googleplus)
	{
		$query	=	$this->core->db->get('hubby_theme_modus_table');
		$result	=	$query->result_array();
		if(count($result) == 0)
		{
			if($this->core->db->insert('hubby_theme_modus_table',array(
				'FACEBOOK_ACCOUNT'		=>		$facebook,
				'TWITTER_ACCOUNT'		=>		$twitter,
				'GOOGLEPLUS_ACCOUNT'	=>		$googleplus
			)))
			{
				return 'done';
			}
		}
		else
		{
			if($this->core->db->update('hubby_theme_modus_table',array(
				'FACEBOOK_ACCOUNT'		=>		$facebook,
				'TWITTER_ACCOUNT'		=>		$twitter,
				'GOOGLEPLUS_ACCOUNT'	=>		$googleplus
			)))
			{
				return 'done';
			}
		}
		return 'error_occured';
	}
	public function getNetworking()
	{
		$query	=	$this->core->db->get('hubby_theme_modus_table');
		$result	=	$query->result_array();
		return (array_key_exists(0,$result)) ? $result[0] : array('FACEBOOK_ACCOUNT'=>'','TWITTER_ACCOUNT'=>'','GOOGLEPLUS_ACCOUNT'=>'');
	}
}