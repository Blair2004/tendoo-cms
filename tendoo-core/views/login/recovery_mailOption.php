    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-offset-3">
            	<?php echo validation_errors();?>
				<?php echo output('notice');?>
                <section class="panel">
                    <header class="panel-heading"><h4><?php _e( 'Receive the activation mail' );?></h4></header>
                    <section class="chat-list panel-body">
                    	<form method="post" class="panel-body">
                        	<div class="form-group">
                                <label class="control-label"><?php _e( 'Email' );?></label>
                                <input name="email_valid" type="text" class="form-control" />
                            </div>
                            <div class="form-group">
                            	<p><?php _e( 'Please, enter the account\'s email address for which you require a activation mail. If this email is valid, the activation mail will be sended.<br>The activation mails expire within 48 hours. After this, you should try again.' );?></p>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="<?php _e( 'Receive the activation mail' );?>" class="btn btn-primary" />
                            </div>
                        </form>
                    </section>
                </section>
            </div>
        </div>
    </div>
