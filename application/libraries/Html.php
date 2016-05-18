<?php
class Html
{
    private static $page_title = 'Untitled Page';
    private static $page_description;
    
    /**
     * 	Get Title
     * @access : public
     * @return : string
    **/
    
    public static function get_title()
    {
        return self::$page_title;
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
    
    public static function set_title($title)
    {
        self::$page_title    =    $title;
    }
    
    /**
     * title
     *
     * Returns title tag with defined title
     * 
     * @access : public
     * @return : string
    **/
    
    public static function title()
    {
        ?>
        <title><?php echo xss_clean(self::$page_title);
        ?></title>
        <?php

    }
    
    /**
     * Page Description
     * 
     * @access : public
     * @param : string page description
     * @return : void
    **/
    
    public static function set_description($description)
    {
        self::$page_description    =    $description;
    }
    
    /**
     * Get page description
     * 
     * @access : public
     * @return : string page description
    **/
    
    public static function get_description()
    {
        return self::$page_description;
    }
}
