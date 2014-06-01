<body cz-shortcut-listen="true" id="backgroundLogin">
	<section class="hbox stretch">
		<section class="vbox">
			<footer id="footer"> 
				<div class="text-center padder clearfix"> 
					<p> 
						<small><a href="https://github.com/Blair2004/tendoo-cms"><?php echo $this->core->tendoo->getVersion();?></a> © 2014</small> 
					</p>
				</div>
			</footer>
			<section id="content" class="wrapper-md animated fadeInDown scrollable"> 
				<section class="wrapper">
					<form method="post">
					<section class="panel"> 
						<div class="wizard clearfix"> 
							<ul class="steps"> 
								<li data-target="#step1" class="active"><span class="badge badge-info">1</span><?php echo gt('home');?></li> 
								<li data-target="#step2"><span class="badge">2</span><?php echo gt('database');?></li> 
								<li data-target="#step3"><span class="badge">3</span><?php echo gt('options');?></li> 
								<li data-target="#step4"><span class="badge">4</span><?php echo gt('install_end');?></li> 
							</ul>
							<div class="actions"> 
								<a href="<?php echo $this->core->url->main_url();?>"><img style="height:32px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->tendoo->getVersion();?></a>
							</div> 
						</div> 
						<div class="step-content"> 
							<div class="step-pane active" id="step1">
								<div class="row">
									<div class="col-lg-4">
										<h4><i class="fa fa-group"></i> Tendoo Community</h4>
										<div>
											<?php gt('install/step1/homebody/tendoo_community');?>
										</div>
										
									</div>
									<div class="col-lg-4">
										<h4><i class="fa fa-mobile-phone"></i> <?php gt('install/step1/homebody/tendoo_device_title');?></h4>
										<div>
											<?php gt('install/step1/homebody/tendoo_device_description');?>
										</div>
									</div>
									<div class="col-lg-4">
										<h4><i class="fa fa-list"></i> D&eacute;tails de l'installation</h4>
										<div>
											<span>Cette installation se fera en 3 étapes, vous avez donc au moins 4 minutes pour créer votre site web.</span> <br>
											<br>
											<div>
												<ul>
													<li style="font-size:12px">Premi&egrave;re &eacute;tape : Information sur la base de donn&eacute;e</li>
													<li style="font-size:12px">Deuxi&egrave;me &eacute;tape : Nom du site</li>
													<li style="font-size:12px">Troisi&egrave;me &eacute;tape : Fin de l'installation</li>
												</ul>
											</div>
											<div style="font-size:12px;"> <span></span> </div>
										</div>Connectez vous &agrave; l'espace administrateur pour modifier les informations de votre site, cr&eacute;er des administrateurs, installer les th&egrave;mes et modules.
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
<style type="text/css">
    #backgroundLogin{
        background:url(<?php echo img_url($this->core->tendoo->getBackgroundImage());?>) ;
        background-position:0 0;
        background-repeat: no-repeat;
    }
</style>
</html>
