<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
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
                	<section class="panel">
                    	<div class="panel-heading">
                        Liste des articles
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th>Intitué</th>
                                        <th>Cat&eacute;gorie</th>
                                        <th>Date de creation</th>
                                        <th>Accéssibilité</th>
                                        <th>Auteur</th>
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
                                <th class="action"><a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$g['ID']));?>"><?php echo $g['TITLE'];?></a></th>
                                <th><?php echo $cat_name['CATEGORY_NAME'];?></th>
                                <th><?php echo $this->core->hubby->timespan(strtotime($g['DATE']));?></th>
                                <th><?php echo $g['ETAT'] == '1' ? 'Publi&eacute;' : 'Brouillon';?></th>
                                <th><?php echo $user['PSEUDO'];?></th>
                                <th><a class="delete" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$g['ID']));?>">Supprimer</a></th>
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
                    </section>
                </section>
            </section>
        </section>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-4">
                    <select class="input-sm form-control input-s-sm inline">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-white">Apply</button>
                </div>
                <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small> </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                     <?php 
					if(is_array($paginate[4]))
					{
						foreach($paginate[4] as $p)
						{
							?>
                            <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
							<?php
						}
					}
				?>
                    </ul>
                </div>
            </div>
        </footer>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav">EEE</a> </section>