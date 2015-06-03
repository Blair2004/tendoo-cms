<?php
if( class_exists($Class.'_frontend') )
{
	/**
	 * @since 1.4
	 * Launch bound events to "before_frontend" hook.
	**/
	
	trigger_events( 'before_frontend' );
	
	// Ce module utilisent l'obect get_core_vars( 'active_theme_object' ); et génèrent une vue.
	if($this->tendoo->interpreter( $Class . '_frontend' , $Method , $Parameters , array() , get_core_vars('module') ) === '404' )
	{
		$this->tendoo->error( 'page-404' );
	}
}
else if(class_exists('Tendoo_'.$Class))  // not deprecated
{
	if($this->tendoo->interpreter('Tendoo_'.$Class,$Method,$Parameters) === '404')
	{
		$theme						=	get_core_vars('active_theme_object'); // Added - Tendoo 0.9.2
		// GLOBAL MODULES
		$this->tendoo->error('page-404');
	}
}
else if(class_exists($Class))
{
	if($this->tendoo->interpreter($Class,$Method,$Parameters) === '404')
	{
		$this->tendoo->error('page-404');
	}
}
else
{
	$this->tendoo->error('page-404-or-module-bug');
}