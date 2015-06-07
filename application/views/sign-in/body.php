<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
        <a href="<?php echo base_url();?>"><b><?php echo __( 'Tendoo CMS' );?></b> <?php echo get( 'core-version' );?></a>
      </div>
      <div class="login-box-body">
        <p class="login-box-msg"><?php echo $this->events->apply_filters( 'signin_notice_message' , $this->lang->line( 'signin_notice_message' ) );?></p>
        <p><?php echo ( validation_errors() ) != '' ? tendoo_error( strip_tags( validation_errors() ) ) : '';?></p>
        <p><?php echo fetch_notice_from_url();?></p>
        <p>
		<?php 
			$errors	=	$this->users->auth->get_errors_array();
			if( $errors )
			{
				foreach( $errors as $error )
				{
					echo tendoo_error( $error );
				}
			}
		?></p>
        <form method="post">
        	<?php $this->events->do_action( 'display_login_fields' );?>
        </form>
        
		<?php
		// May checks whether recovery is enabled
		?>
        <a href="<?php echo site_url( array( 'sign-in' , 'recovery' ) ) ;?>"><?php _e( 'I lost my password' );?></a><br>
		<?php
        // Should checks whether a registration is enabled
        ?>
        <a href="<?php echo site_url( array( 'sign-up' ) );?>" class="text-center"><?php _e( 'Sign Up' );?></a>

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
  
</body>
</html>