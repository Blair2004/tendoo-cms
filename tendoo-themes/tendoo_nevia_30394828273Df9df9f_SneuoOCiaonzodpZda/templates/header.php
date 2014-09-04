<?php
$options	=	get_instance()->options->get();
?>
<div id="top-line" <?php echo current_user('top_margin');?>></div>
<div class="container">
	<!-- Header -->
	<header id="header">
		<!-- Logo -->
		<div class="ten columns">
			<div id="logo">
				<h1><a href="index-2.html"><img src="<?php echo $options[0]['SITE_LOGO'];?>" alt="<?php echo $options[0]['SITE_NAME'];?>"></a></h1>
				<div class="clearfix"></div>
			</div>
		</div>

		<!-- Social / Contact -->
		<div class="six columns">

			<!-- Social Icons -->
			<ul class="social-icons">
				<li class="twitter"><a href="#">Twitter</a></li>
				<li class="facebook"><a href="#">Facebook</a></li>
				<li class="dribbble"><a href="#">Dribbble</a></li>
				<li class="linkedin"><a href="#">LinkedIn</a></li>
				<li class="rss"><a href="#">RSS</a></li>
			</ul>

			<div class="clearfix"></div>

			<!-- Contact Details -->
			<!--<div class="contact-details">Contact Phone: </div>-->

			<div class="clearfix"></div>

			<!-- Search -->
			<!--<nav class="top-search">
				<form action="http://vasterad.com/themes/nevia/404-page.html" method="get">
					<button class="search-btn"></button>
					<input class="search-field" onblur="if(this.value=='')this.value='Search';" onfocus="if(this.value=='Search')this.value='';" value="Search" type="text">
				</form>
			</nav>-->

		</div>
	</header>
	<!-- Header / End -->

	<div class="clearfix"></div>

</div>
<!-- ------------- -->
<nav id="navigation" class="style-1">
    <div class="left-corner"></div>
    <div class="right-corner"></div>
     <?php theme_parse_menu(array(
		'base_ul_class'			=>	'menu',
		'base_ul_id'			=>	'responsive',
		'active_class'			=>	'active',
		'parent_class'			=>	'menu',
		'parent_id'				=>	'responsive',
		'menu_limitation'		=>	20
	))?>
</nav>
<div class="clearfix"></div>