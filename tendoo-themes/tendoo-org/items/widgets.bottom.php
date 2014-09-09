<?php
if(count($this->ttBottomWidgets) < 0)
{
	foreach($this->ttBottomWidgets as $w)
	{
		get_widget( 'bottom' , $w['TITLE'] , $w['CONTENT'] , $w['TYPE'] );
	}
}
?>