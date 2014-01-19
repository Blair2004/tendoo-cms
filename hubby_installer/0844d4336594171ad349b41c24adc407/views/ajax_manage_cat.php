<div class="row" style="margin:0;">
    <div class="col-sm-3">
        <ul class="nav nav-pills nav-stacked">
          <?php echo $ajaxMenu;?>
        </ul>
    </div>
    <div class="col-sm-9">
        <h4>Liste des articles</h4>
        <div class="panel">
            <section class="wrapper"> 
					<?php echo $this->core->notice->parse_notice();?> 
					<?php echo $success;?> 
					<?php echo notice_from_url();?>
					<?php echo validation_errors(); ?> 
                    <section class="panel">
                        <div class="panel-heading"> Ecrire un article </div>
                        <div class="panel-body"> 
                            <form action="" method="post">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="cat_name" value="<?php echo $cat['name'];?>" placeholder="Nom de la cat&eacute;gorie">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="cat_description" placeholder="Description de la cat&eacute;gorie"><?php echo $cat['desc'];?></textarea>
                                </div>
                                <input type="hidden" name="cat_id" value="<?php echo $cat['id'];?>">
                                  <input class="btn btn-sm btn-info" type="submit" value="Modifier la cat&eacute;gorie">
                                  <input class="form-control" type="hidden" value="ALLOWEDITCAT" name="allower">
                            </form>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-heading">Supprimer la cat&eacute;gorie</div>
                        <form action="" class="panel-body" method="post">
                            <div class="form-group">
                                <span class="notice">Une cat&eacute;gorie ne peut &ecirc;tre supprim&eacute;e si certaines publications y sont encore attach&eacute;s. Rassurez-vous qu'aucun article n'est rattach&eacute; &agrave; cette cat&eacute;gorie avant de la supprimer</span>
                            </div>
                            <input type="hidden" value="<?php echo $cat['id'];?>" name="cat_id_for_deletion">
                            <input type="hidden" value="ALLOWCATDELETION" name="allower">
                            <input class="btn btn-sm btn-danger" type="submit" value="supprimer la cat&eacute;gorie">
                        </form>
                    </section>
                </section>
        </div> 
    </div>
</div>