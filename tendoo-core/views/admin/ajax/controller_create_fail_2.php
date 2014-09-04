	$('#controller_creation_error_contener').html('');
	
	tendoo.notice.alert('<?php echo addslashes(strip_tags(fetch_notice_output($result)));?>','warning');