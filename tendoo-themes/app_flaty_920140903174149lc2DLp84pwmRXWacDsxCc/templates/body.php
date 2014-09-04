<body>
<?php echo current_user("menu"); ?>
<?php echo get_core_vars( 'theme_header' );?>
<div <?php echo current_user('top_margin');?>>
	<?php echo get_core_vars( 'module_content' );?>        
    <?php echo get_core_vars( 'theme_footer' );?>
</div>
</body>
</html>