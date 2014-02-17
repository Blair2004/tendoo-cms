<section class="hbox stretch"><?php echo $ajaxMenu;?>
  
  <section id="content">
    <section class="vbox">
      <section class="scrollable wrapper">
        <h3 style="margin-top:0">Cr&eacute;er un nouvel article</h3>
        <form method="post" class="row submitForm" action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'publish')).'?ajax=true';?>">
          <div class="col-lg-12"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?> </div>
          <div class="col-lg-9">
            <input class="form-control" type="text" name="news_name" placeholder="Titre de l'article">
            <br />
            <?php echo $this->core->tendoo->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content'));?> </div>
          <div class="col-lg-3">
            <section class="panel">
              <div class="panel-heading">Options</div>
              <div class="panel-body">
                <div class="form-group"> </div>
                <div class="form-group">
                  <select class="form-control" name="push_directly">
                    <option value="">Choisir une action</option>
                    <option value="1">Publier directement l'article</option>
                    <option value="2">Enregistrer dans les brouillons</option>
                  </select>
                </div>
                <div class="form-group">
                  <select class="form-control" name="category">
                    <option value="">Choisir la cat&eacute;gorie</option>
                    <?php
                                                foreach($categories as $c)
                                                {
                                                ?>
                    <option value="<?php echo $c['ID'];?>"><?php echo $c['CATEGORY_NAME'];?></option>
                    <?php
                                                }
                                                ?>
                  </select>
                </div>
                <div class="form-group">
                  <?php
												$fmlib->mediaLib_button(array(
													'PLACEHOLDER'		=>		'Lien vers l\'aperçu',
													'NAME'				=>		'thumb_link',
													'TEXT'				=>		'Image aperçu'
												));	
												?>
                </div>
                <div class="form-group">
                  <?php
												$fmlib->mediaLib_button(array(
													'PLACEHOLDER'		=>		'Lien vers l\'image',
													'NAME'				=>		'image_link',
													'GOTO'				=>		'selection',
													'TEXT'				=>		'Image taille r&eacute;elle'
												));	
												?>
                </div>
                <?php
												$fmlib->mediaLib_load();
												?>
				<div class="form-group">
                	<input class="btn btn-info" type="submit" value="Publier" />
                </div>
              </div>
            </section>
          </div>
        </form>
      </section>
    </section>
  </section>
</section>
<?php echo $this->core->file->js_load();?>