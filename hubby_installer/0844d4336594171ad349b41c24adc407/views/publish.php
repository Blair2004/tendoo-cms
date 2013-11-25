<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $module[0]['HUMAN_NAME'];?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<div class="span8">
						<?php echo validation_errors(); ?>
                        <?php echo $this->core->notice->parse_notice();?>
                        <h2>Ecrire un article</h2>
                        <form method="post">
                            <div class="input-control text">
                                <input type="text" name="news_name" placeholder="Titre de l'article">
                            </div>
                            <div class="input-control select">
                            	<select name="push_directly">
                                    <option value="">Choisir une action</option>
                                    <option value="1">Publier directement l'article</option>
                                    <option value="2">Enregistrer dans les brouillons</option>
                                </select>
                            </div>
                            <div class="input-control select">
                            	<select name="category">
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
                            <div class="input-control input">
                            	<input name="image_link" type="text" placeholder="Lien vers l'image">
                            </div>
                            <div class="input-control textarea">
                            	<?php echo $this->core->hubby->getEditor(array('id'=>'editor','name'=>'news_content'));?>
                            </div>
                            <input type="submit" value="Enregistrer">
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
