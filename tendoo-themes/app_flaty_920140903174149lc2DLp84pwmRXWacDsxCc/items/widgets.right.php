<?php
if(count($this->ttRightWidgets) < 0)
{
	foreach($this->ttRightWidgets as $w)
	{
		get_widget( 'right' , $w['TITLE'] , $w['CONTENT'] , $w['TYPE'] );
	}
}
?>