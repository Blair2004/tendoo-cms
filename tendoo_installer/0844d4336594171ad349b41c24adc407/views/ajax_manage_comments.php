<section class="hbox stretch"><?php echo $ajaxMenu;?>
    
    <section id="content">
        <section class="vbox">
            <section class="scrollable wrapper">
                <div class="row">
                    <div class="col-lg-12"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                        <div class="panel-heading"> G&eacute;rer un commentaire </div>
                        <div class="table-responsive">
                            <form method="post" class="panel-body" action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'comments_manage',$speComment['ID'])).'?ajax=true';?>">
                                <div class="form-group">
                                    <label class="control-label">Auteur</label>
                                    <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['AUTEUR'] == '' ? 'Valeur non d&eacute;finie' : $speComment['AUTEUR'];?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Article concern&eacute;</label>
                                    <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['ARTICLE_TITLE'];?>" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Etat actuel</label>
                                    <?php echo $speComment['SHOW'] == '0'	? 'Non approuv&eacute;' : 'Approuv&eacute;';?> </div>
                                <div class="form-group">
                                    <label class="control-label">Commentaire</label>
                                    <textarea class="form-control" disabled="disabled" name="currentComment" placeholder="Entrez un commentaire"><?php echo $speComment['CONTENT'];?></textarea>
                                </div>
                                <input name="hiddenId" value="<?php echo $speComment['ID'];?>" type="hidden" />
                                <?php
                                if($speComment['SHOW'] == '0')
                                {
                                    ?>
                                <input class="btn btn-success" name="approve" value="Approuver" type="submit" />
                                <?php
                                }
                                else
                                {
                                    ?>
                                <input class="btn btn-warning" name="disapprove" value="D&eacute;sapprouver" type="submit" />
                                <?php
                                }
                                    ?>
                                <input class="btn btn-danger" type="submit" value="Supprimer" name="delete" />
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
    </section>