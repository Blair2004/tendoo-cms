<?php

		?>
        <!-- MAIN -->
		<div id="main">
				
			<!-- social -->
			<?php $this->socialBar();?>
			<!-- ENDS social -->
			
			
			
			<!-- Content -->
			<div id="content">
			
				<!-- masthead -->
		        <div id="masthead">
					<span class="head"><?php echo $this->pageTitle;?></span><span class="subhead"><?php if(strlen($this->pageDescription) > 0) : echo word_limiter($this->pageDescription,20);endif;?></span>
					<ul class="breadcrumbs">
						<li><a href="index.html">home</a></li>
						<li>/ blog</li>
					</ul>
				</div>
	        	<!-- ENDS masthead -->
	        	
	        	
	        	
	        	<!-- posts list -->
                <?php $this->parseProductView();?>
                <?php $this->parseSingleProductView();?>
                <?php $this->parseCartList();?>
				<?php $this->parseSingleBlogPost();?>
	        	<?php $this->parseBlogPost();?>
	        	<!-- ENDS posts list -->
	        	
	        	
	        	<!-- sidebar -->
	        	<?php echo $this->parseWidgets();?>
				<!-- ENDS sidebar -->
				
				
				<!-- pager -->
        		<?php $this->pagination();?>
				<div class="clearfix"></div>
	        	<!-- ENDS pager -->
			
			</div>
			<!-- ENDS content -->
			
			<div class="clearfix"></div>
			<div class="shadow-main"></div>
			
			
		</div>
		<!-- ENDS MAIN -->
        <?php
	