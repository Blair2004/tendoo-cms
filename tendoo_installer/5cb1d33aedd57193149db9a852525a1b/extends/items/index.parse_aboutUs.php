<?php
if(isset($this->indexAboutUs))
		{
		?>
<div class="fwidgets">
	<div class="container">
		<div class="row">
			
			<div class="col-lg-12" style="color:white">
				<h2><?php echo $this->indexAboutUsTitle;?></h2>
				<p><?php echo ($this->indexAboutUs);?></p>
			</div>
			
		</div>
	</div>
</div>
		<?php
		}