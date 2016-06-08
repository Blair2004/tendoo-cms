<?php
/**
 * 	File Name 	: 	404.php
 *	Description :	Displays dashboard internal 404 page error
 *	Since		:	1.5
**/

$this->Gui->col_width(1, 4);

$this->Gui->add_meta(array(
    'type'        =>    'dom',
    'title'        =>    __('Error : 404'),
    'col_id'    =>    1,
    'namespace'    =>    'error-section'
));

$this->Gui->add_item(array(
    'type'        =>    'html-error',
    'title'        =>    __('Oops ! An error occured'),
    'error-type'=>    __('404'),
    'content'    =>    __('We could not locate this page. You can go back to the dashboard and try again'),
), 'error-section', 1);

$this->Gui->output();
