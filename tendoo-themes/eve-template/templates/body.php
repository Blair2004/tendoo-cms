<body>
	<?php echo current_user("menu"); ?>
    
	<!--Start Header-->
    <?php echo get_core_vars( 'theme_header' );?>
	<!--End Header-->
	<?php echo get_core_vars( 'module_content' );?>   

	<?php echo get_core_vars( 'theme_footer' );?>
</body>
</html>