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
                        <h3>Avis sur la restauration brutale</h3>
                        <p>Cette restauration supprimera tous les fichiers install&eacute;s en mode administrateur, supprimera toutes les informations enregistr&eacute;es en mode administrateur, tous les utilisateurs et privil&egrave;ges cr&eacute;es, supprimera toutes les informations de connexion. Et remettra le CMS à son &eacute;tat initial. En cas d'erreur, la reinstallation d'hubby corrigera le probl&egrave;me.</p>
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