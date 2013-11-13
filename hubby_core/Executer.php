<?php
if(class_exists($Class))
{
	if($this->hubby->interpreter($Class,$Method,$Parameters) === '404')
	{
		$this->hubby->error('page404');
	}
}
else if(class_exists($Class.'_module_controller'))
{
	$theme			=&	$this->data['theme']; // Added - Hubby 0.9.2
	// GLOBAL MODULES
	$GlobalModule	=&	$this->data['GlobalModule'];
	if(is_array($GlobalModule))
	{
		foreach($GlobalModule as $g)
		{
			$this->hubby->interpreter($g['NAMESPACE'].'_module_controller',$Method,$Parameters,$this->data); // We do not control if there is 404 result.
		}
	}
	// BY PAGE MODULES
	$this->load->library('users_global');
	if(!array_key_exists('theme',$this->data))
	{
		$this->url->redirect(array('error','code','themeTrashed'));
		return false;
	}
	
	if($this->hubby->interpreter($Class.'_module_controller',$Method,$Parameters,$this->data) === '404')
	{
		$this->hubby->error('page404');
	}
}
else if(class_exists('hubby_'.$Class))
{
	if($this->hubby->interpreter('hubby_'.$Class,$Method,$Parameters) === '404')
	{
		$this->hubby->error('page404');
	}
}
else
{
	$this->hubby->error('page404');
}