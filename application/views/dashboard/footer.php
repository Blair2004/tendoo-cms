<?php
/**
 * 	File Name 	: footer.php
 *	Description :	hold dashboard footer section
 *	Since		:	1.4
**/
?>

<footer class="main-footer">
<div class="pull-right hidden-xs">
  <b><?php _e( 'Tendoo' );?></b> <?php echo get( 'str_core' );?>
</div>
<?php echo $this->events->apply_filters( 'dashboard_footer_text', '<small>' . sprintf( __( 'Thank you for using Tendoo CMS &mdash; %s in %s seconds' ), $this->benchmark->memory_usage(), '{elapsed_time}' ) . '</small>' );?>
</footer>
<?php echo $this->events->do_action( 'dashboard_footer' );?>