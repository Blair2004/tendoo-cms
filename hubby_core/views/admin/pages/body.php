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
                <section class="scrollable wrapper w-f"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?>
                    <header class="header bg-white b-b clearfix">
                        <div class="row m-t-sm">
                            <div class="col-sm-6 m-b-xs"> 
                            	<a href="<?php echo $this->core->url->site_url(array('admin','menu'));?>" data-toggle="class:hide" class="btn btn-sm btn-info active"><i class="icon-caret-right text icon-large"></i><i class="icon-caret-left text-active icon-large"></i></a> 
                                <a href="#" class="btn btn-sm btn-success"><i class="icon-plus"></i> Retour</a> 								<a href="#" class="btn btn-sm btn-danger"><i class="icon-plus"></i> Supprimer</a>
							</div>
                            <div class="col-sm-6 m-b-xs">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" placeholder="Search">
                                    <span class="input-group-btn">
                                    <button class="btn btn-sm btn-white" type="button">Go!</button>
                                    </span> 
								</div>
                            </div>
                        </div>
                    </header>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									$ii	=	0;
                    foreach($get_pages as $g)
                    {
                        ?>
                                    <tr>
                                        <td><input type="checkbox" name="post[]" value="<?php echo $g['ID'];?>"></td>
                                        <td><a href="<?php echo $this->core->url->site_url('admin/pages/edit/'.$g['PAGE_CNAME']);?>" data-toggle="modal"><?php echo $g['PAGE_NAMES'];?></a></td>
                                        <td><?php echo $g['PAGE_TITLE'];?></td>
                                        <td><?php echo $g['PAGE_DESCRIPTION'];?></td>
                                        <td><?php echo ($g['PAGE_MAIN'] == 'TRUE') ? 'Oui' : 'Non';?></td>
                                        <td><?php echo $g['PAGE_MODULES'] === FALSE ? 'Aucun module' : $g['PAGE_MODULES'][0]['HUMAN_NAME'];?></td>
                                        <td></td>
									</tr>
                                <?php
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
                        <li><a href="#"><i class="icon-chevron-left"></i></a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#"><i class="icon-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
