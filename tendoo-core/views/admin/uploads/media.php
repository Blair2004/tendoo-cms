<?php
$this->gui->config( 'skip-header' ,	true );

$this->gui->cols_width( 1 , 4 );

$this->gui->set_meta( array(
	'namespace'		=>		'media_library',
	'type'			=>		'unwrapped'
) )->push_to( 1 );

ob_start();
?>
<script>
$( document ).ready(function(e) {
    var contentH	=	$( 'body .wrapper .right-side' ).height();
	$( '#mediaiframe' ).height( contentH );
});
</script>
<?php

$script	=	ob_get_clean();

$this->gui->set_item( array(
	'type'			=>		'dom',
	'value'			=>		'<iframe id="mediaiframe" style="width:100%;border:solid 0px;" src="' . get_instance()->url->site_url( array( 'admin' , 'upload' ) ) . '"></iframe>' . $script
) )->push_to( 'media_library' );

$this->gui->get();