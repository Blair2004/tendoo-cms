<?php

		if(isset($this->partners_content))
		{
		?>
		<div class="fwidgets">
			<div class="container">
				<div class="row">
					
					<div class="col-lg-12" style="color:white">
						<h2><?php echo $this->partners_title;?></h2>
						<p><?php echo strip_tags($this->partners_content);?></p>
					</div>
					
				</div>
			</div>
		</div>
<?php
		}
