<?php
$head	=	'
    <body class="metrouicss">
        <div id="header" class="nav-bar" style="background:inherit;">
            <div class="nav-bar-inner padding10">
                <span class="element brand">
                    <img src="'.$this->core->url->img_url("logo_4.png").'" style="float:left;height:40px;position:relative;top:-10px;">
                    '.$this->core->hubby->getVersion().'
                </span>
                <span class="element brand" style="float:right;font-size:13px">
                    Connect&eacute; en tant que <strong>'.ucwords($this->core->users_global->current('PSEUDO')).'</strong><span> | <a href="'.$this->core->url->site_url('logoff').'" style="color:#FC3">D&eacute;connexion</a> </span>
                </span>
            </div>
        </div> ';
$bottom	=	'
        <div class="" id="footer">
            <div class="nav-bar-inner padding10" style="margin-right:20px;float:right">
                <a href="'.$this->core->url->site_url(array('index')).'"><i class="icon-arrow-right-3" style="font-size:25px;color:white" title="Retour au site"></i></a>
            </div>
        </div>
		<script>
	bubblesMain(new Object({
		type : \'radial\',
		revolve : \'center\',
		minSpeed : 100,
		maxSpeed : 500,
		minSize : 50,
		maxSize : 150,
		num : 100,
		colors : new Array("#00A300","#DA532C","#E3A21A","#00ABA9")
	}));
	</script>
</body>
</html>
';
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				echo $head;
			}
		}
		else
		{
			$this->core->hubby->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		echo $head;
	}
	echo is_array($body) ? $body['RETURNED'] : $body;
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				echo $bottom;
			}
		}
		else
		{
			$this->core->hubby->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		echo $bottom;
	}