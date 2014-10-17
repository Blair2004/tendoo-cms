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
                <a class="nav-brand animated fadeInTop" href="<?php echo $this->instance->url->main_url();?>"><h3><img style="max-height:80px;margin-top:-3px;" src="<?php echo $this->instance->url->img_url("logo_4.png");?>"> </h3></a>
				<section class="wrapper">
					<div class="row m-n"> 
						<div class="col-md-4 col-md-offset-4 m-t-lg"> 
							<section class="panel"> 
								<header class="panel-heading text-center"> Language selection / Selection de la langue </header> 
								<form method="POST" class="panel-body"> 
									<?php echo tendoo_info('Veuillez choissir la langue de votre installation.');?>
									<?php echo tendoo_info('Please choose your install language.');?>
									<div class="form-group"> 
										<label class="control-label">Choose your language / Choissisez votre langue</label> 
										<select name="lang" class="form-control">
											<option value="">Choose / Choisir</option>
											<option value="fr_FR">French / Français</option>
											<!-- <option value="en_US">English / Anglais</option>-->
										</select>
									</div> 
									<div class="line line-dashed"></div> 
									<button type="submit" class="btn btn-info">Save Changes / Enregistrer les modficiations</button> 
									<div class="line line-dashed"></div> 
								</form> 
							</section> 
						</div> 
					</div>
				</section>
			</section>

			<!-- footer -->
		</section>
	</section>
</body>
</html>
