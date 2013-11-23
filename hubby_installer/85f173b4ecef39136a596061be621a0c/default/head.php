		<?php echo $this->core->users_global->getUserMenu();?>
		<!-- mobile-nav -->
        <?php
		if($this->core->users_global->isConnected())
		{
			$margin	=	'style="margin-top:30px"';
		}
		else
		{
			$margin	=	"";
		}
		?>
		<div id="mobile-nav-holder" <?php echo $margin;?>>
			<div class="wrapper">
				<ul id="mobile-nav">
                <?php 
		foreach($controllers as $c)
		{
			if($c['PAGE_CNAME'] == $this->core->url->controller())
			{
				
			?>
					<li class="current-menu-item"><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?></a></li>
			<?php
			}
			else
			{
				?>
                <li><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?></a></li>
                <?php
			}
		}
		?>
				</ul>
				<div id="nav-open"><a href="#">Menu</a></div>
			</div>
		</div>
		<!-- ENDS mobile-nav -->
			
		<header>
			<div class="wrapper">
				<a title="<?php echo $options[0]['SITE_NAME'];?>" href="<?php echo $this->core->url->base_url();?>" id="logo"><img src="http://localhost/templates/modus-files/HTML/img/logo.png" alt="<?php echo $options[0]['SITE_NAME'];?>"></a>
				
				<nav>
					<ul id="nav" class="sf-menu">
		<?php 
		foreach($controllers as $c)
		{
			if($c['PAGE_CNAME'] == $this->core->url->controller())
			{
				
			?>
            <li class="current-menu-item"><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a></li>
			<?php
			}
			else
			{
			?>
            <li><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a></li>
			<?php
			}
		}
		?>
					</ul>
				</nav>
				
				<div class="clearfix"></div>
				
			</div>
		</header>
