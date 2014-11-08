<?php echo get_core_vars( 'inner_head' );?>
<section>
    <section class="hbox stretch">
        <?php echo get_core_vars( 'lmenu' );?>
        <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/la-liste-des-utilisateurs" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </header>
            <div class="wrapper w-f">
                <div class="hub_table">
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php output('notice');?>
                    <?php echo fetch_error_from_url();?>
                    <section class="panel">
                        <div class="wrapper b-b font-bold"><?php _e( 'Users' );?></div>
                        <table class="table table-striped m-b-none">
                            <thead>
                                <tr>
                                    <td width="100"><?php _e( 'Id' );?></td>
                                    <td width="300"><?php _e( 'Pseudo' );?></td>
                                    <td><?php _e( 'Status' );?></td>
                                    <td><?php _e( 'Role' );?></td>
                                    <td><?php _e( 'Email' );?></td>
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
                                    <td><a href="<?php echo $this->instance->url->site_url(array('admin','users','edit',$s['PSEUDO']));?>"><?php echo $s['PSEUDO'];?></a></td>
                                    <td><?php echo $priv[0]['HUMAN_NAME'];?></td>
                                    <td><?php echo $s['PRIVILEGE']	==	'RELPIMSUSE' ? __( 'Unavailable' ) : $s['PRIVILEGE'];?></td>
                                    <td><?php echo $s['EMAIL'] == '' ? __( 'Unavailable' ) : $s['EMAIL'];?></td>
                                </tr>
                                <?php
									}
								}
								else
								{
								?>
                                <tr>
                                    <td colspan="5"><?php _e( 'No user created' );?></td>
                                </tr>
                                <?php
								}
							}
							else
							{
								?>
                                <tr>
                                    <td colspan="3"><?php _e( 'No user created' );?></td>
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
</section>