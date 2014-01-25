<section class="hbox stretch"><?php echo $ajaxMenu;?>
            
            <section id="content">
                <section class="vbox">
                    <section class="scrollable wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                	<div class="panel-heading">
                                    Publier des articles
                                    </div>
                                    <div class="panel-body">
                                    <form method="post" class="row submitForm" action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'publish')).'?ajax=true';?>">
                                        <section class="wrapper">
                                            <div class="col-lg-12"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?> </div>
                                            <div class="col-lg-4">
                                            	<div class="form-group">
                                                        <input class="form-control" type="text" name="news_name" placeholder="Titre de l'article">
                                                    </div>
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
                                                        <input class="form-control" name="image_link" type="text" placeholder="Lien vers l'image">
                                                    </div>
                                                    <div class="form-group">
                                                        <input class="form-control" name="thumb_link" type="text" placeholder="Lien vers l'aperçu">
                                                    </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="form-group"> 
													<?php echo $this->core->tendoo->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content'));?> </div>                                            </div>
                                        </section>
                                        <input class="btn btn-default" type="submit" value="Poster" />
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
        </section>
<script>
		$(document).ready(function(){
			CKEDITOR.inline('editor');
			$('.submit_article').bind('click',function(){
				$('.submitForm').submit();
			});
		});
		</script>