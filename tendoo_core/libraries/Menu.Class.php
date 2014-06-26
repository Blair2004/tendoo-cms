<?php
class Menu extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		__extends($this);
	}
	public function getControllerSubmenu($element,$ulclass="",$liclass="")
	{
		if(is_array($element))
		{
			if(array_key_exists('PAGE_CHILDS',$element))
			{
				if(is_array($element['PAGE_CHILDS']))
				{
					?>
	
	<ul class="<?php echo $ulclass;?>">
		<?php
					foreach($element['PAGE_CHILDS'] as $p)
					{
						if($p['PAGE_MODULES'] == '#LINK#')
						{
						?>
		<li class="<?php echo $liclass;?>"><a href="<?php echo $p['PAGE_LINK'];?>"><?php echo ucwords($p['PAGE_NAMES']);?></a>
			<?php $this->getControllerSubmenu($p);?>
		</li>
		<?php
						}
						else
						{
							?>
		<li class="<?php echo $liclass;?>"><a href="<?php echo $this->url->site_url(array($p['PAGE_CNAME']));?>"><?php echo ucwords($p['PAGE_NAMES']);?></a>
			<?php $this->getControllerSubmenu($p);?>
		</li>
		<?php
						}
					}
					?>
	</ul>
	<?php
				}
			}
		}
	}
}