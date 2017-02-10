<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 	@details : Login body page
 *	@role : This page page is used to displays login form
 * 	@since : 1.5
 *
**/
?>
<body class="login-page">
    <div class="login-box">
        <div class="register-logo">
            <?php
            $logo   =   '<a href="' . base_url() . '"><b>' . __('Tendoo CMS') . '</b> ' . get('str_core') . '</a>';
            echo $this->events->apply_filters( 'signin_logo', $logo );
            ?>
        </div>
      <div class="login-box-body">
        <p class="login-box-msg"><?php echo $this->events->apply_filters('signin_notice_message', $this->lang->line('signin-notice-message'));?></p>
        <p><?php echo(validation_errors()) != '' ? tendoo_error(strip_tags(validation_errors())) : '';?></p>
        <p><?php echo fetch_notice_from_url();?></p>
        <p>
		<?php
            $this->events->do_action('displays_public_errors');
        ?></p>
        <form method="post">
        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        	<?php $this->events->do_action('display_login_fields');?>
        </form>

		<?php
        global $Options;
        if (intval(riake('site_registration', $Options)) == true) {
            ?>
        <a href="<?php echo site_url(array( 'sign-in', 'recovery' )) ;
            ?>"><?php _e('I Lost My Password');
            ?></a><br>
		<?php
        // Should checks whether a registration is enabled
        ?>
        <a href="<?php echo site_url(array( 'sign-up' ));
            ?>" class="text-center"><?php _e('Sign Up');
            ?></a>
		<?php
        } ;?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
    <?php echo $this->events->do_action( 'common_footer' );?>
</body>
</html>
