<div class="login-box" style="width:600px">
    <div class="login-logo">
        <a href="<?php echo get_instance()->url->main_url();?>">
        <h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h3 class="text-center" style="margin-top:0;"><?php echo get('core_version');?></h3>
        <section class="panel">
        	<form method="post">
        	<div class="row">
            	<div class="col-lg-12">
                    <h4><i class="fa fa-exchange"></i> <?php echo translate('Connecting to database');?></h4>
                    <div>
                        <?php echo translate('before using tendoo, you must define database login information.');?>
                    </div>
                    <br>
                    <?php echo output('notice');?>
                </div>
            	<div class="col-lg-12">
                    <h4><i class="fa fa-bullseye"></i> <?php echo translate('Database Login Informations');?></h4>
                    <div class="form-group">
                        <label class="host_name"><?php echo translate('Host Name');?></label>
                        <input name="host_name" value="localhost" type="text" placeholder="<?php _e( 'localhost' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="user_name"><?php echo translate('User Name');?></label>
                        <input name="user_name" value="root" type="text" placeholder="<?php _e( 'Use Name' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="host_password"><?php echo translate('User Password');?></label>
                        <input name="host_password" type="text" placeholder="<?php _e( 'Password' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="db_name"><?php echo translate('Database Name');?></label>
                        <input name="db_name" value="tendoo" type="text" placeholder="<?php _e( 'Database' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="extension_name"><?php echo translate('Table Prefix');?></label>
                        <input name="extension_name" type="text" placeholder="<?php _e( 'lumax_' );?>" class="form-control" value="lumax_">
                    </div>
                    <div class="form-group">
                    	<label><?php _e( 'Select your database type' );?></label>
                        <select class="form-control" name="db_type" style="color:#333;background:#FFF;">
                            <option value="" style="color:#333"><?php echo translate('Database Type');?></option>
                            <option value="mysql" selected style="color:#333">Mysql</option>
                            <option value="mysqli" style="color:#333">Mysql Lite</option>
                            <option value="sqlite" style="color:#333">Sql Lite</option>
                        </select>
                    </div>
                    <button style="float:right" type="submit" class="btn btn-info"><?php echo translate('Next Step');?></button>
                </div>
            </div>
            </form>
		</section>
    </div>
    <!-- /.login-box-body -->
</div>
<script>
  $(function () {
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%' // optional
	});
  });
</script> 
