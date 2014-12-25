<?php
class custom_query
{
	private $custom_queries	=	array(); // where every defined query is saved.
	
	function __construct( $config )
	{
		$custom_query_namespace			=	riake( 'namespace' , $config , 'default' ); // Default with title and content only.
	}
	function set_custom_query( $query_namespace , $custom_field )
	{
		$queries						=	force_array( get_core_vars( 'defined_custom_queries' ) );
		$queries[ $query_namespace ]	= 	array(
			'namespace'					=>		$query_namespace,
			'fields'					=>		$field
		);
	}
}