<div class="login-box" style="width:600px">
  <div class="login-logo">
  	<a href="<?php echo get_instance()->url->main_url();?>">
    <h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
    </a>
  </div><!-- /.login-logo -->
  <div class="login-box-body">
   	<h3 class="text-center" style="margin-top:0;"><?php echo get('core_version');?></h3>
    <form action="" method="post">
    	<div class="row">
        	<div class="col-lg-12">
            	<p>
				<?php _e( 'Welcome. If you see this page, it means that tendoo seems to work properly on your server. You can now proceed by clicking on "Launch Installation".' );?></p>
            </div>
            <div class="col-sm-8 col-sm-offset-2 animated fadeIn text-center">
                <a class="btn btn-lg btn-info" href="<?php echo $this->instance->url->site_url(array('install'));?>"><i class="fa fa-rocket"></i> <?php _e( 'Launch installation' );?></a>
            </div>
        </div>  
      <?php echo output('notice');?>
    </form>
	 </div><!-- /.login-box-body -->
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