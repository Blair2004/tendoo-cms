<?php
class Shortcodes
{

    private $_ci;

    function __construct ()
    {
        $this->_ci = & get_instance();
    }

    public function parse ($str)
    {
        // Check for existing shortcodes
        if (! strstr($str, '[ai:')) {
            return $str;
        }
        
        // Find matches against shortcodes like [ai:user id=1|class=admin]
        preg_match_all('/\[ai:([a-zA-Z0-9-_: |=\.]+)]/', $str, $shortcodes);
        
        if ($shortcodes == NULL) {
            return $str;
        }
        
        // Tidy up
        foreach ($shortcodes[1] as $key => $shortcode) {
            if (strstr($shortcode, ' ')) {
                $code = substr($shortcode, 0, strpos($shortcode, ' '));
                $tmp = explode('|', str_replace($code . ' ', '', $shortcode));
                $params = array();
                if (count($tmp)) {
                    foreach ($tmp as $param) {
                        $pair = explode('=', $param);
                        $params[$pair[0]] = $pair[1];
                    }
                }
                $array = array('code' => $code, 'params' => $params);
            }
            else {
                $array = array('code' => $shortcode, 'params' => array());
            }
            
            $shortcode_array[$shortcodes[0][$key]] = $array;
        }
        
        // Replace shortcode instances with HTML strings
        if (count($shortcode_array)) {
            
            // Find the appropriate model for every shortcode, load it and call $model->run($params) | Useless on Tendoo
            $path = realpath('./application/models/shortcodes/') . '/';
            
            foreach ($shortcode_array as $search => $shortcode) {
                $shortcode_model = $shortcode['code'];
                if (file_exists($path . $shortcode_model . '.php') && is_file($path . $shortcode_model . '.php')) {
                    $this->_ci->load->model('shortcodes/' . $shortcode_model);
                    $str = str_replace($search, $this->_ci->$shortcode_model->run($shortcode['params']), $str);
                }
            
            }
        }
        
        // Return the entire parsed string
        return $str;
    }

}