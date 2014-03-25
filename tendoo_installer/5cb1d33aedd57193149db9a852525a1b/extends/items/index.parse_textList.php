<?php
if(count($this->listText) > 0)
		{
		?>
<div class="container">
	<div class="panel-group" id="accordion">
		<br>
		<h3 class="title_" style="color:rgb(237, 86, 75)"><?php echo $this->textListTitle;?></h3>
		<div class="row">
		<?php
		$i = 0;
				foreach($this->listText as $t)
				{

	?>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse<?php echo $i;?>">
							<?php echo $t['TITLE'];?>
						</a>
					</h4>
				</div>
				<div id="collapse<?php echo $i;?>" class="panel-collapse collapse" style="height:auto;">
					<div class="panel-body">
						<a href="<?php echo $t['LINK'];?>" class="heading"><?php echo $t['TITLE'];?></a>
						<?php echo word_limiter($t['CONTENT'],200);?>
					</div>
				</div>
			</div>
		</div>
			<?php
			$i++;
				}
				?>
		</div>
	</div>
</div>
		
		
		
		
		
		
		
		
		
		
		
		
<h1 class="home-block-heading"></h1>
        <ul class="text-posts">
        </ul>
            <?php
		}