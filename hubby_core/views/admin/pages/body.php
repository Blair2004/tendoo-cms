<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
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
					 if(isset($paginate))
					 {
					if(is_array($paginate[4]))
					{
						foreach($paginate[4] as $p)
						{
							?>
                            <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
							<?php
						}
					}
					 }
				?>
                    </ul>
                </div>
            </div>
        </footer>
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
                <section class="wrapper w-f"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?>
                    <section class="panel">
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th width="20"><input type="checkbox"></th>
                                        <th width="20">Contr&ocirc;leur</th>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Principale</th>
                                        <th>Module affect&eacute;</th>
                                        <th>Control</th>
                                        <th title="Sous menus">Nbr Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									$ii	=	0;
									
                    foreach($get_pages as $g)
                    {						
                        ?>
                                    <tr title="racine">
                                        <td><em class="icon-sort-by-attributes-alt"></em></td>
                                        <td><a href="<?php echo $this->core->url->site_url('admin/pages/edit/'.$g['PAGE_CNAME']);?>" data-toggle="modal"><?php echo $g['PAGE_NAMES'];?></a></td>
                                        <td><?php echo $g['PAGE_TITLE'];?></td>
                                        <td><?php echo $g['PAGE_DESCRIPTION'];?></td>
                                        <td><?php echo ($g['PAGE_MAIN'] == 'TRUE') ? 'Oui' : 'Non';?></td>
                                        <td><?php echo $g['PAGE_MODULES'] === FALSE ?  'Aucun module' : $g['PAGE_MODULES'][0]['HUMAN_NAME'];?></td>
                                        <td><a onclick="if(!confirm('voulez-vous supprimer ce contrôleur ?')){return false}" href="<?php echo $this->core->url->site_url('admin/pages/delete/'.$g['PAGE_CNAME']);?>">Supprimer</a></td>
                                        <td><?php echo count($g['PAGE_CHILDS']);?></td>
									</tr>
                                <?php
								$this->core->hubby_admin->getChildren($ii,$g['PAGE_CHILDS']);
								$ii++;
                    }
                        ?>
                                    </tbody>
                                
                            </table>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
