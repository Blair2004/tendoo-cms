<?php
trait Rest_Modules
{
    public function module_get($id = null)
    {
        $this->load->library('modules');

        Modules::load(MODULESPATH);
        $this->response(( array ) Modules::get($id), 200);
    }
}
