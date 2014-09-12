<header id="header" <?php
	if( current_user()->isConnected() ):
		echo 'style="margin-top:40px"';
	endif;
?>>
    <div id="top-bar">
        <div class="container">
            <div class="row">
            	<div class="col-sm-7 hidden-xs top-info">
					<?php get_items( 'header_datas' );?>
                </div>
                <div class="col-sm-5 top-info">
                	<?php get_items( 'social_feeds' );?>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO bar -->
    <div id="logo-bar" class="clearfix"> 
        <!-- Container -->
        <div class="container">
            <div class="row"> 
                <!-- Logo / Mobile Menu -->
                <div class="col-xs-12">
                    <div id="logo">
                        <h1><a class="brand" style="padding:10px;" href="<?php echo get_instance()->url->main_url();?>"><img style="height:35px" src="<?php echo get_meta('site_logo');?>" alt="logo"></a></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container / End --> 
    </div>
    <!--LOGO bar / End--> 
    
    <!-- Navigation
================================================== -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                </div>
                <div class="navbar-collapse collapse">
                	<?php theme_parse_menu(array(
						'parent'				=>	false,
						'base_ul_class'			=>	'nav navbar-nav',
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
            <!--/.row --> 
        </div>
        <!--/.container --> 
    </div>
</header>