<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-4">
                    
                </div>
                <div class="col-sm-4 text-center">  </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <a class="submit_article btn btn-white">Publier l'article</a>
                </div>
            </div>
        </footer>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                    <form method="post" class="row submitForm">
                <section class="wrapper"> 
                        			<div class="col-lg-12">
                                    	<?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                                    </div>
                                    <div class="col-lg-4">
                                       	<section class="panel">
                                            <div class="panel-heading"> Ecrire un article </div>
                                            <div class="panel-body"> 
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
										</section>
									</div>
                                    <div class="col-lg-8">
                                    	<div class="panel">
                                        	<div class="panel-heading">Contenu de l'article</div>
                                            <div class="panel-body">
                                                <div class="form-group"> <?php echo $this->core->tendoo->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content'));?> </div>
                                            </div>
                                        </div>
                                    </div>
                        </section>
                    </form>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
        <script>
		$(document).ready(function(){
			$('.submit_article').bind('click',function(){
				$('.submitForm').submit();
			});
		});
		</script>
