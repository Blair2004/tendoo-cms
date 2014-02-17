<section class="hbox stretch"><?php echo $ajaxMenu;?>
    
    <section id="content">
        <section class="vbox">
            <section class="scrollable wrapper">
            	<h3 style="margin-top:0">Cr&eacute;er une cat&eacute;gorie</h3>
                <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                <form action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category','create?ajax=true'));?>" method="post">
                    <div class="form-group">
                        <input class="form-control" name="cat_name" type="text" placeholder="Nom de la cat&eacute;gorie" />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="cat_description" type="text" placeholder="Description de la cat&eacute;gorie"></textarea>
                    </div>
                    <input class="btn btn-sm btn-info" type="submit" value="Créer une cat&eacute;gorie">
                </form>
            </section>
        </section>
    </section>
</section>