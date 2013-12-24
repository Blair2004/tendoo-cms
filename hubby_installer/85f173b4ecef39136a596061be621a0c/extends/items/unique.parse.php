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
                <div id="post-content">
				<?php echo $this->uniqueContent;?>
                </div>
	        	<!-- ENDS posts list -->
	        	
	        	
	        	<!-- sidebar -->
	        	<?php $this->parseWidgets();?>
				<!-- ENDS sidebar -->			
			</div>
			<!-- ENDS content -->
			
			<div class="clearfix"></div>
			<div class="shadow-main"></div>
			
			
		</div>
		<!-- ENDS MAIN -->
        <?php
	