<?php
$theme_style	=	get_items( 'theme_color_and_style' );
?>
<body class="<?php echo riake( 'bg_image' , $theme_style );?>">
	<?php echo current_user("menu"); ?>
    
	<!--Start Header-->
    <?php echo get_core_vars( 'theme_header' );?>
	<!--End Header-->
	<?php echo get_core_vars( 'module_content' );?>   

	<?php echo get_core_vars( 'theme_footer' );?>
</body>
</html>