        <div id="main">
			<!-- social -->
			<?php $this->socialBar();?>
			<!-- ENDS social -->
			<!-- Content -->
			<div id="content">
				<!-- masthead -->
		        <div id="masthead">
					<span class="head"><?php echo $this->pageTitle;?></span><span class="subhead"><?php echo word_limiter($this->pageDescription,10);?></span>
					<ul class="breadcrumbs">
						<li><a href="index.html">home</a></li>
						<li>/ contact</li>
					</ul>
				</div>
	        	<!-- ENDS masthead -->
	        	
	        	
	        	
	        	<!-- page content -->
	        	<div id="page-content">
					<p><?php echo $this->contactContent;?></p>
					<?php $this->parseNotice();?>
					<!-- form -->
					<?php $this->parseForm($this->contactHeader['ACTION'],$this->contactHeader['ENCTYPE'],$this->contactHeader['METHOD']);?>
					<!-- ENDS form -->
						
	        		
	        	</div>
	        	<!-- ENDS page content -->
	        	
	        	
	        	<!-- sidebar -->
                <?php 
				if(count($this->contactAddressItems) > 0)
				{
				?>
	        	<aside id="sidebar">
	        		<div class="block">
		        		<h4><?php echo $this->contactTitle;?></h4>
		        		<p><?php echo $this->contactAddress;?></p>
		        		
		        		<ul class="address-block">
                        <?php
						foreach($this->contactAddressItems as $c)
						{
						?>
		        			<li class="<?php echo $c['TYPE'];?>"><?php echo $c['CONTENT'];?></li>
						<?php
						}
						?>
		        		</ul>
	        		</div>	        	
	        	</aside>
	        	<div class="clearfix"></div>
                <?php
				}
				?>
				<!-- ENDS sidebar -->
				
				
			
			</div>
			<!-- ENDS content -->
			
			<div class="clearfix"></div>
			<div class="shadow-main"></div>
			
			
		</div>
        <?php
	