<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $module[0]['HUMAN_NAME'];?><small></small></h1>
                <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','modules'));?>"></a>
            </div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Liste des articles</h2>
                	<table class="bordered striped">
                        <thead>
                            <tr>
                                <td>Intitué</td>
                                <td>Cat&eacute;gorie</td>
                                <td>Date de creation</td>
                                <td>Accéssibilité</td>
                                <td>Auteur</td>
                            </tr>
                        </thead>
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
                                <td class="action"><a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$g['ID']));?>"><?php echo $g['TITLE'];?></a></td>
                                <td><?php echo $cat_name['CATEGORY_NAME'];?></td>
                                <td><?php echo timespan(strtotime($g['DATE']));?></td>
                                <td><?php echo $g['ETAT'] == '1' ? 'Publi&eacute;' : 'Brouillon';?></td>
                                <td><?php echo $user['PSEUDO'];?></td>
                                <td><a class="delete" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$g['ID']));?>">Supprimer</a>
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
                    <?php
					if(is_array($pagination[4]))
					{
						foreach($pagination[4] as $p)
						{
							?>
                            <a style="padding:2px 5px; display:block; float:left; margin:0px 4px 0px 0px;" href="<?php echo $p['link'];?>" class="<?php echo $p['state'];?>"><?php echo $p['text'];?></a>
                            <?php
						}
					}
					?>
                </div>
			</div>
		</div>
	</div>
</div>