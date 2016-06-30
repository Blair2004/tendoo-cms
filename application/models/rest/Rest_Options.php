<?php
trait Rest_Options
{
    public function option_get($var = null, $user_id = null)
    {
        if ($user_id != null) {
            $this->db->where('user', $user_id);
        }
        
        if ($var != null) {
            $this->db->where('key', $var);
        }
        
        $query        =    $this->db->get('options');
        
        $this->response($query->result(), 200);
    }
    
    public function option_post()
    {
        $insert        =    array(
            'key'    =>    $this->post('key'),
            'value'    =>    $this->post('value')
        );
            
        if ($this->post('user_id')) {
            $this->db->where('user', $this->post('user_id'));
            $insert[ 'user_id' ]    =    $this->post('user_id');
        }
        
        if ($this->post('key')) {
            $this->db->where('key', $this->post('key'));
        }
        
        if ($this->post('app')) {
            $insert[ 'app' ]    =    $this->post('app');
        } else {
            $insert[ 'app' ]    =    '_unamed_';
        }
        
        $query        =    $this->db->get('options');
        
        if (! $query->result() && $this->post('user_id')) {
            $this->db->insert('options', $insert);
        } else {
            $this->__failed(); // see Rest_Tools;
        }
    }
    
    public function option_put()
    {
        $query    =    $this->db->where('key', $this->put('key'))->update('options', array(
            'value'    =>    $this->put('value'),
            'app'    =>    $this->put('app')
        ));
        
        if ($query) {
            $this->__success();
        } else {
            $this->__failed();
        }
    }
    
    public function option_delete()
    {
        if ($this->delete('key')) {
            $this->db->where('key', $this->delete('key'))->delete('options');
        }
        $this->__failed();
    }
}
