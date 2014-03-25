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
<header <?php echo $margin;?> role="banner" class="site-header container" id="masthead">
	<div class="row">
	<div class="site-branding col-sm-4">
		<h1 class="site-title"><a rel="home" title="<?php echo $options[0]['SITE_NAME'];?>" href="<?php echo $this->core->url->base_url();?>"><?php echo $options[0]['SITE_NAME'];?></a></h1>
	</div>
	
	<div class="col-sm-8 mainmenu">
	<div class="mobilenavi"></div>
		<div class="topmenu" id="submenu">
			<ul class="sfmenu sf-js-enabled sf-shadow" id="topmenu">
			<?php 
		foreach($controllers as $c)
		{
			if($c['PAGE_CNAME'] == $this->core->url->controller())
			{
				if($c['PAGE_MODULES'] == '#LINK#')
				{				
			?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item"><a href="<?php echo $c['PAGE_LINK'];?>"><?php echo ucwords($c['PAGE_NAMES']);?></a>
            <?php $this->core->tendoo->getControllerSubmenu($c);?>
            </li>
			<?php
				}
				else
				{
			?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item"><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?></a>
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
            <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo $c['PAGE_LINK'];?>"><?php echo ucwords($c['PAGE_NAMES']);?></a>
            <?php $this->core->tendoo->getControllerSubmenu($c);?>
            </li>
			<?php
				}
				else
				{
			?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?></a>
            <?php $this->core->tendoo->getControllerSubmenu($c);?>
            </li>
			<?php	
				}
			}
		}
		?>
			</ul>
		</div>
	</div>
	</div> <!-- end row -->
</header>