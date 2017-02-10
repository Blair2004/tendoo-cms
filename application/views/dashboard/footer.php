<?php
/**
 * 	File Name 	: footer.php
 *	Description :	hold dashboard footer section
 *	Since		:	1.4
**/
?>

<footer class="main-footer">
<div class="pull-right hidden-xs">
  <?php echo $this->events->apply_filters( 'dashboard_footer_right', sprintf( __( 'You\'re using <b>%s</b> %s' ), get( 'app_name' ), get('str_core') ) );?>
</div>
<?php echo $this->events->apply_filters('dashboard_footer_text', '<small>' . sprintf(__('Thank you for using Tendoo CMS &mdash; %s in %s seconds'), $this->benchmark->memory_usage(), '{elapsed_time}') . '</small>');?>
</footer>
<?php $this->events->do_action( 'dashboard_footer' );?>
