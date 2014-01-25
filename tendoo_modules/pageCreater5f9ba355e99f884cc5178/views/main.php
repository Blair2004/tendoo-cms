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
                        Liste des page cr&eacute;er
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Description</th>
                                        <th>Date de creation</th>
                                        <th>Auteur</th>
                                        <th>Lien</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
                                if(count($getPages) > 0)
                                {
                                    foreach($getPages as $g)
                                    {
                                        $user	=	$this->core->users_global->getUser($g['AUTHOR'])
                                ?>
                                    <tr>
                                        <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$g['ID']));?>"><?php echo $g['TITLE'];?></a></td>
                                        <td><?php echo $g['DESCRIPTION'];?></td>
                                        <td><?php echo $g['DATE'];?></td>
                                        <td><?php echo $user['PSEUDO'];?></td>
                                        <td><a href="<?php echo $this->core->url->site_url(array('hub_pages','index',$g['ID']));?>"><?php echo $this->core->url->site_url(array('hub_pages','index',$g['ID']));?></a></td>
                                        <td><a onClick="if(confirm('Voulez-vous vraiment supprimer cette page ?')){return true;}else{return false};" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$g['ID']));?>">Supprimer</a></td>
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr>
                                        <td colspan="6">Aucune page n'a &eacute;t&eacute; cr&eacute;e.</td>
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
                    
                </div>
                <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm"></small> </div>
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