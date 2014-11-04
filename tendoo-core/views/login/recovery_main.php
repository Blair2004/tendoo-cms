    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <section class="panel">
                    <header class="panel-heading"><h4><?php _e( 'Details on the account recovery wizard' );?></h4></header>
                    <section class="chat-list panel-body">
                    	<p><?php _e( 'those wizards, allow you to recover an account when :');?> </p>
                        <ul>
                        	<li><?php _e( 'His not yet activated' );?></li>
                            <li><?php _e( 'His password has been forgotten' );?></li>
                        </ul>
                        <p><?php _e( 'Use "receive activation mail" when an account is not active and when you haven\'t receive an activation email. Use "password forgotten" when you don\'t remember your password.' );?></p>
                        <br />
                        <div class="line line-dashed"></div>
                        <a href="<?php echo $this->instance->url->site_url(array('login','recovery','password_lost'));?>" class="btn btn-primary"><?php _e( 'Password forgotten recovery wizard' );?></a>
                        <a href="<?php echo $this->instance->url->site_url(array('login','recovery','receiveValidation'));?>" class="btn btn-info"><?php _e( 'Activation mail wizard' );?></a>
                    </section>
                </section>
            </div>
        </div>
    </div>
