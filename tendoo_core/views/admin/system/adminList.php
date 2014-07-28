<?php echo get_core_vars( 'lmenu' );?>
<section id="content">
    <section class="vbox"><?php echo get_core_vars( 'inner_head' );?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <div class="wrapper w-f">
                <div class="hub_table">
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php output('notice');?>
                    <?php echo fetch_error_from_url();?>
                    <section class="panel">
                        <div class="wrapper b-b font-bold">Liste des utilisateurs</div>
                        <table class="table table-striped m-b-none">
                            <thead>
                                <tr>
                                    <td width="100">Identifiant</td>
                                    <td width="300">pseudo</td>
                                    <td>Status</td>
                                    <td>Privil&egrave;ge</td>
                                    <td>Email</td>
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
										$priv	=	$this->instance->tendoo_admin->getPrivileges($s['PRIVILEGE']);
										if(!$priv)
										{
											$priv[0]['HUMAN_NAME']	=	$this->instance->users_global->convertCurrentPrivilege($s['PRIVILEGE']);
										}
								?>
                                <tr>
                                    <td><?php echo $s['ID'];?></td>
                                    <td><a href="<?php echo $this->instance->url->site_url(array('admin','system','editAdmin',$s['PSEUDO']));?>"><?php echo $s['PSEUDO'];?></a></td>
                                    <td><?php echo $priv[0]['HUMAN_NAME'];?></td>
                                    <td><?php echo $s['PRIVILEGE']	==	'RELPIMSUSE' ? 'Indisponible' : $s['PRIVILEGE'];?></td>
                                    <td><?php echo $s['EMAIL'] == '' ? 'Indisponible' : $s['EMAIL'];?></td>
                                </tr>
                                <?php
									}
								}
								else
								{
								?>
                                <tr>
                                    <td colspan="5">Aucun administrateur cr&eacute;e.</td>
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