<body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="<?php echo base_url();?>"><b><?php echo _e('Tendoo CMS');?></b> <?php echo get('str_core');?></a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg"><?php _e('Please enter your database details in order to proceed to installation. ');?></p>
        <?php echo $this->notice->output_notice();?>
        <?php echo form_error('_ht_name', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> <span>', '</span></div>');?>
        <?php echo form_error('_uz_name', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> <span>', '</span></div>');?>
        <?php echo form_error('_uz_pwd', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> <span>', '</span></div>');?>
        <?php echo form_error('_db_name', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> <span>', '</span></div>');?>
        <?php echo form_error('_db_pref', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> <span>', '</span></div>');?>
        <?php echo form_error('_db_driv', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> <span>', '</span></div>');?>
        <form method="post">
        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <div class="form-group has-feedback">
            <input type="text" name="_ht_name" class="form-control" placeholder="<?php _e('Host Name');?>" value="<?php echo set_value('_ht_name', 'localhost'); ?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="_uz_name" class="form-control" placeholder="<?php _e('User Name');?>" value="<?php echo set_value('_uz_name', 'root'); ?>">
            <span class="fa fa-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="_uz_pwd" class="form-control" placeholder="<?php _e('User Password');?>" value="<?php echo set_value('_uz_pwd'); ?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="_db_name" class="form-control" placeholder="<?php _e('Database Name');?>" value="<?php echo set_value('_db_name'); ?>">
            <span class="fa fa-database form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="_db_pref" class="form-control" placeholder="<?php _e('Database Prefix');?>" value="<?php echo set_value('_db_pref', 'tendoo_'); ?>">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <select class="form-control" placeholder="<?php _e('Database Driver');?>" name="_db_driv">
            	<option value=""><?php _e('Select database driver');?></option>
            	<option <?php echo set_select('_db_driv', 'mysqli', true);?> value="mysqli"><?php _e('MySQLi');?></option> 
            </select>
          </div>
          <div class="row">
            <div class="col-xs-7">    
              <div class="checkbox icheck">
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-5">
              <button type="submit" class="btn btn-primary btn-block"><?php _e('Save Settings');?></button>
            </div><!-- /.col -->
          </div>
        </form>        

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
  
</body>
</html>