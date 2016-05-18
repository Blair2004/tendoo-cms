<?php
$this->Gui->col_width(1, 4);

$this->Gui->add_meta(array(
    'namespace'        =>        'dev_center',
    'col_id'            =>        1
));

$this->Gui->add_item(array(
    'type'            =>        'dom',
    'content'        =>        $this->load->view('dashboard/update/home-content', array(), true)
), 'dev_center', 1);

$this->Gui->output();
