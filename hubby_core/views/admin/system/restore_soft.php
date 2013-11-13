<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $pageTitle;?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <div class="hub_table">
                        <div>
							<?php echo validation_errors('<p class="error">', '</p>');?>
                            <?php $this->core->notice->parse_notice();?>
                            <?php echo notice_from_url();?>
                        </div>
                        <br />
                        <h3>Avis sur la restauration souple</h3>
                        <p>Cette restauration d&eacute;sinstallera tous les modules et th&egrave;mes d&eacute;j&agrave; install&eacute;s, ainsi que toutes les informations qui ont &eacute;t&eacute; cr&eacute;ees par ces &eacute;l&eacute;ments depuis la. Une fois le proc&eacute;ssus lanc&eacute;, il ne peut pas &ecirc;tre arr&ecirc;t&eacute;. Si une erreur se produit durant la restauration, une reinstallation compl&egrave;te du CMS corrigera le probl&egrave;me.</p>
                        <div class="span4">
                            <form method="post">
                                <div class="input-control text">
                                    <input type="password" placeholder="Mot de passe administrateur" name="admin_password" />
                                </div>
                                <input type="submit" name="submit_restore" value="Restaurer Hubby" />
                            </form>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>