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
                <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?>
                	<section class="panel">
                    	<div class="panel-heading">
                        Liste des modules installés
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th width="300">Nom</th>
                                        <th>Auteur</th>
                                        <th>Description</th>
                                        <th>Actif</th>
                                        <th>Type</th>
                                        <th>Etat</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php
									if($mod_nbr > 0)
                					{
                    foreach($modules as $mod)
                    {
                        ?>
                    <tr>
                        <td class="action"><a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$mod['ID']));?>"><?php echo $mod['HUMAN_NAME'];?></a></td>
                        <td><?php echo $mod['AUTHOR'];?></td>
                        <td><?php echo $mod['DESCRIPTION'];?></td>
                        <td><?php echo ($mod['ACTIVE'] == 'TRUE') ? 'Oui' : 'Non';?></td>
                        <td><?php echo ($mod['TYPE'] == 'GLOBAL') ? 'Globale' : 'Unique';?></td>
                        <td class="action"><a class="delete" href="<?php echo $this->core->url->site_url(array('admin','uninstall','module',$mod['ID']));?>">Desinstaller</a></td>
                        <td>
						<?php
						if($mod['ACTIVE'] == '0')
						{
							?>
                            <a class="delete" href="<?php echo $this->core->url->site_url(array('admin','active','module',$mod['ID']));?>">Activer</a>
                            <?php
						}
						else
						{
							?>
                            <a class="delete" href="<?php echo $this->core->url->site_url(array('admin','unactive','module',$mod['ID']));?>">D&eacute;sactiver</a>
                            <?php
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
                        <td colspan="6">Aucun module install&eacute;</td>
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
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav">EEE</a> </section>