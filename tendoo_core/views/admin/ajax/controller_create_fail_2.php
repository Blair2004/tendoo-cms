	$('#controller_creation_error_contener').html('');
	
	$('#controller_creation_error_contener').append('<?php echo addslashes(notice($error));?>');