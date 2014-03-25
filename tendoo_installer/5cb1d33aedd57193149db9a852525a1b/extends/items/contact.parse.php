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
				<!-- page content -->
	        	<div class="col-sm-6">
					<p><?php echo $this->contactContent;?></p>
					<?php $this->parseNotice();?>
					<!-- form -->
					<?php $this->parseForm($this->contactHeader['ACTION'],$this->contactHeader['ENCTYPE'],$this->contactHeader['METHOD']);?>
					<!-- ENDS form -->
	        	</div>
	        	<!-- ENDS page content -->
			</div><!-- #primary -->
			<div id="secondary" class="widget-area col-sm-4" role="complementary">
				<?php 
				if(count($this->contactAddressItems) > 0)
				{
				?>
	        	<aside id="categories-2" class="widget widget_categories">
					<h1 class="widget-title"><?php echo $this->contactTitle;?></h1>
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
	        	</aside>
                <?php
				}
				?>
				<!-- End Added -->
				<?php echo $this->parseRightWidgets();?>					
			</div><!-- #secondary -->
		</div>
	</div>
</div>