<?php echo get_core_vars( 'lmenu' );?>
<section id="content">
    <section class="vbox">
        <?php echo get_core_vars( 'inner_head' );?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo output('notice');?> 
                	<section class="panel">
                    	<div class="panel-heading">
                        D&eacute;sinstaller un module
                        </div>
                        <div class="panel-body">
                        	<?php output('notice');?>
			<?php
			if($module[0]['TYPE'] == 'GLOBAL')
			{
				?>
				<div class="span12 bg-color-orangeDark fg-color-white padding10"><strong>"<?php echo $module[0]['NAMESPACE'];?>" est un module syst&egrave;me.</strong><br>Certains modules comme <strong>l'espace membre</strong> sont nécessaire au fonctionnement de l'espace administration, si vous surpprimez un tel module, Il est fort probable que cela compromette le fonctionnement de la plus part des modules qui fonctionne avec ses ressources, de plus, l'accès à l'espace administrateur sera ouverte au public.</div>
				<?php
			}
			else if($module[0]['TYPE'] == 'BYPAGE')
			{
				?>
                <div><?php echo translate('remove_module_bypage_notice');?></div>
                <br>
                <?php
			}
			?>
                                <form method="post">
                                    <div>
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