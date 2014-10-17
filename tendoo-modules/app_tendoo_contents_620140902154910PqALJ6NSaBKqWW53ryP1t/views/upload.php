<?php echo $lmenu;?>
<section id="content">
    <section class="bigwrapper"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="bigwrapper">
                <section class="wrapper"> <?php echo output('notice');?>  <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                	<div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-heading"> Ajouter un nouveau fichier </div>
                            <div class="panel-body" style="padding:10px;">
                                <p>Vous avez la possibilité d'envoyer des fichiers vidéos, audio et même des images, sous reserve du respect de la limite en taille qui est autorisé par votre serveur.</p>
                                <br />
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="input-group input-group-sm">
                                      <span class="input-group-addon">Le nom du fichier</span>
                                      <input name="file_human_name" type="text" class="form-control" placeholder="Le nom de votre fichier">
                                    </div>
                                    <br />
                                    <div class="input-group input-group-sm">
                                      <span class="input-group-addon">Description du fichier</span>
                                      <textarea style="height:200px;" name="file_description" placeholder="Description du fichier" type="text" class="form-control"></textarea>
                                    </div>
                                    <br />
                                    <div class="form-group">
                                    <input class="form-control" type="file" name="file" />
                                    </div>
                                    <input class="btn btn-info" type="submit" value="Envoyer le fichier" />
                                </form>
                            </div>
                        </section>
                    </div>
                    </div>
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
