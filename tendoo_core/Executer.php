<?php
if(class_exists($Class))
{
	if($this->tendoo->interpreter($Class,$Method,$Parameters) === '404')
	{
		$this->tendoo->error('page404');
	}
	// var_dump($this->db);
}
else if(class_exists($Class.'_module_controller'))
{
	if($Teurmola[0] == 'tendoo')
	{
		$this->data['page'] 		=		array(array(
			'PAGE_NAME'				=>		'Tendoo Url Module Launcher',
			'PAGE_CNAME'			=>		$Teurmola[0].'@'.$Teurmola[1],
			'PAGE_TITLE'			=>		'Tendoo Url Module Launcher',
			'PAGE_DESCRIPTION'		=>		'',
			'PAGE_MAIN'				=>		'FALSE',
			'PAGE_PARENT'			=>		'FALSE'
		));
		$this->load->library('users_global'); // 0.9.4
		$theme						=&	$this->data['theme']; // Added - Tendoo 0.9.2
		// GLOBAL MODULES
		$GlobalModule				=&	$this->data['GlobalModule'];
		if(is_array($GlobalModule))
		{
			foreach($GlobalModule as $g)
			{
				$this->tendoo->interpreter($g['NAMESPACE'].'_module_controller',$Method,$Parameters,$this->data); // We do not control if there is 404 result.
			}
		}
		// BY PAGE MODULES
		if(!array_key_exists('theme',$this->data))
		{
			$this->url->redirect(array('error','code','themeCrashed'));
			return false;
		}
		if($this->tendoo->interpreter($Class.'_module_controller',$Method,$Parameters,$this->data) === '404')
		{
			$this->tendoo->error('page404');
		}
	}
	else
	{
		$this->load->library('users_global'); // 0.9.4
		$theme			=&	$this->data['theme']; // Added - Tendoo 0.9.2
		// GLOBAL MODULES
		$GlobalModule	=&	$this->data['GlobalModule'];
		if(is_array($GlobalModule))
		{
			foreach($GlobalModule as $g)
			{
				$this->tendoo->interpreter($g['NAMESPACE'].'_module_controller',$Method,$Parameters,$this->data); // We do not control if there is 404 result.
			}
		}
		// BY PAGE MODULES
		if(!array_key_exists('theme',$this->data))
		{
			$this->url->redirect(array('error','code','themeCrashed'));
			return false;
		}
		
		if($this->tendoo->interpreter($Class.'_module_controller',$Method,$Parameters,$this->data) === '404')
		{
			$this->tendoo->error('page404');
		}
	}
}
else if(class_exists('Tendoo_'.$Class))
{
	if($this->tendoo->interpreter('Tendoo_'.$Class,$Method,$Parameters) === '404')
	{
		$theme						=&	$this->data['theme']; // Added - Tendoo 0.9.2
		// GLOBAL MODULES
		$this->tendoo->error('page404');
	}
}
else
{
	$this->tendoo->error('page404');
}