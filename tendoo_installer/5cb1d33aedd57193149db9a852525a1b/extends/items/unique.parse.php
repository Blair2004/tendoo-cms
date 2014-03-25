<div id="content" class="site-content ">
	<div class="page-head">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h3><?php echo $this->pageTitle;?></h3>
					<p><?php if(strlen($this->pageDescription) > 0) : echo word_limiter($this->pageDescription,20);endif;?></p>
				</div>
				
			</div>
		</div>
	</div>
	<div class="container">	
		<div class="row">
			<div id="primary" class="content-area col-sm-8">
				<main id="main" class="site-main" role="main">
					<?php echo $this->uniqueContent;?>
				</main><!-- #main -->
			</div><!-- #primary -->
			<div id="secondary" class="widget-area col-sm-4" role="complementary">
				<?php echo $this->parseRightWidgets();?>					
			</div><!-- #secondary -->
		</div>
	</div>
</div>