<body class="register-page">
    <div class="register-box" style="width:50%;">
      <div class="register-logo">
        <a href="<?php echo base_url();?>"><b><?php echo __('Tendoo CMS');?></b> <?php echo get('str_core');?></a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg"><?php echo _e("Thank for having chosen Tendoo to host your project. Here is the installation wizard. This wizard has 2 more pages : Database configuration and Site configuration. If you're ready, let's go !!!");?></p>
        <p></p>
        <form action="">
        	<div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><?php _e('Select your language');?></button>
              </span>
              <select type="text" class="form-control" name="lang">
              	<?php
                foreach (get_instance()->config->item('supported_languages') as $key => $value) {
                    ?>
                    <option <?php echo $key == riake('lang', $_GET) ? 'selected="selected"': '';
                    ?> value="<?php echo $key;
                    ?>"><?php echo $value;
                    ?></option>
                    <?php

                }
                ?>
              </select>
            </div><!-- /input-group -->
        </form>
        <br>
		<p class="text-center">
        <a href="<?php echo site_url(array( 'do-setup', 'database' )) . (riake('lang', $_GET) ? '?lang=' . $_GET[ 'lang' ] : '');?>" class="text-center btn btn-primary"><?php _e('Define Database configuration');?></a>
        </p>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <script>
	"use strict";
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
