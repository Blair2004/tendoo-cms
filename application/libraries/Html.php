<?php
class Html
{
	private $page_title ;
	private $page_description;
	
	function __construct()
	{
		$this->page_title	=	__( 'Untitled Page' );
	}
	
	/**
	 * 	Get Title
	 * @access : public
	 * @return : string
	**/
	
	function get_title()
	{
		return $this->page_title;
	}
	
	/**
	 * Set title
	 *
	 * Set page title
	 *
	 * @access : public
	 * @param : string
	 * @return : void
	**/
	
	function set_title( $title )
	{
		$this->page_title	=	$title;
	}
	
	/**
	 * title
	 *
	 * Returns title tag with defined title
	 * 
	 * @access : public
	 * @return : string
	**/
	
	function title()
	{
		?>
        <title><?php echo $this->page_title;?></title>
        <?php
	}
	
	/**
	 * Page Description
	 * 
	 * @access : public
	 * @param : string page description
	 * @return : void
	**/
	
	function set_description( $description )
	{
		$this->page_description	=	$description;
	}
	
	/**
	 * Get page description
	 * 
	 * @access : public
	 * @return : string page description
	**/
	
	function get_description()
	{
		return $this->page_description;
	}
}