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
		function getSubmenu($element,$obj)
		{
			if(is_array($element))
			{
				if(array_key_exists('PAGE_CHILDS',$element))
				{
					if(is_array($element['PAGE_CHILDS']))
					{
						?>
						<ul>
						<?php
						foreach($element['PAGE_CHILDS'] as $p)
						{
							?>
							<li><a href="<?php echo $obj->core->url->site_url(array($p['PAGE_CNAME']));?>"><?php echo ucwords($p['PAGE_NAMES']);?></a>
								<?php getSubmenu($p,$obj);?>
							</li>
							<?php
						}
						?>
					</ul>
					<?php
                    }
				}
			}
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
                    <?php getSubmenu($c,$this);?>
                    </li>
			<?php
			}
			else
			{
				?>
                <li><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?></a>
                    <?php getSubmenu($c,$this);?>
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
				<a title="<?php echo $options[0]['SITE_NAME'];?>" href="<?php echo $this->core->url->base_url();?>" id="logo"><img src="http://localhost/templates/modus-files/HTML/img/logo.png" alt="<?php echo $options[0]['SITE_NAME'];?>"></a>
				
				<nav>
					<ul id="nav" class="sf-menu">
		<?php 
		foreach($controllers as $c)
		{
			if($c['PAGE_CNAME'] == $this->core->url->controller())
			{
				
			?>
            <li class="current-menu-item"><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a>
            <?php getSubmenu($c,$this);?>
            </li>
			<?php
			}
			else
			{
			?>
            <li><a href="<?php echo $this->core->url->site_url(array($c['PAGE_CNAME']));?>"><?php echo ucwords($c['PAGE_NAMES']);?><span class="subheader"><?php echo $c['PAGE_TITLE'];?></span></a>
            <?php getSubmenu($c,$this);?>
            </li>
			<?php
			}
		}
		?>
					</ul>
				</nav>
				
				<div class="clearfix"></div>
				
			</div>
		</header>
