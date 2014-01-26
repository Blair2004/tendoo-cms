<?php echo $lmenu;?>
<section id="content">
<section class="vbox">
	<?php echo $inner_head;?>
    <section class="scrollable" id="pjax-container">
        <header>
            <div class="row b-b m-l-none m-r-none">
                <div class="col-sm-4">
                    <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                    <p class="block text-muted">Liste des th&egrave;mes install&eacute;s</p>
                </div>
            </div>
        </header>
        <section class="vbox">
            <section class="wrapper w-f"> 
			<?php echo $this->core->notice->parse_notice();?> 
			<?php echo $success;?>
            <?php echo validation_errors('<p class="error">', '</p>');?>
			<?php $this->core->notice->parse_notice();?>
            <?php echo notice_from_url();?>
            	<div class="col-lg-3">
                    <div class="panel">
                        <div class="panel-heading">
                            Etat : <?php echo $Spetheme[0]['ACTIVATED'];?>
                        </div>
                        <div class="panel-content">
                            <div class="grid">
                                <form method="post" class="panel-body">
                                    <div class="form-group">
                                        <p>D&eacute;finir comme th&egrave;me par d&eacute;faut.</p>
                                    </div>
                                    <input class="btn btn-sm btn-white" type="submit" value="D&eacute;finir par d&eacute;faut" />
                                    <input type="hidden" name="setDefault" value="ADMITSETDEFAULT">
                                    <input type="hidden" name="theme_id" value="<?php echo $Spetheme[0]['ID'];?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel">
                        <div class="panel-heading">
                            Op&eacute;ration
                        </div>
                        <div class="panel-content">
                            <div class="grid">
                                <form method="post" class="panel-body">
                                	<div class="form-group">
                                        <p>Supprimer le th&egrave;me.</p>
                                    </div>
                                    <input class="btn btn-sm btn-danger" type="submit" value="Supprimer le th&egrave;me" style="margin-right:10px;" onClick="if(confirm('Confirmer : Si vous supprimez ce th&egrave;me, il ne sera plus disponible, tous les fichiers li&eacute;es seront &eacute;galement supprimer. Nous vous recommandons de d&eacute;finir par d&eacute;faut un autre th&egrave;me, avant de supprimer celui-ci, si ce th&egrave;me est d&eacute;fini par d&eacute;faut. V&eacute;rifiez l\'etat en haut sur la ligne Gestion du th&egrave;me.')){return true;}else{return false};">
                                    <input type="hidden" name="delete" value="ADMITDELETETHEME">
                                    <input type="hidden" name="theme_id" value="<?php echo $Spetheme[0]['ID'];?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>