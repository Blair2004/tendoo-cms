<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Désinstaller le module : <?php echo $module[0]['NAMESPACE'];?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                	<form method="post" enctype="multipart/form-data">
						<div class="grid">
                            <div class="row">
<?php $this->core->notice->parse_notice();?>
			<?php
			if($module[0]['TYPE'] == 'GLOBAL')
			{
				?>
				<div class="span12 bg-color-orangeDark fg-color-white padding10"><strong>"<?php echo $module[0]['NAMESPACE'];?>" est un module syst&egrave;me.</strong><br>Certains modules comme <strong>l'espace membre</strong> sont nécessaire au fonctionnement de l'espace administration, si vous surpprimez un tel module, Il est fort probable que cela compromette le fonctionnement de la plus part des modules qui fonctionne avec ses ressources, de plus, l'accès à l'espace administrateur sera ouverte au public.</div>
				<?php
			}
			?>
                                <div class="span12 bg-color-blue fg-color-white padding10">Nous vous recommendons d'être prudent, assurez-vous que vous avez t&eacute;l&eacute;charg&eacute; ce module depuis une source agr&eacute;e.<br>
Le fichier envoy&eacute;e doit &ecirc;tre au format <strong>zip</strong>.</div>
                                <div class="span12 bg-color-red fg-color-white padding10">
                                	<p>êtes-vous sûr de vouloir désinstaller ce module ? Tous les fichiers liées seront supprimés. <strong>Cette action est irreversible. </strong><br></p>
                                        <input type="hidden" name="mod_id" value="<?php echo $module[0]['ID'];?>">
                                        <input type="submit" value="Confirmer">
                                </div>
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>