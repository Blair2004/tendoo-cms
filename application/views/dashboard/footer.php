<?php
/**
 * 	File Name 	: footer.php
 *	Description :	hold dashboard footer section
 *	Since		:	1.4
**/
?>

<footer class="main-footer">
<div class="pull-right hidden-xs">
  <b><?php _e( 'Tendoo' );?></b> <?php echo get( 'core_version' );?>
</div>
<small><?php _e( 'Thanks you for using Tendoo CMS' );?> - <?php echo $this->benchmark->memory_usage();?></small>
</footer>
<?php echo $this->events->apply_filters( 'dashboard_footer' , '' );?>