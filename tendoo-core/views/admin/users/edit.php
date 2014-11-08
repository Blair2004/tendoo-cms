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
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/comment-modifier-un-utilisateur" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i>
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
                        <div class="wrapper b-b"><?php _e( 'Edit user' );?></div>
                        <div class="wrapper w-f">
                            <form method="post" class="class-body">
                                <div class="form-group">
                                	<label class="label-control"><?php _e( 'User pseudo' );?></label>
                                    <input type="text" class="form-control" disabled="disabled" value="<?php echo $adminInfo['PSEUDO'];?>" />
                                </div>
                                <div class="form-group">
                                	<label class="label-control"><?php _e( 'Email' );?></label>
                                    <input placeholder="<?php _e( 'Enter email' );?>" type="text" class="form-control" name="user_email" value="<?php echo $adminInfo['EMAIL'];?>" />
                                </div>
                                <div class="form-group">
                                	<label class="label-control"><?php _e( 'Change his role' );?></label>
                                    <select name="edit_priv" class="form-control">
                                        <option value=""><?php _e( 'Choose...' );?></option>
                                        <option value="RELPIMSUSE" <?php
										if($adminInfo['PRIVILEGE'] == 'RELPIMSUSE')
										{
											?> selected="selected"<?php
										}
                                        ?>><?php _e( 'User' );?></option>
                                        <?php
											foreach($getPrivs as $p)
											{
												if($adminInfo['PRIVILEGE'] == $p['PRIV_ID'])
												{
												?>
                                        <option value="<?php echo $p['PRIV_ID'];?>" selected="selected"><?php echo $p['HUMAN_NAME'];?></option>
                                        <?php
												}
												else
												{
												?>
                                        <option value="<?php echo $p['PRIV_ID'];?>"><?php echo $p['HUMAN_NAME'];?></option>
                                        <?php
												}
											}
											?>
                                    </select>
                                </div>
                                <input type="hidden" value="<?php echo $adminInfo['PSEUDO'];?>" name="current_admin" />
                                <input type="submit" class="btn btn-sm <?php echo theme_button_class();?>" value="<?php _e( 'Edit user' );?>" name="set_admin" />
                                <input type="submit" class="btn btn-sm btn-danger" value="<?php _e( 'Delete' );?> <?php echo $adminInfo['PSEUDO'];?>" name="delete_admin"/>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </section>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-2" id="ajaxLoading">
                </div>
            </div>
        </footer>
        </section>
    </section>
</section>