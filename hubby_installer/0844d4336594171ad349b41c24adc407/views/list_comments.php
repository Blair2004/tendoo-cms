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
					<?php echo notice_from_url();?>
                	<h2>Liste des commentaires</h2>
                	<table class="bordered striped">
                        <thead>
                            <tr>
                                <td>Auteur</td>
                                <td width="400">Aperçu</td>
                                <td>Article</td>
                                <td>Publi&eacute; le</td>
                                <td>Approuv&eacute;</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(count($getComments) > 0)
                        {
                            foreach($getComments as $g)
                            {
								if($g['AUTEUR'] != '0')
								{
									$user				=	$this->core->users_global->getUser($g['AUTEUR']);
								}
								else
								{
									$user['PSEUDO']		=	$g['OFFLINE_AUTEUR'];
								}
                        ?>
                            <tr>
                                <td><?php echo $user['PSEUDO'];?></td>
                                <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'comments_manage',$g['ID']));?>"><?php echo word_limiter($g['CONTENT'],20);?></a></td>
                                <td><?php 
								$article	=	$news->getSpeNews($g['REF_ART']);
								echo $article[0]['TITLE'];
								?></td>
                                <td><?php echo timespan($g['DATE']);?></td>
                                <td>
                                <?php
								if($setting['APPROVEBEFOREPOST'] == 0)
								{
									echo 'Indisponible';
								}
								else
								{
									echo $g['SHOW'] == '0' ? 'Non' : 'Oui';
								}
								?>
                                </td>
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
                </div>
			</div>
		</div>
	</div>
</div>