<?php
class Notice
{
    /**
     * Notice class
     *
     * Save and enqueue notifications within a big array 
     * which can be outputed using "parse_notice" method.
    **/
    
    private $notice;
    
    public function __construct()
    {
        $this->notice = '';
    }
    
    /**
     * Push notification to Notice Array
     * 
     * @params Array
     * @return void
    **/
    
    public function push_notice($e)
    {
        $this->notice[]    =    $e;
    }
    
    /**
     * Push Notice notice into
     *
     *
    **/
    
    public function push_notice_array($notice_array)
    {
        if (is_array($notice_array)) {
            foreach (force_array($notice_array) as $notice) {
                $this->push_notice(get_instance()->lang->line($notice));
            }
        } else {
            $this->push_notice(get_instance()->lang->line($notice_array));
        }
    }
    
    /**
     * Output a notice
     * 
     * @params bool whether to return or not notices
     * @return void/bool
    **/
    
    public function output_notice($return = false)
    {
        if (is_array($this->notice)) {
            $final        =    '';
            foreach ($this->notice as $n) {
                if ($return == false) {
                    if (is_callable($n)) {
                        $n();
                    } else {
                        echo $n;
                    };
                } else {
                    if (is_callable($n)) {
                        ob_start();
                        $n();
                        $final    .=    ob_get_clean();
                    } else {
                        $final    .=    $n;
                    };
                }
            }
            return $final;
        } else {
            return $this->notice;
        }
    }
    
    /**
     * Return notice array
     * 
     * @return array
    **/
    
    public function get_notice_array()
    {
        return $this->notice;
    }
}
