<?php
class Curl
{
    private $co;
    private $options;
    private $userAgent;
    private $stylish;
    private $loadImage    =    true;
    private $returnContent= true;
    public function __construct()
    {
        if (function_exists('curl_init')) {
            $this->co        =    curl_init();
        } else {
            get_instance()->tendoo->error("curl_is_not_set");
            die();
        }
    }

    /**
     * Set Option
     *
     * @param Array object
     * @param string value
    **/

    public function _setOpt($opts, $value)
    {
        curl_setopt($this->co, $opts, $value);
        return $this;
    }

    /**
     * Show Image
     *
     * @param bool
     * @return void
    **/

    public function showImg($e)
    {
        if (is_bool($e)) {
            $this->loadImage = $e;
        }
    }

    /**
     * Exec Curl
     *
     * @return void
    **/

    public function _exec()
    {
        if (!isset($this->userAgent)) {
            curl_setopt($this->co, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
        } else {
            curl_setopt($this->co, CURLOPT_USERAGENT, $this->userAgent);
        }
        if ($this->stylish == true) {
            curl_exec($this->co);
            $content = ob_get_contents();
            if ($this->returnContent == true) {
                return $content;
            } else {
                echo xss_clean($content);
            }
        } else {
            ob_start();
            curl_exec($this->co);
            $content = ob_get_contents();
            ob_end_clean();
            $content    =    preg_replace('#<link(.+)/>#', '', $content);
            $content    =    preg_replace('#<script(.+)>(.+)</script>#', '', $content);
            if ($this->loadImage != true) {
                $content    =    preg_replace('/<img[^>]+\>/i', '', $content);
            }
            if ($this->returnContent == true) {
                return $content;
            } else {
                echo xss_clean($content);
            }
        }
    }

    /**
     * Set user Agent
     *
     * @param string agent name
     * @return void
    **/

    public function userAgent($userAgent)
    {
        $this->userAgent    =    $userAgent;
    }

    /**
     * Set follow to CURL
     * @return void
    **/

    public function follow($e)
    {
        if (is_bool($e)) {
            $this->_setOpt(CURLOPT_FOLLOWLOCATION, $e);
        }
    }

    /**
     * Load Style
     *
     * @return void
    **/

    public function stylish($e)
    {
        is_bool($e)? $this->stylish = $e : $this->stylish = false;
    }

    /**
     * Post
     *
     * @param string Url
     * @param Array definition
     * @return obj exect object
    **/

    public function post($url, $data)
    {
        $this->_setOpt(CURLOPT_URL, $url);
        $this->_setOpt(CURLOPT_POST, 1);
        $this->_setOpt(CURLOPT_POSTFIELDS, $data);
        return $this->_exec();
    }

    /**
     * Get CURL content
     *
     * @param string Url
     * @return bool
    **/

    public function get($url)
    {
        $this->_setOpt(CURLOPT_URL, $url);
        return $this->_exec();
    }

    /**
     * Enable Security
     *
     * @param bool
     * @return Object
    **/

    public function security($option)
    {
        if (is_bool($option)):$this->_setOpt(CURLOPT_SSL_VERIFYPEER, $option);
        endif;
        return $this;
    }

    /**
     * Update User Permission
     *
     * @param int user id,
     * @param string name
     * @param string definition
     * @return bool
    **/

    public function returnContent($e)
    {
        if (is_bool($e)) {
            $this->returnContent = $e;
        }
    }

    /**
     * User Password
     * @param string user password
     * @return obj current object
    **/

    public function set_password($string)
    {
        curl_setopt($this->co, CURLOPT_USERPWD, $string);
        return $this;
    }
}
