<header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" role="banner" <?php echo current_user('top_offset');?>>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo get_instance()->url->main_url();?>"><img style="height:50px;" src="<?php echo get_meta('site_logo');?>" alt="logo"></a>
        </div>
        <?php theme_parse_menu(array(
			'parent'				=>	'div',
			'base_ul_class'			=>	'nav navbar-nav navbar-right',
			'active_class'			=>	'active',
			'parent_class'			=>	'collapse navbar-collapse',
			'li_has_child_class'	=>	'dropdown',
			'li_a_has_child_class'	=>	'dropdown-toggle',
			'li_a_has_child_attr'	=>	'data-toggle="dropdown"',
			'menu_limitation'		=>	20,
			'li_parents_class'		=> 	array('dropdown-menu')
			
		))?>
    </div>
</header>