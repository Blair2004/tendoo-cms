<div id="top-line" <?php echo current_user('margin');?>></div>
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
    <ul class="menu" id="responsive">
	  	<?php foreach($controllers as $c)	{ ?>
        	<?php if($c["PAGE_CNAME"] == $this->url->controller())	{ ?>
                <?php if($c["PAGE_MODULES"] == "#LINK#")	{ ?>
                <li class="active"><a href="<?php echo $c["PAGE_LINK"];?>" title="<?php echo $c["PAGE_TITLE"];?>"><?php echo ucwords($c["PAGE_NAMES"]);?></a><?php $this->tendoo->getControllerSubmenu($c);?></li>
                <?php } else { ?>
                <li class="active"><a href="<?php echo $this->url->site_url(array($c["PAGE_CNAME"]));?>" title="<?php echo $c["PAGE_TITLE"];?>"><?php echo ucwords($c["PAGE_NAMES"]);?></a><?php $this->tendoo->getControllerSubmenu($c);?></li>
                <?php } ?>
			<?php } else { ?>
            	<?php if($c["PAGE_MODULES"] == "#LINK#")	{ ?>
                <li class="active"><a href="<?php echo $c["PAGE_LINK"];?>" title="<?php echo $c["PAGE_TITLE"];?>"><?php echo ucwords($c["PAGE_NAMES"]);?></a><?php $this->tendoo->getControllerSubmenu($c);?></li>
                <?php } else { ?>
                <li class=""><a href="<?php echo $this->url->site_url(array($c["PAGE_CNAME"]));?>" title="<?php echo $c["PAGE_TITLE"];?>"><?php echo ucwords($c["PAGE_NAMES"]);?></a><?php $this->tendoo->getControllerSubmenu($c);?></li>
                <?php } ?>
            <?php } ?>                
        <?php } ?>
    </ul>
</nav>
<div class="clearfix"></div>