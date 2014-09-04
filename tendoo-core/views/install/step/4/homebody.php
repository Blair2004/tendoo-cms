<body cz-shortcut-listen="true" id="backgroundLogin" >
	<section class="hbox stretch">
		<section class="vbox">
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
					
					<section class="panel"> 
						<div class="wizard clearfix"> 
							<ul class="steps"> 
								<li data-target="#step1"><span class="badge">1</span>Accueil</li> 
								<li data-target="#step2"><span class="badge">2</span>Base de donn&eacute;es</li> 
								<li data-target="#step3"><span class="badge">3</span>Options</li> 
								<li data-target="#step4" class="active"><span class="badge badge-info">4</span>Fin de l'installation</li> 
							</ul>
							<div class="actions"> 
								<a href="<?php echo $this->instance->url->main_url();?>"><img style="height:32px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->instance->url->img_url("logo_4.png");?>"> <?php echo get('core_version');?></a>
							</div> 
						</div> 
						<div class="step-content"> 
							<div class="step-pane active" id="step4">
								<div class="row">
									<div class="col-lg-6 col-sm-offset-3">
										<h4><i class="fa fa-thumbs-up-alt"></i> Installation termin&eacute;e</h4>
										<p>En d&eacute;cidant de continuer, il ne sera plus possible de d'acc&eacute;der &agrave; cette page d'installation, par cons&eacute;quent de modifier les informations peronnelles de votre site web. En cas d'irr&eacute;gularité dans votre site web, vous ne pourrez faire des modifications qu'&agrave; partir de la <cite><strong>page d'administration</strong></cite>. En ce qui concerne les informations de connexion &agrave; la base de donn&eacute;e, compte tenu de l'importance de ces informations, leurs modifications est impossible. Seul la re-installation de Tendoo corrigera le probl&egrave;me.</p>
										<div class="list-group m-b-sm bg-white m-b-lg">
											<form method="post">
												<button name="admin_access" style="width:100%" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-home"></i> Espace administration </button> 
												<button name="web_access" style="width:100%" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-home"></i> Index du site </button> 
											</form>
										</div>
									</div>
								</div>
							</div> 						
						</div> 
					</section>
				</section>
				</section>

			<!-- footer -->
		</section>
	</section>
</body>
</html>