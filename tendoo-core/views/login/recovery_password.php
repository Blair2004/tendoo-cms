    <div class="container">
        <div class="row">
			<?php echo output('notice');?>
            <?php echo validation_errors();?>
            <div class="col-lg-6 col-lg-offset-3">
                <section class="panel">
                    <header class="panel-heading"><h4><?php _e( 'Password lost' );?></h4></header>
                    <section class="chat-list panel-body">
                    	<form method="post" class="panel-body">
                        	<div class="form-group">
                                <label class="control-label"><?php _e( 'Email' );?></label>
                                <input name="email_valid" type="text" class="form-control" />
                            </div>
                            <div class="form-group">
                            	<p><?php _e( 'Please, enter the account\'s email address for which you require a password recovery. Changing password will expire within 3 hours, after that a new recovery should be attempted again.' );?></p>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="<?php _e( 'Attemp to recover a password' );?>" class="btn btn-primary" />
                            </div>
                        </form>
                    </section>
                </section>
            </div>
        </div>
    </div>
