<body cz-shortcut-listen="true" id="backgroundLogin">
	<section class="thinwrapper stretch">
		<section class="hbox stretch">
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
								<li data-target="#step1"><span class="badge">1</span><?php echo translate('home');?></li> 
								<li data-target="#step2" class="active"><span class="badge badge-info">2</span><?php echo translate('database');?></li> 
								<li data-target="#step3"><span class="badge">3</span><?php echo translate('options');?></li> 
								<li data-target="#step4"><span class="badge">4</span><?php echo translate('install_end');?></li> 
							</ul>
							<div class="actions"> 
								<a href="<?php echo $this->instance->url->main_url();?>"><img style="height:32px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->instance->url->img_url("logo_4.png");?>"> <?php echo get('core_version');?></a>
							</div> 
						</div> 
						<div class="step-content"> 
							<div class="step-pane active" id="step2">
								<div class="row">
									<div class="col-lg-7">
										<div class="col-lg-13">
											<h4><i class="fa fa-exchange"></i><?php echo translate('connecting_database');?></h4>
											<div>
												<?php echo translate('database_notice');?>
											</div>										
										</div>
									<?php 
									$form_response	=	validation_errors('<li>', '</li>');
									ob_start();
									output('notice');
									$query_error	=	strip_tags(ob_get_contents());
									ob_end_clean();
									if($form_response)
									{
										?>
									<div class="col-lg-13">
										<div class="panel-body">
											<?php echo tendoo_error('<strong>'.translate('error_on_form').'</strong><br><br>'.$form_response);?>
										</div>
									</div>
										<?php
									}
									else if($query_error)
									{
										?>
									<div class="col-lg-13">
										<div class="panel-body">
											<?php echo tendoo_error('<strong>'.translate('error_occurred').'</strong><br><br>'.$query_error);?>
										</div>
									</div>
										<?php
									}
									?>
									</div>
									<div class="col-lg-5">
										<h4><i class="fa fa-bullseye"></i><?php echo translate('database_information_form_title');?></h3>
										<div class="form-group">
											<label class="host_name"><?php echo translate('host_name');?></label>
											<input name="host_name" value="localhost" type="text" placeholder="exemple : localhost" class="form-control">
										</div>
										<div class="form-group">
											<label class="user_name"><?php echo translate('user_name');?></label>
											<input name="user_name" value="root" type="text" placeholder="Nom de l'utilisateur" class="form-control">
										</div>
										<div class="form-group">
											<label class="host_password"><?php echo translate('user_password');?></label>
											<input name="host_password" type="text" placeholder="Entrez le mot de passe" class="form-control">
										</div>
										<div class="form-group">
											<label class="db_name"><?php echo translate('database_name');?></label>
											<input name="db_name" value="tendoo" type="text" placeholder="Base de donn&eacute;e" class="form-control">
										</div>
										<div class="form-group">
											<label class="extension_name"><?php echo translate('database_extension');?></label>
											<input name="extension_name" type="text" placeholder="Exemple : lumax_" class="form-control" value="lumax_">
										</div>
										<div class="form-group">
											<select class="input-sm form-control input-s-sm inline" name="db_type" style="color:#333;background:#FFF;">
												<option value="" style="color:#333"><?php echo translate('database_type');?></option>
												<option value="mysql" selected style="color:#333">Mysql</option>
												<option value="mysqli" style="color:#333">Mysql Lite</option>
												<option value="sqlite" style="color:#333">Sql Lite</option>
											</select>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="line line-dashed"></div>
										<button style="float:right" type="submit" class="btn btn-info"><?php echo translate('continue');?></button>
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