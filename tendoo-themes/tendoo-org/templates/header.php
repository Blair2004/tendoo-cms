<div class="navbar navbar-inverse navbar-fixed-top" <?php echo current_user('top_offset');?>>
  <div class="navbar-inner">
    <div class="container">
    	  	    <a class="brand" style="padding:10px;" href="<?php echo get_instance()->url->main_url();?>"><img style="height:35px" src="<?php echo get_meta('site_logo');?>" alt="logo"></a>

      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <form class="navbar-search pull-right">
        <input type="text" class="search-query" placeholder="Search">
      </form> -->
      <div class="nav-collapse collapse">
        <?php theme_parse_menu(array(
			'parent'				=>	false,
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
    </div>
  </div>
</div>