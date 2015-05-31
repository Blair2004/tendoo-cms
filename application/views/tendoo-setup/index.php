<body class="register-page">
    <div class="register-box" style="width:50%;">
      <div class="register-logo">
        <a href="<?php echo base_url();?>"><b><?php echo __( 'Tendoo CMS' );?></b> <?php echo get( 'core-version' );?></a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg"><?php echo __( 'Thanks for having choosed Tendoo to host your project. Here is the installation wizard. This wizard has 2 more pages : Database configuration and Site configuration. If you\'re ready, let\'s go !!!' );?></p>
        <p></p>
		<p class="text-center">
        <a href="<?php echo site_url( array( 'tendoo-setup' , 'database' ) );?>" class="text-center btn btn-primary"><?php _e( 'Define Database configuration' );?></a>
        </p>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

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