<?php echo get_core_vars( 'inner_head' );?>

<section id="content">
<section class="hbox stretch">
    <?php echo get_core_vars( 'lmenu' );?>
    <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted">
                            <?php echo get_page('description');?>
                        </p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/comment-creer-un-utilisateur" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i> </a>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f">
                    <?php echo output('notice');?> <?php echo validation_errors();?> <?php echo fetch_error_from_url();?>
                    <div class="row">
                        <div class="col-lg-8">
                            <section class="panel">
                                <header class="panel-heading text-center"><?php _e( 'Create a new user' );?></header>
                                <form method="post" class="panel-body">
                                    <div class="form-group">
                                        <label class="label-control"><?php _e( 'Pseudo' );?></label>
                                        <input type="text" class="form-control" name="admin_pseudo" placeholder="<?php _e( 'User pseudo' );?>" />
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control"><?php _e( 'Password' );?></label>
                                        <input type="password" class="form-control" name="admin_password" placeholder="<?php _e( 'User password' );?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control"><?php _e( 'Confirm password' );?></label>
                                        <input type="password" class="form-control" name="admin_password_confirm" placeholder="<?php _e( 'Confirm password' );?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control"><?php _e( 'User Email' );?></label>
                                        <input type="text" class="form-control" name="admin_password_email" placeholder="<?php _e( 'Email' );?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control"><?php _e( 'Sex' );?></label>
                                        <select name="admin_sex" class="form-control">
                                            <option value=""><?php _e( 'Choose...' );?></option>
                                            <option value="MASC"><?php _e( 'Male' );?></option>
                                            <option value="FEM"><?php _e( 'Female' );?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control"><?php _e( 'Choose a role' );?></label>
                                        <select name="admin_privilege" class="form-control">
                                            <option class="form-control" value=""><?php _e( 'Choose...' );?></option>
                                            <option value="RELPIMSUSE"><?php _e( 'User' );?></option>
                                            <?php
												foreach($getPrivs as $p)
												{
													?>
                                            <option value="<?php echo $p['PRIV_ID'];?>"><?php echo $p['HUMAN_NAME'];?></option>
                                            <?php
												}
												?>
                                        </select>
                                    </div>
                                    <input class="btn btn-sm <?php echo theme_button_class();?>" type="submit" value="<?php _e( 'Create the user' );?>" />
                                    <input type="reset" class="btn btn-sm btn-danger" value="<?php _e( 'Reset Fields' );?>" />
                                </form>
                            </section>
                        </div>
                        <div class="col-lg-4">
                            <?php
$field_1	=	(form_error('admin_pseudo')) ? form_error('admin_pseudo') : tendoo_info( __( 'Pseudo must be unique, such as email' ) ) . '<br>';
$field_2	=	(form_error('admin_password')) ? form_error('admin_password') : tendoo_info( __( 'Email can be used to reset password' ) ) . '<br>';
$field_3	=	(form_error('admin_password_confirm')) ? form_error('admin_password_confirm') : tendoo_info( __( 'Choosing a role, is adding a user to a specific group with permissinos' ) ) . '<br>';
$field_6	=	(form_error('admin_password_email')) ? form_error('admin_password_email') : __( 'Email' );
$field_4	=	(form_error('admin_sex')) ? form_error('admin_sex') : '';
$field_5	=	(form_error('admin_privilege')) ? form_error('admin_privilege') : '';
?>
                            <section class="panel">
                                <header class="panel-heading text-center"> <?php _e( 'More about' );?> </header>
                                <div class="wrapper">
                                    <?php if(strlen($field_1) > 0):;?>
                                    <?php echo $field_1; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_2) > 0):;?>
                                    <?php echo $field_2; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_3) > 0):;?>
                                    <?php echo $field_3; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_4) > 0):;?>
                                    <?php echo $field_4; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_5) > 0):;?>
                                    <?php echo $field_5; ?>
                                    <?php endif;?>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
                <footer class="footer bg-white b-t">
                    <div class="row m-t-sm text-center-xs">
                        <div class="col-sm-2" id="ajaxLoading">
                        </div>
                        <div class="col-sm-10 text-right text-center-xs">
                        </div>
                    </div>
                </footer>
            </section>
        </section>
    </section>
</section>
