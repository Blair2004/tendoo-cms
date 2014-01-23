<section class="hbox stretch"><?php echo $ajaxMenu;?>
    
    <section id="content">
        <section class="vbox">
            <section class="scrollable wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Liste des articles</h4>
                        <div class="panel">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th>Intitué</th>
                                        <th>Cat&eacute;gorie</th>
                                        <th>Date de creation</th>
                                        <th>Accéssibilité</th>
                                        <th>Auteur</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            if(count($getNews) > 0)
                            {
                                foreach($getNews as $g)
                                {
                                    $cat_name	=	$news->getSpeCat($g['CATEGORY_ID']);
                                    $user		=	$this->core->users_global->getUser($g['AUTEUR']);
                            ?>
                                    <tr>
                                        <th class="action"><a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$g['ID'].'?ajax=true'));?>"><?php echo $g['TITLE'];?></a></th>
                                        <th><?php echo $cat_name['CATEGORY_NAME'];?></th>
                                        <th><?php echo $this->core->hubby->timespan(strtotime($g['DATE']));?></th>
                                        <th><?php echo $g['ETAT'] == '1' ? 'Publi&eacute;' : 'Brouillon';?></th>
                                        <th><?php echo $user['PSEUDO'];?></th>
                                        <th><a class="delete" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$g['ID'].'?ajax=true'));?>">Supprimer</a></th>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                    <tr>
                                        <td colspan="5">Aucun article publié ou dans les brouillons</td>
                                    </tr>
                                    <?php
                            }
                            ?>
                                </tbody>
                            </table>
                            <script>
        $(document).ready(function(){
            $('table .delete').bind('click',function(){
                if(confirm('Cette publication sera supprimé avec tous les commentaires qui y sont attachés. Continuer ?'))
                {
                    var current	=	this;
                    var items = [];
                    $.getJSON($(this).attr('href'), function(data) {
                        if(data.requestStatus === true)
                        {
                            $(current).closest('tr').fadeOut(500,function(){
                                $(this).remove();
                            })
                        }
                        else
                        {
                            alert('La suppréssion à échoué. Cette publication est introuvable, ou vous n\'avez pas le droit d\'effectuer cette suppréssion');
                        }
                    });
                    return false;
                }
            });
        });
        </script> 
                        </div>
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <?php 
            if(is_array($paginate[4]))
            {
                foreach($paginate[4] as $p)
                {
                    ?>
                            <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'].'?ajax=true';?>"><?php echo $p['text'];?></a></li>
                            <?php
                }
            }
            ?>
                        </ul>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>
