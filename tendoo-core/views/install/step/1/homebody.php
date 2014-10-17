<body cz-shortcut-listen="true" id="backgroundLogin">
	<section class="thinwrapper stretch">
		<section class="bigwrapper">
			<footer id="footer"> 
				<div class="text-center padder clearfix"> 
					<p> 
						<small><a href="https://github.com/Blair2004/tendoo-cms"><?php echo get('core_version');?></a> © 2014</small> 
					</p>
				</div>
			</footer>
            <img src="<?php echo img_url($this->instance->tendoo->getBackgroundImage());?>" style="width:100%;float:left">
			<section id="content" class="wrapper-md animated fadeInDown scrollable"> 
				<section class="wrapper">
					<form method="post">
					<section class="panel"> 
						<div class="wizard clearfix"> 
							<ul class="steps"> 
								<li data-target="#step1" class="active"><span class="badge badge-info">1</span><?php echo translate('home');?></li> 
								<li data-target="#step2"><span class="badge">2</span><?php echo translate('database');?></li> 
								<li data-target="#step3"><span class="badge">3</span><?php echo translate('options');?></li> 
								<li data-target="#step4"><span class="badge">4</span><?php echo translate('install_end');?></li> 
							</ul>
							<div class="actions"> 
								<a href="<?php echo $this->instance->url->main_url();?>"><img style="height:32px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->instance->url->img_url("logo_4.png");?>"> <?php echo get('core_version');?></a>
							</div> 
						</div> 
						<div class="step-content"> 
							<div class="step-pane active" id="step1">
								<div class="row">
									<div class="col-lg-4">
										<h4><i class="fa fa-group"></i><?php echo translate('tendoo_community');?></h4>
										<div>
											<?php echo translate('install_step1_tendoo_community');?>
										</div>
										
									</div>
									<div class="col-lg-4">
										<h4><i class="fa fa-mobile-phone"></i> <?php echo translate('install_step1_tendoo_device_title');?></h4>
										<div>
											<?php echo translate('install_step1_tendoo_device_description');?>
										</div>
									</div>
									<div class="col-lg-4">
										<?php echo translate('T01');?>
									</div>
									<div class="col-lg-12">
										<hr class="line line-dashed">
										<input type="submit" class="btn btn-info" value="Continuer" style="float:right;" name="submit">
									</div>
								</div>
								
							</div> 						
						</div> 
					</section>
					</form>
				</section>
				</section>

			<!-- footer -->
		</section>
	</section>
</body>
</html>
