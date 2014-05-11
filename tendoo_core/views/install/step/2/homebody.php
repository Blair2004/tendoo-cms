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
								<li data-target="#step1"><span class="badge badge-info">1</span>Accueil</li> 
								<li data-target="#step2" class="active"><span class="badge">2</span>Base de donn&eacute;es</li> 
								<li data-target="#step3"><span class="badge">3</span>Options</li> 
								<li data-target="#step4"><span class="badge">4</span>Fin de l'installation</li> 
							</ul>
							<div class="actions"> 
								<a href="<?php echo $this->core->url->main_url();?>"><img style="height:32px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->tendoo->getVersion();?></a>
							</div> 
						</div> 
						<div class="step-content"> 
							<div class="step-pane active" id="step2">
								<div class="row">
									<div class="col-lg-7">
										<div class="col-lg-13">
											<h4><i class="fa fa-exchange"></i> Connexion &agrave; la base de donn&eacute;es</h4>
											<div>
												Nous allons procéder à la création de votre site web. vous devez spécifier toutes les informations d'accès à la base de données. <br><br>La base de donn&eacute;es que vous devez fournir doit exister et l'utilisateur doit avoir les privil&egrave;ges necessaire &agrave; la cr&eacute;ation des tables. Dans le cas contraire, le site ne pourra pas &ecirc;tre installé. <br><br>Verifiez que le nom de la base de donn&eacute;es, de l'h&ocirc;te et le mot de passe correspondent &agrave; ceux que vous sp&eacute;cifiez ci-apr&egrave;s.
												<br>Si des erreurs persistent, vous pouvez toujours vous connecter à la communauté Tendoo pour signaler cette erreur.
											</div>										
										</div>
									<?php 
									$form_response	=	validation_errors('<li>', '</li>');
									ob_start();
									$this->core->notice->parse_notice();
									$query_error	=	strip_tags(ob_get_contents());
									ob_end_clean();
									if($form_response)
									{
										?>
									<div class="col-lg-13">
										<div class="panel-body">
											<?php echo tendoo_error('<strong>Erreur sur le formulaire</strong><br><br>'.$form_response);?>
										</div>
									</div>
										<?php
									}
									else if($query_error)
									{
										?>
									<div class="col-lg-13">
										<div class="panel-body">
											<?php echo tendoo_error('<strong>Erreur est survenue</strong><br><br>'.$query_error);?>
										</div>
									</div>
										<?php
									}
									?>
									</div>
									<div class="col-lg-5">
										<h4><i class="fa fa-bullseye"></i> Information de connexion</h3>
										<div class="form-group">
											<label class="host_name">Identifiant de l'h&ocirc;te</label>
											<input name="host_name" type="text" placeholder="exemple : localhost" class="form-control">
										</div>
										<div class="form-group">
											<label class="user_name">Nom de l'utilisateur</label>
											<input name="user_name" type="text" placeholder="Nom de l'utilisateur" class="form-control">
										</div>
										<div class="form-group">
											<label class="host_password">Mot de passe de l'utilisateur</label>
											<input name="host_password" type="text" placeholder="Entrez le mot de passe" class="form-control">
										</div>
										<div class="form-group">
											<label class="db_name">Nom de la base de donn&eacute;es</label>
											<input name="db_name" type="text" placeholder="Base de donn&eacute;e" class="form-control">
										</div>
										<div class="form-group">
											<label class="extension_name">Extension des tables</label>
											<input name="extension_name" type="text" placeholder="Exemple : Tendoo_" class="form-control">
										</div>
										<div class="form-group">
											<select class="input-sm form-control input-s-sm inline" name="db_type" style="color:#333;background:#FFF;">
												<option value="" style="color:#333">Type de la base de donn&eacute;es</option>
												<option value="mysql" style="color:#333">Mysql</option>
												<option value="mysqli" style="color:#333">Mysql Lite</option>
												<option value="sqlite" style="color:#333">Sql Lite</option>
											</select>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="line line-dashed"></div>
										<button style="float:right" type="submit" class="btn btn-info">Continuer</button>
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