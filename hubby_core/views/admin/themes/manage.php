<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Gestionnaire des th&egrave;mes<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','themes','main'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <h2>Gestion du th&egrave;me <?php echo $Spetheme[0]['NAMESPACE'];?> Etat : <?php echo $Spetheme[0]['ACTIVATED'];?></h2>
                    <div>
                        <?php echo validation_errors('<p class="error">', '</p>');?>
                        <?php $this->core->notice->parse_notice();?>
                        <?php echo notice_from_url();?>
                    </div>
                    <br />
                	<div class="grid">
                    	<div class="row">
                        	<div class="span4 bg-color-blue padding10">
                            	<form method="post">
                                <p>D&eacute;finir comme th&egrave;me par d&eacute;faut.</p>
									<input type="submit" value="D&eacute;finir par d&eacute;faut" />
                                    <input type="hidden" name="setDefault" value="ADMITSETDEFAULT">
                                    <input type="hidden" name="theme_id" value="<?php echo $Spetheme[0]['ID'];?>">
                                </form>
                            </div>
                            <div class="span4 bg-color-greenDark fg-color-white padding10">
                            	<form method="post">
                                	<p>Supprimer le th&egrave;me.</p>
                                    <input type="submit" value="Supprimer le th&egrave;me" style="margin-right:10px;" onClick="if(confirm('Confirmer : Si vous supprimez ce th&egrave;me, il ne sera plus disponible, tous les fichiers li&eacute;es seront &eacute;galement supprimer. Nous vous recommandons de d&eacute;finir par d&eacute;faut un autre th&egrave;me, avant de supprimer celui-ci, si ce th&egrave;me est d&eacute;fini par d&eacute;faut. V&eacute;rifiez l\'etat en haut sur la ligne Gestion du th&egrave;me.')){return true;}else{return false};">
                                    <input type="hidden" name="delete" value="ADMITDELETETHEME">
                                    <input type="hidden" name="theme_id" value="<?php echo $Spetheme[0]['ID'];?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>