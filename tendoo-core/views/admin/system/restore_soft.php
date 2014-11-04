<?php echo get_core_vars( 'lmenu' );?>
<section id="content">
    <section class="hbox stretch">
        <?php echo get_core_vars( 'lmenu' );?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/la-restauration-souple" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </header>
            <div class="wrapper w-f">
                <div class="hub_table">
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php output('notice');?>
                    <?php echo fetch_error_from_url();?>
                    <section class="panel">
                        <div class="wrapper b-b font-bold">Restauration souple du syst&egrave;me.</div>
                        <div class="wrapper">
                            <p>Cette restauration d&eacute;sinstallera tous les modules et th&egrave;mes d&eacute;j&agrave; install&eacute;s, ainsi que toutes les informations qui ont &eacute;t&eacute; cr&eacute;ees par ces &eacute;l&eacute;ments depuis la. Une fois le proc&eacute;ssus lanc&eacute;, il ne peut pas &ecirc;tre arr&ecirc;t&eacute;. Si une erreur se produit durant la restauration, une reinstallation compl&egrave;te du CMS corrigera le probl&egrave;me.</p>
                            <div class="span4">
                                <form method="post" class="panel-body">
                                    <div class="form-group">
                                        <input class="form-control" type="password" placeholder="Mot de passe administrateur" name="admin_password" />
                                    </div>
                                    <input class="btn <?php echo theme_button_class();?>" type="submit" name="submit_restore" value="Restaurer Tendoo" />
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
</section>