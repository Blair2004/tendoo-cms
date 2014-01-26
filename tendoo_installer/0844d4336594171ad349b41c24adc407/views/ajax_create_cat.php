<section class="hbox stretch"><?php echo $ajaxMenu;?>
    
    <section id="content">
        <section class="vbox">
            <section class="scrollable wrapper">
                <div class="row">
                    <div class="col-lg-12"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                        <section class="panel">
                            <div class="panel-heading"> Cr&eacute;er une cat&eacute;gogrie </div>
                            <div class="span8">
                                <form action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category','create?ajax=true'));?>" class="panel-body" method="post">
                                    <div class="form-group">
                                        <input class="form-control" name="cat_name" type="text" placeholder="Nom de la cat&eacute;gorie" />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="cat_description" type="text" placeholder="Description de la cat&eacute;gorie"></textarea>
                                    </div>
                                    <input class="btn btn-sm btn-info" type="submit" value="Créer une cat&eacute;gorie">
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>