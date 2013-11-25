<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $module[0]['HUMAN_NAME'];?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'comments'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Gestion d'un commentaire</h2>
                    <div>
						<?php echo notice_from_url();?>
					</div>
                    <div class="grid">
                    	<div class="row">
                        	<div class="span6">
                                <form method="post">
                                	<h3>Auteur</h3>
                                    <div class="input-control text">
                                        <input type="text" disabled="disabled" value="<?php echo $speComment['AUTEUR'] == '' ? 'Valeur non d&eacute;finie' : $speComment['AUTEUR'];?>" />
                                        <button class="btn-clear"></button>
                                    </div>
                                    <h3>Article concern&eacute;</h3>
                                    <div class="input-control text">
                                        <input type="text" disabled="disabled" value="<?php echo $speComment['ARTICLE_TITLE'];?>" />
                                        <button class="btn-clear"></button>
                                    </div>
                                    <h3>Etat actuel</h3>
                                    <div class="input-control text">
                                        <?php echo $speComment['SHOW'] == '0'	? 'Non approuv&eacute;' : 'Approuv&eacute;';?>
                                    </div>
                                    <h3>Commentaire</h3>
                                    <div class="input-control textarea">
                                        <textarea disabled="disabled" name="currentComment" placeholder="Entrez un commentaire"><?php echo $speComment['CONTENT'];?></textarea>
                                    </div>
                                    <p>
                                    <input name="hiddenId" value="<?php echo $speComment['ID'];?>" type="hidden" />
                                    <?php
									if($speComment['SHOW'] == '0')
									{
										?>
                                    <input name="approve" value="Approuver" type="submit" />
                                    	<?php
									}
									else
									{
										?>
                                    <input name="disapprove" value="D&eacute;sapprouver" type="submit" />
                                    	<?php
									}
										?>
                                        <input type="submit" value="Supprimer" class="bg-color-red" name="delete" />
									</p>
                                </form>
							</div>
						</div>
                    <br />
					<div>
                        <?php echo $this->core->notice->parse_notice();?>
                    </div>
                    <br />
                </div>
			</div>
		</div>
	</div>
</div>