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
											<option value="FRE">French / Français</option>
											<!--<option value="ENG">English / Anglais</option>-->
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
