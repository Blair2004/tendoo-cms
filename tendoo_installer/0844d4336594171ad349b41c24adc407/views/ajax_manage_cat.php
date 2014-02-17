<section class="hbox stretch"><?php echo $ajaxMenu;?>
  
  <section id="content">
    <section class="vbox">
      <section class="scrollable wrapper">
        <h3 style="margin-top:0">Modifier une cat&eacute;gorie</h3>
        <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
        <form action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category','manage',$cat['id'].'?ajax=true'));?>" method="post">
            <div class="input-group">
              <span class="input-group-addon">Nom de la cat&eacute;gorie</span>
              <input class="form-control" type="text" name="cat_name" value="<?php echo $cat['name'];?>" placeholder="Nom de la cat&eacute;gorie">
            </div>
            <div class="form-group">
                
            </div>
            <div class="form-group">
                <textarea class="form-control" name="cat_description" placeholder="Description de la cat&eacute;gorie"><?php echo $cat['desc'];?></textarea>
            </div>
            <input type="hidden" name="cat_id" value="<?php echo $cat['id'];?>">
            <input class="btn btn-sm btn-info" type="submit" value="Modifier la cat&eacute;gorie">
            <input class="form-control" type="hidden" value="ALLOWEDITCAT" name="allower">
            <form action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category','manage',$cat['id'].'?ajax=true'));?>" method="post">
              <input type="hidden" value="<?php echo $cat['id'];?>" name="cat_id_for_deletion">
              <input type="hidden" value="ALLOWCATDELETION" name="allower">
              <input class="btn btn-sm btn-danger" type="submit" value="supprimer la cat&eacute;gorie">
            </form>
        </form>
        <br />
        	<?php echo tendoo_warning('Une cat&eacute;gorie ne peut &ecirc;tre supprim&eacute;e si certaines publications y sont encore attach&eacute;es. Rassurez-vous qu\'aucun article n\'est rattach&eacute; &agrave; cette cat&eacute;gorie avant de la supprimer');?>
      </section>
    </section>
  </section>
</section>
