<?php echo $inner_head;?>
<section>
    <section class="hbox stretch">
        <?php echo $lmenu;?>
        <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="hbox stretch">
                <section class="wrapper"> 
					<?php echo output('notice');?> 
					
                    <?php echo fetch_error_from_url();?>
                	<section class="panel">
                    	<div class="panel-heading">
                        G&eacute;rer un commentaire
                        </div>
                        <div class="table-responsive">
                            <form method="post" class="panel-body">
                                <div class="form-group">
                                	<label class="control-label">Auteur</label>
                                    <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['AUTEUR'] == '' ? 'Valeur non d&eacute;finie' : $speComment['AUTEUR'];?>" />
                                </div>
                                <div class="form-group">
                                	<label class="control-label">Article concern&eacute;</label>
                                    <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['ARTICLE_TITLE'];?>" />
                                </div>
                                <div class="form-group">
                                	<label class="control-label">Etat actuel</label>
                                    <?php echo $speComment['SHOW'] == '0'	? 'Non approuv&eacute;' : 'Approuv&eacute;';?>
                                </div>
                                <div class="form-group">
                                	<label class="control-label">Commentaire</label>
                                    <textarea class="form-control" disabled="disabled" name="currentComment" placeholder="Entrez un commentaire"><?php echo $speComment['CONTENT'];?></textarea>
                                </div>
                                <input name="hiddenId" value="<?php echo $speComment['ID'];?>" type="hidden" />
                                <?php
                                if($speComment['SHOW'] == '0')
                                {
                                    ?>
                                <input class="btn btn-success" name="approve" value="Approuver" type="submit" />
                                    <?php
                                }
                                else
                                {
                                    ?>
                                <input class="btn btn-warning" name="disapprove" value="D&eacute;sapprouver" type="submit" />
                                    <?php
                                }
                                    ?>
                                    <input class="btn btn-danger" type="submit" value="Supprimer" name="delete" />
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>