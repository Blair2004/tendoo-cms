<?php
	function page_header()
	{
	?>
<body style="" cz-shortcut-listen="true">
    <section class="hbox stretch">
<!-- .aside -->
<?php
    }
	function page_bottom()
	{
		?>
	<script>
	bubblesMain(new Object({
		type : 'radial',
		revolve : 'center',
		minSpeed : 100,
		maxSpeed : 500,
		minSize : 10,
		maxSize : 50,
		num : 100,
		colors : new Array("#ff0000","#ffff00","#04ff00","#0037ff")
	}));
	</script>
    </body>
</html>
<?php
	}
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				page_header();
			}
		}
		else
		{
			$this->core->hubby->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		page_header();
	}
	echo is_array($body) ? $body['RETURNED'] : $body;
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				echo $this->core->file_2->js_load();
				page_bottom();
			}
		}
		else
		{
			$this->core->hubby->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		echo $this->core->file_2->js_load();
		page_bottom();
	}