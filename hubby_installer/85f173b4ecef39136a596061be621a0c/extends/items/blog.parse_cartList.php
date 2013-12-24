<?php
if(count($this->cartListElements) > 0 )
{
	?>
	<div id="post-content">
	<?php
	if(is_array($this->cartListPanelButton) && count($this->cartListPanelButton) > 0)
	{
	?>
	<ul class="list-buttons">
		<?php
		foreach($this->cartListPanelButton as $p)
		{
			// red green blue
		?>
		<li><a href="<?php echo $p['LINK'];?>" class="link-button"><?php echo $p['TEXT'];?></a></li>
		<?php
		}
		?>
	</ul>
	<div class="clearfix"></div>
	<?php
	}
	foreach($this->cartListElements as $c)
	{
		?>
		<div class="toggle-trigger"><?php echo $c['TITLE'];?> - <?php echo $c['PRICE'];?> <?php echo $this->cartListDevise;?><span style="float:right"><a href="<?php echo $c['CANCEL_LINK'];?>">Retirer
		 le produit</a></span></div>
		<div class="toggle-container" style="display: none;min-height:120px;">
			
		<p><a href="<?php $c['LINK'];?>"><img src="<?php echo $c['THUMB'];?>" alt="<?php echo $c['TITLE'];?>" style="float:left;width:200px;display:inline-block;margin-right:10px;" /></a><?php echo $c['CONTENT'];?></p>
		</div>
		<?php
	}
	?>
	</div>
	<?php
}