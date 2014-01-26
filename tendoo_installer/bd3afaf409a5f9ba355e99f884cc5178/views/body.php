<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
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
                <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                    <section class="panel">
                        <div class="panel-heading"> Liste des widgets </div>
                        <table class="table table-striped b-t text-sm">
                            <thead>
                                <tr>
                                    <td width="350">Nom du widget</td>
                                    <td>Type</td>
                                    <td>Position</td>
                                    <td>Etat</td>
                                    <td>Position</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
			if(is_array($getWidgets))
			{
				foreach($getWidgets as $w)
				{
				?>
                                <tr>
                                    <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$w['ID']));?>"><?php echo $w['WIDGET_HEAD'];?></a></td>
                                    <td><?php echo $w['WIDGET_REFERING_OBJ_NAMESPACE'] == "" ? "Simple" : "Li&eacute;e &agrave; un module";?></td>
                                    <td><?php echo $w['WIDGET_ORDER'];?></td>
                                    <?php
					if($w['WIDGET_ETAT'] == 0)
					{
						?>
                                    <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'index',$currentPage,'activate',$w['ID']));?>"><?php echo $w['WIDGET_ETAT'] == 0 ? "Non actif" : "Actif";?></a></td>
                                    <?php
					}
					else
					{
						?>
                                    <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'index',$currentPage,'disable',$w['ID']));?>"><?php echo $w['WIDGET_ETAT'] == 0 ? "Non actif" : "Actif";?></a></td>
                                    <?php
					}
					if($w['WIDGET_ORDER'] == 0)
					{
						?>
                                    <td><a href="#">----</a></td>
                                    <?php
					}
					else
					{
					?>
                                    <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'index',$currentPage,'goUp',$w['ID']));?>">Monter</a></td>
                                    <?php
					}
					?>
                                    <td><form method="post">
                                            <input type="hidden" name="id_fordeletion" value="<?php echo $w['ID'];?>" />
                                            <a href="#" class="linkForDeletion">Supprimer</a>
                                        </form></td>
                                </tr>
                                <?php
				}
			}
			else
			{
				?>
                                <tr>
                                    <td colspan="6">Aucun widget disponible</td>
                                </tr>
                                <?php
			}
			?>
                            </tbody>
                            <script>
				$('.linkForDeletion').bind('click',function(){
					if(confirm('Voulez vous vraiment supprimer ce widget'))
					{
						$(this).closest('form').submit();
					}
					return false;
				});
			</script>
                        </table>
                    </section>
                </section>
            </section>
        </section>
        <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-sm-4">
                        
                    </div>
                    <div class="col-sm-4 text-center">  </div>
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
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
