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
										<h4><i class="icon-group"></i> Tendoo Community</h4>
										<div>
											Besoin d'aide et d'assitance ? connectez-vous &agrave; la communaut&eacute; et exposer vos probl&egrave;mes li&eacute;s &agrave; l'utilisation du CMS Tendoo.<br>
											T&eacute;l&eacute;charger des applications depuis le Store et augmentez consid&eacute;rablement le potentiel de Tendoo.
										</div>
										
									</div>
									<div class="col-lg-4">
										<h4><i class="icon-mobile-phone"></i> Tendoo pour appareil mobile</h4>
										<div>
											<span>Tendoo offre un espace d'administration qui est compatible avec la plus part des supports mobiles. L'interface intuitif vous permet de g&eacute;rer votre site web depuis un terminal mobile. Cet interface s'apadapte correctement aux dimensions de votre appareil, pour que le plaisir de naviguer sur votre appareil mobile soit identique &agrave; celui ressenti depuis un ordinateur.</span>
										</div>
									</div>
									<div class="col-lg-4">
										<h4><i class="icon-list"></i> D&eacute;tails de l'installation</h4>
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
</html>
