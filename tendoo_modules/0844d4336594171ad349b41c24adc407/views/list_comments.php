<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
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
                        Liste des commentaires
                        </div>
                        <div class="table-responsive">
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
                                        <td colspan="5">Aucun commentaire publié</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
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
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>