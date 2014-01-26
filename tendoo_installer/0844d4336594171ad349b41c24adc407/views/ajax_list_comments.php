<section class="hbox stretch"><?php echo $ajaxMenu;?>
    
    <section id="content">
        <section class="vbox">
            <section class="scrollable wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Liste des commentaires</h4>
                        <section class="scrollable">
                            <div class="panel">
                                <table class="table table-striped m-b-none">
                                    <thead>
                                        <tr>
                                            <th>Auteur</th>
                                            <th width="400">Aperçu</th>
                                            <th>Article</th>
                                            <th>Publi&eacute; le</th>
                                            <th>Approuv&eacute;</th>
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
                                            <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'comments_manage',$g['ID'].'?ajax=true'));?>"><?php echo word_limiter($g['CONTENT'],20);?></a></td>
                                            <td><?php 
                                        $article	=	$news->getSpeNews($g['REF_ART']);
                                        echo $article[0]['TITLE'];
                                        ?></td>
                                            <td><?php echo timespan($g['DATE']);?></td>
                                            <td><?php
                                        if($setting['APPROVEBEFOREPOST'] == 0)
                                        {
                                            echo 'Indisponible';
                                        }
                                        else
                                        {
                                            echo $g['SHOW'] == '0' ? 'Non' : 'Oui';
                                        }
                                        ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <tr>
                                            <td colspan="5">Aucun commentaire publié</td>
                                        </tr>
                                        <?php
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
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