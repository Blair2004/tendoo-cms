<?php echo $inner_head;?>

<section>
    <section class="hbox stretch">
        <?php echo get_core_vars( 'lmenu' );?>
        <section class="vbox">
            <section class="scrollable">
                <header>
                    <div class="row b-b m-l-none m-r-none">
                        <div class="col-sm-4">
                            <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                            <p class="block text-muted">
                                <?php echo get_page('description');?>
                            </p>
                        </div>
                    </div>
                </header>
                <section class="vbox">
                    <section class="wrapper">
                        <?php echo output('notice');?> <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                        <div class="row">
                            <div class="col-lg-8">
                                <section class="panel">
                                    <div class="panel-heading">
                                        Liste des mots clés disponibles
                                    </div>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td>Intitulé du mot clé</td>
                                                <td>Description</td>
                                                <td>En cours d'utilisation</td>
                                                <td>Utilisé</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                    if($getKeywords)
                                    {
                                        foreach($getKeywords as $kw)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $kw['TITLE'];?></td>
                                                <td><?php echo word_limiter($kw['TITLE'],4);?></td>
                                                <td><?php echo (int)$kw['USED'] > 0 ? 'Oui' : 'Non';?></td>
                                                <td><?php echo $kw['USED'];?> fois</td>
                                                <td><a data-doAction href="<?php echo module_url(array('ajax','tags','delete',$kw['ID']));?>">Supprimer</a></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <tr>
                                                <td colspan="4">Aucun mots clé disponible</td>
                                            </tr>
                                            <?php
                                    }
                                    ?>
                                        </tbody>
                                    </table>
                                    <script>
                            $('[data-doAction]').each(function(){
                                if(typeof $(this).attr('doAction-binded') == 'undefined')
                                {
                                    $(this).attr('doAction-binded','true');
                                    $(this).bind('click',function(){
                                        var $this	=	$(this);
                                        tendoo.modal.confirm('Souhaitez-vous supprimer ce mot-clé ?<br>En supprimant ce mot-clé, il ne sera plus disponible dans les articles où il a été inséré.',function(){
                                            tendoo.doAction($this.attr('href'),function(e){
                                                tendoo.triggerAlert(e);
                                                if(e.status == 'success')
                                                {
                                                    $this.closest('tr').fadeOut(500,function(){
                                                        $(this).remove();
                                                    });
                                                }
                                            },{});
                                        });
                                        return false;
                                    });
                                }
                            });
                            </script>
                                </section>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel">
                                    <div class="panel-heading">
                                        Créer un mot clé
                                    </div>
                                    <div class="panel-body">
                                        <form method="post" fjaxson method="post" action="<?php echo module_url(array('ajax','tags','create'));?>">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Titre du mot clé</span>
                                                <input type="text" class="form-control" name="kw_title" placeholder="Entrez le titre du mot-clé">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control" name="kw_description"></textarea>
                                        </div>
                                        <input type="submit" class="btn btn-sm <?php echo theme_button_class();?>" value="Créer le mot clé">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-sm-2">
                        <select class="input-sm form-control inline bulkActionChange">
                            <option value="0">Actions Group&eacute;es</option>
                            <option value="deleteSelected">Supprimer</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-white bulkActionTrigger">Effectuer</button>
                    </div>
                    <div class="col-sm-4 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Affiche <?php echo $paginate['start'];?> &agrave; <?php echo $paginate['end'];?> &eacute;l&eacute;ments</small>
                    </div>
                    <div class="col-sm-2">
                        <form method="get" class="form">
                            <div class="input-group input-group-xs">
                                <span class="input-group-btn">
                                <button class="btn btn-default <?php echo theme_button_class();?>" type="submit">Afficher</button>
                                </span>
                                <input type="text" name="limit" class="form-control" placeholder="10" value="<?php echo $paginate['end'];?>">
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-3 text-right text-center-xs">
                        <?php bs_pagination($paginate);?>
                    </div>
                </div>
            </footer>
        </section>
    </section>
</section>
