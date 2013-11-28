<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?>
                	<section class="panel">
                    	<div class="panel-heading">
                        D&eacute;sinstaller un module
                        </div>
                        <div class="panel-body">
                        	<?php $this->core->notice->parse_notice();?>
			<?php
			if($module[0]['TYPE'] == 'GLOBAL')
			{
				?>
				<div class="span12 bg-color-orangeDark fg-color-white padding10"><strong>"<?php echo $module[0]['NAMESPACE'];?>" est un module syst&egrave;me.</strong><br>Certains modules comme <strong>l'espace membre</strong> sont nécessaire au fonctionnement de l'espace administration, si vous surpprimez un tel module, Il est fort probable que cela compromette le fonctionnement de la plus part des modules qui fonctionne avec ses ressources, de plus, l'accès à l'espace administrateur sera ouverte au public.</div>
				<?php
			}
			?>
                                <div>Nous vous recommendons d'être prudent, assurez-vous que vous avez t&eacute;l&eacute;charg&eacute; ce module depuis une source agr&eacute;e.<br>
Le fichier envoy&eacute;e doit &ecirc;tre au format <strong>zip</strong>.</div>
								<br />
                                <form method="post">
                                    <div>
                                        <p>êtes-vous sûr de vouloir désinstaller ce module ? Tous les fichiers liées seront supprimés. <strong>Cette action est irreversible. </strong><br></p>
                                            <input type="hidden" name="mod_id" value="<?php echo $module[0]['ID'];?>">
                                            <input type="submit" class="btn btn-sm btn-danger" value="Confirmer">
                                    </div>
                                </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>