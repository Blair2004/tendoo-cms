<section class="hbox stretch"><?php echo $ajaxMenu;?>
    
    <section id="content">
        <section class="vbox">
            <section class="scrollable wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Modifier un article</h4>
                        <div class="panel">
                            <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                                <div class="span8">
                                    <form action="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$news[0]['ID'])).'?ajax=true';?>" method="post" class="panel-body">
                                        <div class="form-group">
                                            <input class="form-control" value="<?php echo $news[0]['TITLE'];?>" type="text" name="news_name" placeholder="Titre de l'article">
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
                                            <input class="form-control" value="<?php echo $news[0]['IMAGE'];?>" name="image_link" type="text" placeholder="Lien vers l'image">
                                        </div>
                                        <div class="form-group"> <?php echo $this->core->tendoo->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content','defaultValue'=>$news[0]['CONTENT']));?> </div>
                                        <input type="hidden" value="<?php echo $news[0]['ID'];?>" name="article_id">
                                        <input class="btn btn-sm btn-info" type="submit" value="Enregistrer">
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>