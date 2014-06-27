<div id="content">


<!-- 960 Container -->
<div class="container floated">

	<div class="sixteen floated page-title">

		<h2><?php echo get_page('title');?> | <span><?php if(strlen($this->pageDescription) > 0) : echo word_limiter($this->pageDescription,20);endif;?></span></h2>

		<!--<nav id="breadcrumbs">
			<ul>
				<li>You are here:</li>
				<li><a href="index-2.html">Home</a></li>
				<li>Contact</li>
			</ul>
		</nav>-->

	</div>

</div>
<!-- 960 Container / End -->


<!-- 960 Container -->
<div class="container floated">

	<!-- Sidebar -->
	<div class="four floated sidebar left">
		<aside class="sidebar padding-reset">
			<div class="widget">
            	<?php 
				if(count($this->contactAddressItems) > 0)
				{
				?>
	        	<aside id="categories-2" class="widget widget_categories">
                	<h4><?php echo $this->contactTitle;?></h4>
					<p><?php echo $this->contactAddress;?></p>
					<ul class="contact-informations">
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

				<!--<ul class="contact-informations second">
					<li><i class="halflings headphones"></i> <p>+48 880 440 110</p></li>
					<li><i class="halflings envelope"></i> <p>support@example.com</p></li>
					<li><i class="halflings globe"></i> <p>www.example.com</p></li>
				</ul>-->

			</div>

		</aside>
	</div>
	<!-- Sidebar / End -->

	<!-- Page Content -->
	<div class="eleven floated right">
		<section class="page-content">
			<?php echo $this->contactContent;?>
			<br>
			<h3 class="margin">Formulaire</h3>
				<!-- Contact Form -->
				<section id="contact">

					<!-- Success Message -->
					<?php $this->parseNotice();?>

					<!-- Form -->
					<?php $this->parseForm($this->contactHeader['ACTION'],$this->contactHeader['ENCTYPE'],$this->contactHeader['METHOD']);?>
                    <div class="clearfix">

				</section>
				<!-- Contact Form / End -->


		</section>
	</div>
	<!-- Page Content / End -->


</div>
<!-- 960 Container / End -->

</div>