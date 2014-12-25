    <section id="content" class="wrapper-md animated fadeInUp scrollable wrapper"> 
        <div class="row">
            <div class="col-lg-4 col-sm-offset-2">
            	<section class="panel">
                	<div class="panel-heading"><?php _e( 'Create a Super Administrator' );?></div>
                	<form method="post" class="panel-body">
                        <div class="form-group text">
                        	<label class="control-label"><?php _e( 'Pseudo' );?></label>
                            <input type="text" name="super_admin_pseudo" class="form-control" placeholder="<?php _e( 'Pseudo' );?>" />
                            <span><?php echo form_error('super_admin_pseudo');?></span>
                        </div>
                        <div class="form-group password">
                        	<label class="control-label"><?php _e( 'Password' );?></label>
                            <input class="form-control" type="password" name="super_admin_password" placeholder="<?php _e( 'Password' );?>"/>
                            <span><?php echo form_error('super_admin_password');?></span>
                        </div>
                        <div class="form-group password">
                        	<label class="control-label"><?php _e( 'Confirm Password' );?></label>
                            <input class="form-control" type="password" name="super_admin_password_confirm" placeholder="<?php _e( 'Confirm Password' );?>"/>
                            <span><?php echo form_error('super_admin_password_confirm');?></span>
                        </div>
                        <div class="form-group text">
                        	<label class="control-label"><?php _e( 'Email' );?></label>
                            <input class="form-control" type="text" name="super_admin_mail" placeholder="<?php _e( 'Email' );?>"/>
                            <span><?php echo form_error('super_admin_mail');?></span>
                        </div>
                        <div class="form-group select">
                        	<label class="control-label"><?php _e( 'Sex' );?></label>
                            <select class="form-control" name="super_admin_sex">
                                <option value=""><?php _e( 'Select' );?></option>
                                <option value="MASC"><?php _e( 'Male' );?></option>
                                <option value="FEM"><?php _e( 'Female' );?></option>
                            </select>
                            <span><?php echo form_error('super_admin_sex');?></span>
                        </div>
                        <input class="btn btn-info" type="submit" value="<?php _e( 'Create User' );?>" />
                        <input class="btn btn-darken" type="reset" value="<?php _e( 'Reset' );?>" />
                    </form>
                </section>                
            </div>
            <div class="col-lg-4">
            	<section class="panel">
                    <header class="panel-heading"><?php _e( 'Why this page' );?></header>
                    <div class="panel-body"><?php _e( 'the super administrator is the user who have all permissions. he can\'t access dashboard without restriction. He can create, edit and delete other users. Make sure to create that user now, because dashboard won\'t be available if not.' );?>
                    </div>
                </section>
            </div>
        </div>
    </section>