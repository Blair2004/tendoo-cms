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
                <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                    <section class="panel">
                        <div class="panel-heading"> Ajouter un nouveau fichier </div>
                        <div class="panel-body">
                        	<form method="post" action="">
                            	<div class="input-group input-group-sm">
                                  <span class="input-group-addon">Titre du fichier</span>
                                  <input type="text" name="file_name" class="form-control" value="<?php echo $getFile[0]['TITLE'];?>" placeholder="Titre du fichier">
                                </div>
                                <hr class="line line-dashed">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon">Description</span>
                                  <textarea style="height:200px;" type="text" name="file_description" class="form-control" value="<?php echo $getFile[0]['TITLE'];?>" placeholder="Titre du fichier"><?php echo $getFile[0]['DESCRIPTION'];?></textarea>
                                </div>
                                <hr class="line line-dashed">
                                <input type="hidden" name="content_id" value="<?php echo $id;?>">
                                <input class="btn btn-info" type="submit" value="Modifier la page" name="edit_file">
                                <input class="btn btn-danger" type="submit" name="delete_file" value="Supprimer le fichier">
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
