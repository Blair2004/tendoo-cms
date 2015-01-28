<?php
class CustomQuery
{
	private $custom_queries	=	array(); // where every defined query are saved.
	
	function __construct( $config )
	{
		$this->db						=	get_db();
		$this->query_namespace			=	riake( 'namespace' , $config , 'default' ); // Default with title and content only.
	}
	/**
	 *	Set inset data to query
	 *	@access 	:	public
	 * 	@params 	:	string, string, array
	 *	@return		:	void()
	**/
	function set( $title , $content , $meta )
	{
		$this->db->insert( 'tendoo_query' , array(
			'TITLE'		=>	$title,
			'CONTENT'	=>	$content,
			'DATE'		=>	get_instance()->date->datetime(),
			'AUTHOR'	=>	current_user( 'ID' ),
			'NAMESPACE'	=>	$this->query_namespace
		) );
		$last_content	=	$this->db->where( 'NAMESPACE' , $this->query_namespace )->order_by( 'ID' , 'desc' )->get( 'tendoo_query' );
		if( ( $result	=	$last_content->result_array() ) == TRUE )
		{
			if( is_array( $meta ) )
			{
				foreach( $meta as $key =>	$value )
				{
					$this->db->insert( 'tendoo_query_meta' , array(
						'QUERY_REF_ID'	=>	$result[0][ 'ID' ],
						'KEY'			=>	$key,
						'VALUE'			=>	$value
					) );
				}
			}
		}
	}
	/**
	 * 	Get data from custom query
	 *	@access 	:	public
	 *	@params		:	Array/String
	 *	@return		:	Array/Boolean
	**/
	function get( $arg )
	{
		if( is_array( $arg ) )
		{
			// Filter Namespace
			$this->db->distinct( 'tendoo_query.ID' );
			$this->db->where( 'NAMESPACE' , $this->query_namespace );
			foreach( $arg as $filter =>	$value )
			{
				$filter_operator			=	!isset( $filter_operator ) ? 'AND' : $filter_operator; // default value
				if( in_array( $value , array( '&&' , '||' , 'OR' , 'AND' ) ) )
				{
					$filter_operator	=	in_array( $value , array( 'OR' , '||' ) )  ? $value : 'AND';
				} 
				else // Avoid using operator on query
				{
					if( in_array( strtoupper( $filter ) , array( 'TITLE' , 'CONTENT' , 'AUTHOR' , 'ID' ) ) )
					{
						if( in_array( $filter_operator , array( 'AND' , '&&' ) ) )
						{
							$this->db->where( $filter , $value );
						}
						else
						{
							$this->db->or_where( $filter , $value );
						}
					}
					else
					{
						if( in_array( $filter_operator , array( 'AND' , '&&' ) ) )
						{	
							$this->db->where( 'KEY' , $filter )->where( 'VALUE' , $value );
						}
						else
						{
							$this->db->or_where( 'KEY' , $filter )->where( 'VALUE' , $value );
						}
					}
				}
			}
			$this->db->from( 'tendoo_query' );
			$this->db->join( 'tendoo_query_meta' , 'tendoo_query.ID = tendoo_query_meta.QUERY_REF_ID' , 'right' );
			$result			=	$this->db->get();
			$result_array	=	array();
			if( $result->result_array() )
			{
				$result_array	=	$result->result_array();
				foreach( $result_array as $key => &$value )
				{
					$_key	=	riake( 'KEY' , $value ) != '' ? riake( 'KEY' , $value ) : false;
					$_val	=	riake( 'VALUE' , $value ) != '' ? riake( 'VALUE' , $value ) : false;
					
					if( riake( 'KEY' , $value ) ) :	unset( $value[ 'KEY' ] ); endif;
					if( riake( 'VALUE' , $value ) ) :	unset( $value[ 'VALUE' ] ); endif;
					
					$result_array[ $key ][ $_key ]	=	$_val;
				}
			}
			// Mergin Same result
			return $result_array;
		}
	}
}