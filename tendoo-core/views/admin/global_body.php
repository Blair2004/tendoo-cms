<?php
	$options	=	get_core_vars( 'options' );
	$body		=	get_core_vars( 'body' );
	if(is_array(get_core_vars( 'body' )))
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
			get_instance()->tendoo->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		page_header();
	}
	//*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=	Affiche le contenu par le module -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*//
	//*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*//
	echo is_array($body) ? $body['RETURNED'] : $body;
	//*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*//
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				echo $this->instance->file_2->js_load();
				page_bottom($options,$this);
			}
		}
		else
		{
			$this->instance->tendoo->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		echo $this->instance->file_2->js_load();
		page_bottom($options,$this);
	}
	