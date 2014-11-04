    <div class="container">
		<?php echo validation_errors();?>
        <?php echo output('notice');?>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <section class="panel">
                    <header class="panel-heading"><?php _e( 'Change your password' );?></header>
                    <section class="chat-list panel-body">
                    	<form method="post" class="panel-body">
                        	<div class="form-group">
                                <label class="control-label"><?php _e( 'New password' );?></label>
                                <input type="password" name="password_new" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php _e( 'Confirm your new password' );?></label>
                                <input type="password" name="password_new_confirm" class="form-control" />
                            </div>
                            <div class="form-group">
                            	<p><?php _e( 'The new password should not match the old one.' );?></p>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="<?php _e( 'Save the new password' );?>" class="btn btn-primary" />
                            </div>
                        </form>
                    </section>
                </section>
            </div>
        </div>
    </div>
