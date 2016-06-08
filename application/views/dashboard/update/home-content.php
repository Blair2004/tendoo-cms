<?php
$result    =    $this->Update_Model->check();

if ($result) {
    // var_dump( $result );
    ?>
   <h4><?php echo sprintf(__('Tendoo CMS : %s is available'), riake('title', $result[0]));
    ?></h4>
   <p><?php echo riake('content', $result[0]);
    ?></p>
   <span><a class="btn btn-primary" href="<?php echo site_url(array( 'dashboard', 'update', 'core', riake('id', $result[0]) ));
    ?>"><?php _e('Click Here to Update');
    ?></a></span>
   <?php

} else {
    ?>
	<h4><?php _e("You're up to date");
    ?></h4>
   <?php

}
