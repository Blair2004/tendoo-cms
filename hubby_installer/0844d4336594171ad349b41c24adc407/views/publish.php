<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> 
					<?php echo $this->core->notice->parse_notice();?> 
					<?php echo $success;?> 
					<?php echo notice_from_url();?>
					<?php echo validation_errors(); ?> 
                    <section class="panel">
                        <div class="panel-heading"> Ecrire un article </div>
                        <div class="span8"> 
                            <form method="post" class="panel-body">
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
                                <div class="form-group"> <?php echo $this->core->hubby->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content'));?> </div>
                                <input class="btn btn-sm btn-info" type="submit" value="Enregistrer">
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>