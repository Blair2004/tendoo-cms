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
			<section id="content" class="wrapper-md animated fadeInDown scrollable"> 
				<section class="wrapper">
					
					<section class="panel"> 
						<div class="wizard clearfix"> 
							<ul class="steps"> 
								<li data-target="#step1"><span class="badge">1</span>Accueil</li> 
								<li data-target="#step2"><span class="badge">2</span>Base de donn&eacute;es</li> 
								<li data-target="#step3" class="active"><span class="badge badge-info">3</span>Options</li> 
								<li data-target="#step4"><span class="badge">4</span>Fin de l'installation</li> 
							</ul>
							<div class="actions"> 
								<a href="<?php echo $this->instance->url->main_url();?>"><img style="height:32px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->instance->url->img_url("logo_4.png");?>"> <?php echo get('core_version');?></a>
							</div> 
						</div> 
						<div class="step-content"> 
							<div class="step-pane active" id="step3">
								<div class="row">
									<div class="col-lg-4">
										<div class="col-lg-13">
											<h4><i class="fa fa-check-sign"></i> Connexion etablie</h4>
													<p>Tendoo peut maintenant se connecter à votre base de donnée. Maintenant vous devez indiquez certaines inforamtions concernant votre nouveau site web.</p>
											
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
										<section class="panel">
											<header class="panel-heading bg bg-danger text-center">Erreur sur le formulaire</header>
												<div class="panel-body">
													<?php echo $form_response;?>
												</div>
										</section>
									</div>
										<?php
									}
									else if($query_error)
									{
										?>
									<div class="col-lg-13">
										<section class="panel">
											<header class="panel-heading bg bg-danger text-center">Erreur sur le formulaire</header>
												<div class="panel-body">
													<?php echo $query_error;?>
												</div>
										</section>
									</div>
										<?php
									}
									?>
									</div>
									<div class="col-lg-4">
										<h4><i class="fa fa-tasks"></i> Information de votre site web</h4>
										<form id="siteNameForm" method="post" action="<?php echo $this->instance->url->site_url(array('install','etape',4));?>">
											<div class="form-group">
												<label class="host_name">Nom du site</label>
												<input name="site_name" id="site_name" type="text" placeholder="Nom de votre site" class="form-control">
											</div>
											<div class="line line-dashed"></div>
											<button type="submit" id="siteNameSubmiter" class="btn btn-info">Continuer</button>
										</form>
                                        <div class="line"></div>
                                        <div>
                                        	<div style="height:25px;">
                                                <p class="installText"></p>
                                            </div>
                                        	<div class="progress" style="visibility:hidden;">
                                              <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                                <span id="status_id">0</span>
                                              </div>
                                            </div>
                                        </div>
                                        <script>
    function triggerInstall()
    {												
		var installStatus		=	true;
		var defaultsApp			=	new Array();
			defaultsApp[1]		=	"tendoo_index_mod";
			defaultsApp[2]		=	"default_theme";
			defaultsApp[3]		=	"news";
			defaultsApp[4]		=	"file_manager";
			defaultsApp[5]		=	"widget_admin";
			defaultsApp[6]		=	"pageEditor";
			defaultsApp[7]		=	"contact_manager";
			defaultsApp[8]		=	"final_config";
		var defaultsAppText		=	new Array();
			defaultsAppText[1]	=	'Installation du module Index Manager...';
			defaultsAppText[2]	=	'Installation du thème par defaut...';
			defaultsAppText[3]	=	'Installation du module Blogster...';
			defaultsAppText[4]	=	'Installation du module Bibiothèque Multimédia...';
			defaultsAppText[5]	=	'Installation du module Gestionnaire de widgets...';
			defaultsAppText[6]	=	'Installation du module Page Editor...';
			defaultsAppText[7]	=	'Installation du module Tendoo Contact Manager...';
			defaultsAppText[8]	=	'Configuration du site...';
		var defaultsAppFinish	=	new Array();
			defaultsAppFinish[1]=	'<span style="color:green">Installation du module terminée</span>';
			defaultsAppFinish[2]=	'<span style="color:green">Installation du thème terminée</span>';
			defaultsAppFinish[3]=	'<span style="color:green">Installation du module Blogster terminée</span>';
			defaultsAppFinish[4]=	'<span style="color:green">Installation du "Bibiothèque Multimédia" terminée</span>';
			defaultsAppFinish[5]=	'<span style="color:green">Installation du Gestionnaire de widgets terminée</span>';
			defaultsAppFinish[6]=	'<span style="color:green">Installation du module Page Editor terminée</span>';
			defaultsAppFinish[7]=	'<span style="color:green">Instal... du module Tendoo Contact Manager terminée</span>';
			defaultsAppFinish[8]=	'<span style="color:green">Configuration Terminé !</span>';
		var iterator			=	1;
		var Interval			=	setInterval(function(){
			if(installStatus == true)
			{
				var curIterator	=	iterator
				var action		=	'';
				if(typeof defaultsApp[iterator] == 'undefined') // Lorsqu'il ny a plus aucune application a installer :D
				{
					clearInterval(Interval);
					pushInstallText("#luminax : \"Tendoo est prêt !!!\"",100,"success");
					setTimeout(function(){
						pushInstallText("#luminax : \"Profitez de votre nouveau site web Tendoo.\"",100,"success");
					},1000);
					setTimeout(function(){
						pushInstallText("#luminax : \"Redirection en cours...\"",100,"success");
					},3000);
					setTimeout(function(){
						$('#siteNameForm').submit();
					},5000);
				}
				else
				{
					switch(defaultsApp[iterator])
					{
						case "news"	:
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/news";
						break;
						case "default_theme"	:
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/default_theme";
						break;	
						case "tendoo_index_mod":
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/tendoo_index_mod";									
						break;
						case "file_manager":
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/file_manager";									
						break;
						case "widget_admin":
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/widget_admin";									
						break;
						case "pageEditor":
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/pageEditor";									
						break;
						case "contact_manager":
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/contact_manager";									
						break;
						case "final_config"	:
							action	=	"<?php echo $this->instance->url->site_url(array('install','installApp'));?>/final_config";									
						break;
					}
					$.ajax({
						beforeSend	:	function(){
							installStatus	=	false;
							pushInstallText(defaultsAppText[curIterator],(curIterator*10),"info");
						},
						success		:	function(data){
							installStatus	=	true;
							pushInstallText(defaultsAppFinish[curIterator],(curIterator*10)+9,"success");
						},
						url			:	action
					});
				}
				iterator++;
			}
		},500);
    }
	function pushInstallText(text,percent,color)
	{
		if(typeof color == "undefined")
		{
			complete 	=	"progress-bar-success";
		}
		else
		{
			complete	=	"progress-bar-"+color
		}
		$('.installText').fadeOut(100,function(){
			$(this).html(text);
			$(this).fadeIn(100);
		})
		$('.progress-bar').css("width",percent+"%");
		$('#status_id').html(percent);
		$('.progress-bar').removeClass('progress-bar-success');
		$('.progress-bar').removeClass('progress-bar-info');
		$('.progress-bar').removeClass('progress-bar-warning');
		$('.progress-bar').addClass(complete);
	}
	$(document).ready(function(){
		$('#siteNameSubmiter').bind('click',function(){
			var timer;
			var report;
			$.ajax({
				beforeSend	:	function()
				{
					$('.progress').css('visibility','visible')
					pushInstallText("Délivrance du processus #luminax...",1);
				},
				type		:	'POST',
				data		:	{	'site_name'		:	$('#site_name').val()},
				dataType	:	'html',
				success		:	function(data)
				{
					report	=	data;
					if(data == 'true')
					{
						pushInstallText("#luminax est libre...",10,"success");
						setTimeout(function(){
							triggerInstall();
						},300);
					}
					else if(data == 'nositename')
					{
						tendoo.notice.alert('Une erreur s\'est produite durant la configuration du site, vérifiez que le nom du site envoyé ne soit pas vide, assurez-vous que les données de connexion soit exactes, et re-essayez.','warning');
						pushInstallText("Erreur fatale, le processus n\'a pas pu se libérer !!!",1,"warning");
					}
					else if(data == 'invalidesitename')
					{
						tendoo.notice.alert('Une erreur s\'est produite durant la configuration du site, vérifiez que le nom du site envoyé ait au moins 4 lettres, et re-essayez.','warning');
						pushInstallText("Erreur fatale, le processus n\'a pas pu se libérer !!!",1,"warning");
					}
					else
					{
						tendoo.notice.alert('Une erreur s\'est produite durant la cr&eacute;ation des tables. Voici ce que le serveur renvoi','warning');
						pushInstallText("Erreur fatale, le processus n\'a pas pu se libérer !!!",1,"warning");
						tendoo.window.title('Rapport du serveur : cr&eacute;ation des tables').show(report);
					}
				},
				url			:	'<?php echo $this->instance->url->site_url(array('install','createTables'));?>'
			});
			return false; // dont allow direct access :D
		});
	});
                                        </script>									
									</div>
									<div class="col-lg-4">
                                        <h4><i class="fa fa-info-sign"></i> Information</h4>
										<form method="post">
											Si vous rencontrez des difficult&eacute;s avec votre site, vous pouvez faire la restauration via l'espace administration.
										</form>
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
<style type="text/css">
    #backgroundLogin{
        background:url(<?php echo img_url($this->instance->tendoo->getBackgroundImage());?>) ;
        background-position:0 0;
        background-repeat: no-repeat;
    }
</style>
</html>