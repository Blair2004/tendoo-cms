<body class="register-page">
    <div class="register-box">
        <div class="register-logo">
            <?php
            $logo   =   '<a href="' . base_url() . '"><b>' . __('Tendoo CMS') . '</b> ' . get('str_core') . '</a>';
            echo $this->events->apply_filters( 'signin_logo', $logo );
            ?>
        </div>
      <div class="register-box-body">
        <p class="login-box-msg"><?php _e('Sign up to');?></p>
        <p><?php echo validation_errors( '<div class="alert alert-danger">', '</div>');?></p>
        <p><?php echo $this->notice->output_notice();?></p>
        <form  method="post">
        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <?php echo $this->events->apply_filters('displays_registration_fields', '');?>
        </form>
        <?php
        // May checks whether recovery is enabled
        ?>
        <a href="<?php echo site_url(array( 'sign-in', 'recovery' )) ;?>"><?php _e('I Lost My Password');?></a><br>
        <?php
        // may checks whether login if login is enabled
        ?>
        <a href="<?php echo site_url(array( 'sign-in' ));?>" class="text-center"><?php _e('I Already Have An Account');?></a><br>

      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
    <?php echo $this->events->do_action( 'common_footer' );?>
</body>
</html>
