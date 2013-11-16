<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <div class="wrapper w-f">
                <div class="hub_table">
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php $this->core->notice->parse_notice();?>
                    <?php echo notice_from_url();?>
                    <section class="panel">
                        <div class="wrapper b-b font-bold">Liste des administrateurs</div>
                        <table class="table table-striped m-b-none">
                            <thead>
                                <tr>
                                    <td width="100">Identifiant</td>
                                    <td width="300">pseudo</td>
                                    <td>Status</td>
                                    <td>Privil&egrave;ge</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							if(is_array($subadmin))
							{
								if(count($subadmin) > 0)
								{
									foreach($subadmin as $s)
									{
										$priv	=	$this->core->hubby_admin->getPrivileges($s['PRIVILEGE'])
								?>
                                <tr>
                                    <td><?php echo $s['ID'];?></td>
                                    <td><a href="<?php echo $this->core->url->site_url(array('admin','system','editAdmin',$s['PSEUDO']));?>"><?php echo $s['PSEUDO'];?></a></td>
                                    <td><?php echo $priv[0]['HUMAN_NAME'];?></td>
                                    <td><?php echo $s['PRIVILEGE'];?></td>
                                </tr>
                                <?php
									}
								}
								else
								{
								?>
                                <tr>
                                    <td colspan="3">Aucun administrateur cr&eacute;e.</td>
                                </tr>
                                <?php
								}
							}
							else
							{
								?>
                                <tr>
                                    <td colspan="3">Aucun administrateur cr&eacute;e.</td>
                                </tr>
                                <?php
							}
							?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
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
                    <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">Montre <?php echo $paginate[1];?> &agrave; <?php echo $paginate[2];?> sur <?php echo $ttAdmin;?> El&eacute;ments</small> </div>
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