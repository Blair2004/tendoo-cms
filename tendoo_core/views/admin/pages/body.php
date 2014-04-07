<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
            	<div class="col-sm-2" id="ajaxLoading">
                </div>
                <div class="col-sm-4 col-sm-offset-6 text-right text-center-xs">
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
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
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
                                        <th title="Sous menus">Ordre</th>
                                    </tr>
                                </thead>
                                <tbody id="controllersList">
                                    <?php
									$ii	=	0;
									if($get_pages)
									{
                    foreach($get_pages as $g)
                    {						
                        ?>
                                    <tr title="racine">
                                        <td><em class="fa fa-list-ul"></em></td>
                                        <td><a href="<?php echo $this->core->url->site_url('admin/pages/edit/'.$g['PAGE_CNAME']);?>" data-toggle="modal"><?php echo $g['PAGE_NAMES'];?></a></td>
                                        <td><?php echo $g['PAGE_TITLE'];?></td>
                                        <td><?php echo $g['PAGE_DESCRIPTION'];?></td>
                                        <td><?php echo ($g['PAGE_MAIN'] == 'TRUE') ? 'Oui' : 'Non';?></td>
                                        <td><?php echo $g['PAGE_MODULES'] === FALSE ?  'Aucun module' : $g['PAGE_MODULES'][0]['HUMAN_NAME'];?></td>
                                        <td><a onclick="if(!confirm('voulez-vous supprimer ce contrôleur ?')){return false}" href="<?php echo $this->core->url->site_url('admin/pages/delete/'.$g['PAGE_CNAME']);?>">Supprimer</a></td>
                                        <td>
                                        <?php
										if($g['PAGE_POSITION'] != '0')
										{
											if(count($get_pages) > 1)
											{
											?>
                                            <a class="upTaker" href="javascript:void(0)" data-url="<?php echo $this->core->url->site_url(array('admin','ajax','upController',$g['ID']));?>" data-requestType="silent"><i class="fa fa-level-up" style="font-size:15px;"></i></a>
                                            <?php
											}
											else
											{
											?>
                                            <a class="upTaker" href="javascript:void(0)" silent-ajax-event="lock" data-url="<?php echo $this->core->url->site_url(array('admin','ajax','upController',$g['ID']));?>" data-requestType="silent">---</a>
                                            <?php
											}
										}
										else
										{
											?>
                                            <a class="upTaker" href="javascript:void(0)" silent-ajax-event="lock" data-url="<?php echo $this->core->url->site_url(array('admin','ajax','upController',$g['ID']));?>" data-requestType="silent">---</a>
                                            <?php
										}
										?>
                                        </td>
									</tr>
                                <?php
								$this->core->tendoo_admin->getChildren($ii,$g['PAGE_CHILDS']);
								$ii++;
                    }
									}
									else
									{
										?>
                                        <tr>
                                        	<td colspan="8">Aucun contr&ocirc;leur disponible</td>
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
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
