<div style="min-height:500px;padding:1%;">
<?php 
	if($section == 'loadPage')
	{
		echo html_entity_decode($retreive[0]['CONTENT']);
	}
	else
	{
		echo 'Unknow Section / Section inconnue';
	}
?>
</div>
