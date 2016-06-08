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
    <div class="register-logo"> <a href="<?php echo base_url();?>"><b><?php echo __( 'Tendoo CMS' );?></b> <?php echo get( 'str_core' );?></a> </div>
    <div class="login-box-body">
        <form method="post">
        <h3 class="page-header text-center"><?php echo __( 'Permission request' );?></h3>
        <?php 
			if( $scopes ) {
			
				if( is_array( $scopes ) ) {
					foreach( $scopes as $scope ) {
					?>
        <div class="info-box <?php echo @$scope[ 'color' ];?>"> <span class="info-box-icon"><i class="<?php echo @$scope[ 'icon' ];?>"></i></span>
            <div class="info-box-content"> 
            	<!--<h4 class="info-box-text"><?php echo @$scope[ 'label' ];?></h4>-->
                <span><?php echo @$scope[ 'description' ];?></span> 
			</div>
            <!-- /.info-box-content --> 
        </div>
        			<?php
					}
				} 
		} else {
			echo tendoo_error( __( 'One or two permission are not available' ) );
		}?>
        <hr>
        	<button type="submit" class="btn btn-success"><?php _e( 'Allow' );?></button>
            <button type="submit" class="btn btn-default"><?php _e( 'Refuse' );?></button>
            <?php $this->events->do_action( 'display_login_fields' );?>
        </form>
                <p class="login-box-msg">
            <?php 
			$this->events->do_action( 'displays_public_errors' );
			?>
        </p>
    </div>
    <!-- /.login-box-body --> 
</div>
</body>
</html>