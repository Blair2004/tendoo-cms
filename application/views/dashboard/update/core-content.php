<?php
$result    =    $this->Update_Model->get($release);

if ($result === 'unknow-release') {
    ?>
   <h4><?php echo sprintf(__('Unknow Release : %s'), $release);
    ?></h4>
   <p><?php _e('Update has been aborded...!!!');
    ?></p>
   <?php

} elseif ($result === 'old-release') {
    ?>
   <h4><?php echo sprintf(__('Old Release : %s'), $release);
    ?></h4>
   <p><?php _e('Update has been aborded...!!!');
    ?></p>
   <?php

} else {
    ?>
   <script>
	$(document).ready( function(){
	function stage( int ){
		if( int == 1 ){
			$.ajax( '<?php echo site_url(array( 'dashboard', 'update', 'download', $result ));
    ?>',{
				beforeSend: function(){
					$('#update').append( '<div><?php echo _e('Downloading Zip file...');
    ?></div>' );
				},
				success : function( data ){
					if( typeof data.code != 'undefined' ){
						if( data.code != 'error-occured' ){
							stage(2);
						} else {
							$('#update').append( '<div><?php echo _e('An error occured during download...');
    ?></div>' );
						}
					}
				},
				dataType : 'json'
			});
		} else if( int == 2 ){
			$.ajax( '<?php echo site_url(array( 'dashboard', 'update', 'extract' ));
    ?>',{
				beforeSend: function(){
					$('#update').append( '<div><?php echo _e('Extracting the new release...');
    ?></div>' );
				},
				success: function( data ){
					if( typeof data.code != 'undefined' ){
						if( data.code != 'error-occured' ){
							stage(3);
						} else {
							$('#update').append( '<div><?php echo _e('An error occured during extraction...');
    ?></div>' );
						}
					}
				},
				dataType : 'json'
			});
		} else if( int == 3 ){
			$.ajax( '<?php echo site_url(array( 'dashboard', 'update', 'install' ));
    ?>',{
				beforeSend: function(){
					$('#update').append( '<div><?php echo _e('Installing the new release...');
    ?></div>' );
				},
				success: function( data ){
					if( typeof data.code != 'undefined' ){
						if( data.code != 'error-occured' ){
							document.location = '<?php echo site_url(array( 'dashboard', 'about' ));
    ?>';
						} else {
							$('#update').append( '<div><?php echo _e('An error occured during extraction...');
    ?></div>' );
						}
					}
				},
				dataType : 'json'
			});
		}
	}
	stage(1);
	});
	</script>
   <p id="update"></p>
   <?php

}
