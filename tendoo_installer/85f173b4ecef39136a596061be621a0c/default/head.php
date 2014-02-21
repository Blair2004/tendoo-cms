		<?php echo $this->core->users_global->getUserMenu();?>
		<!-- mobile-nav -->
        <?php
		//echo '<pre>';
		//echo print_r($controllers,TRUE);
		//echo '</pre>';
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
					<li class="current-menu-item"><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?></a>
                    <?php $this->core->tendoo->getControllerSubmenu($c);?>
                    </li>
			<?php
			}
			else
			{
				?>
                <li><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?></a>
                    <?php $this->core->tendoo->getControllerSubmenu($c);?>
                </li>
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
				<a title="<?php echo $options[0]['SITE_NAME'];?>" href="<?php echo $this->core->url->base_url();?>" id="logo"><img src="<?php echo $options[0]['SITE_LOGO'];?>" alt="<?php echo $options[0]['SITE_NAME'];?>"></a>
				
				<nav>
					<ul id="nav" class="sf-menu">
		<?php 
		foreach($controllers as $c)
		{
			if($c['PAGE_CNAME'] == $this->core->url->controller())
			{
				if($c['PAGE_MODULES'] == '#LINK#')
				{				
			?>
            <li class="current-menu-item"><a href="<?php echo $c['PAGE_LINK'];?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a>
            <?php $this->core->tendoo->getControllerSubmenu($c);?>
            </li>
			<?php
				}
				else
				{
			?>
            <li class="current-menu-item"><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a>
            <?php $this->core->tendoo->getControllerSubmenu($c);?>
            </li>
			<?php	
				}
			}
			else
			{
				if($c['PAGE_MODULES'] == '#LINK#')
				{				
			?>
            <li><a href="<?php echo $c['PAGE_LINK'];?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a>
            <?php $this->core->tendoo->getControllerSubmenu($c);?>
            </li>
			<?php
				}
				else
				{
			?>
            <li><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a>
            <?php $this->core->tendoo->getControllerSubmenu($c);?>
            </li>
			<?php	
				}
			}
		}
		?>
					</ul>
				</nav>
				
				<div class="clearfix"></div>
				
			</div>
		</header>
