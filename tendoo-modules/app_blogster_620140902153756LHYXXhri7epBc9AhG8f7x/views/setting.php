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
                        <div class="col-lg-6">
                            <section class="panel">
                                <div class="panel-heading"> Param&ecirc;tres avanc&eacute;s </div>
                                <form method="post" class="panel-body">
                                    <label  class="label-control switch" >
                                    <input type="checkbox" name="validateall" value="true" 
                                    <?php
                                    if($setting)
                                    {
                                        if(array_key_exists('APPROVEBEFOREPOST',$setting))
                                        {
                                        if($setting['APPROVEBEFOREPOST'] == "1")
                                        {
                                        ?>
                                        checked="checked"
                                        <?php
                                        }
                                    }
                                    }
                                    ?> />
                                    <span></span>
                                    <p style="display:inline-block;vertical-align:bottom;">Valider chaque commentaire avant de l'afficher</p>
                                    </label>
                                    <label  class="label-control switch" style="vertical-align:inherit;">
                                    <input type="checkbox" name="allowPublicComment" value="true" <?php
								if($setting)
								{
									if(array_key_exists('EVERYONEPOST',$setting))
									{
										if($setting['EVERYONEPOST'] == "1")
										{
										?>
										checked="checked"
										<?php
										}
									}
								}
								?> />
                                    <span class="helper"></span>
                                    <p style="display:inline-block;vertical-align:bottom;">Commentaire ouvert au public</p>
                                    </label>
                                    <hr class="line line-dashed" />
                                    <input class="btn btn-sm btn-info" type="submit" value="Enregistrer les modifications" name="update">
                                </form>
                            </section>
                        </div>
                        <div class="col-lg-6">
                            <section class="panel">
                                <div class="panel-heading"> Exporter / Importer </div>
                                <div class="panel-body">
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="input-group">
                                        	<span class="input-group-addon">Importer</span>
                                            <input type="file" class="form-control" name="import">
                                            <span class="input-group-btn">
                                            <button confirm-do="click" confirm-text="souhaitez vous ajoutez cette sauvegarde ? les anciennes donnée seront écrasées" class="btn btn-default" type="submit">Envoyer</button>
                                            </span> 
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Exporter</label>
                                            <div class="col-sm-10">
                                                <input type="submit" class="btn <?php theme_button_class();?>" name="export" value="Télécharger une sauvegarde">
                                            </div>
                                        </div>
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
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>