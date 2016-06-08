<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once(APPPATH . '/libraries/REST_Controller.php');
include_once(APPPATH . '/models/rest/Rest_Tools.php');
include_once(APPPATH . '/models/rest/Rest_Users.php');
include_once(APPPATH . '/models/rest/Rest_Options.php');
include_once(APPPATH . '/models/rest/Rest_Modules.php');

class ApiParent extends Rest_Controller
{
    use Rest_Tools;
    use Rest_Users;
    use Rest_Options;
    use Rest_Modules;
    
    public function __construct()
    {
        parent::__construct();
    }
}
