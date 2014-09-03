<?php
class hierarchy_pages_editor_common_widget
{
	public function __construct($data)
	{
		$this->instance		=	get_instance();
		__extends( $this );
		$this->data			=&	$data;
		$this->theme		=	get_core_vars('active_theme_object');
		$this->location		=	MODULES_DIR.$this->data['currentWidget']['WIDGET_MODULE']['ENCRYPTED_DIR'];
		if(!class_exists('page_library'))
		{
			include_once($this->location.'/library.php');
		}
		$this->lib			=	new page_library;
		$page_hierarchy		=	$this->lib->get_pages( 'filter_parents_active' );
		$this->widget_info	=	return_if_array_key_exists( 'WIDGET_INFO' , $this->data[ 'currentWidget' ] );
		$this->limitation	=	(int)return_if_array_key_exists( 'WIDGET_PARAMETERS' , $this->widget_info );
		
		$final_code		=	'<ul>';
		if( is_array( $page_hierarchy ) ){
			foreach( $page_hierarchy as $_pages ){
				$final_code .= $this->loop_pages( $_pages );
			}
		}
		$final_code		.=	'</ul>';
		// For Zones
		if(in_array($this->data['widgets']['requestedZone'],array('LEFT','BOTTOM','RIGHT')))
		{
			$widget_title	=	$this->data['currentWidget'][ 'WIDGET_INFO' ][ 'WIDGET_TITLE' ];
			$zone			=	$this->data['widgets']['requestedZone']; // requestedZone
			set_widget( strtolower($zone) , $widget_title , $final_code , 'text' );
		}
	}
	private function loop_pages( $page , $limitation = 0)
	{
		if( $this->limitation > $limitation || $this->limitation = 'show_all' ){
			$line_code = '<li>';
				$line_code .= '<a href="'.get_instance()->url->site_url( $page[ 'THREAD' ] ).'">' . return_if_array_key_exists( 'TITLE' , $page ) . '</a>';
				if( count( $page[ 'CHILDS' ] ) > 0 ){
					$line_code .= '<ul>';
					$current_level	=	$limitation + 1;
					foreach( $page[ 'CHILDS' ]  as $_page ){
						$line_code.=	$this->loop_pages( $_page , $current_level );
					}
					$line_code .= '</ul>';
				}
			$line_code .= '</li>';
			return $line_code;
		}
	}
}