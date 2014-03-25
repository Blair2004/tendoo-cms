<?php
		if(count($this->tabShowCase) > 0)
		{
		?>
<div class="fwidgets tabSpecial">
	<div class="container fwidgets">
		<div class="row">
			<div class="col-lg-12">
				<div class="bs-example bs-example-tabs">
					<h3 class="title_"><?php echo $this->tabShowCaseTitle;?></h3>
					<ul class="nav nav-tabs" id="myTab">
						<?php
						$i = 0;
						foreach($this->tabShowCase as $s)
						{
							if($i == 0)
							{
							?>
							<li class="active"><a href="#tab<?php echo $i;?>" data-toggle="tab"><span><?php echo $s['TITLE'];?></span></a></li>
							<?php
							}
							else
							{
							?>
							<li><a href="#tab<?php echo $i;?>" data-toggle="tab"><span><?php echo $s['TITLE'];?></span></a></li>
							<?php
							}
							$i++;
						}
						?>
					</ul>
					<div class="tab-content" id="myTabContent">
					<?php
					$i = 0;
					foreach($this->tabShowCase as $s)
					{
					?>
						<div id="tab<?php echo $i;?>" class="tab-pane fade active in">
							<br>
							<p><?php echo strip_tags($s['CONTENT']);?></p>
						</div>
					<?php
						$i++;
					}
					?>
					</div>
				</div>
				</div>
			</div>
		</div>		
	</div>
</div>
        <?php
		}
