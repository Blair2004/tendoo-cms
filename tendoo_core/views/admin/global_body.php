<?php
	function page_header()
	{
	?>
<body style="background:<?php echo theme_background_color();?>">
    <section class="hbox stretch"><?php
    }
	function page_bottom($options,$obj)
	{
		if($obj->core->users_global->current('ADMIN_THEME') == 1)
		{
		?>
    </body>
</html>
<?php
		}
		else if($obj->core->users_global->current('FIRST_VISIT') == "1")	 // Set 1 after creating
		{
			?>
			<div id="WelCome" style="display:none">
				<div class="hero-unit">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
									<div class="row">
										<div class="col-lg-9">	
											<h1>Bienvenue sur <?php echo $obj->core->tendoo->getVersion();?></h1>
											<p>L'&eacute;quipe vous remercie d'avoir choisi Tendoo comme votre logiciel de cr&eacute;ation.<br>Ceci est le Guide de la nouvelle version, nous vous recommandons 
											de suivre cette petite visite guid&eacute;e, qui vous donnera un aperçu du potentiel de Tendoo.</p>
											<p>Que vous soyez un professionnel ou un amateur, cette visite est faites pour vous. Vous découvrirez comment prendre en main l'espace administration de Tendoo, mais aussi comment étendre ses 
											fonctionnalités en installant de nouvelles applications.</p>
											<p>
												<a class="btn <?php echo theme_button_class();?> btn-large proceed">
												Découvrir Tendoo
												</a>
												<a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn btn-danger btn-large" id="quitTour">
												Quitter la visite
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<img class="logo_Girls" src="<?php echo $obj->core->url->img_url('woman.png');?>" alt="girl">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
			var wizard	=	'<section class="wizmodal">'+ 
								'<div class="wizard clearfix">'+
									'<ul class="steps">'+
										'<li data-target="#step1" class="active" >'+
										'<span class="badge badge-info">1</span>Accueil</li>'+
										'<li data-target="#step2" class=""><span class="badge">2</span>Prise en main</li>'+
										'<li data-target="#step3" class=""><span class="badge">3</span>Personnaliser votre site</li>'+
										'<li data-target="#step4" class=""><span class="badge">4</span>Quoi d\'autre ?</li>'+
										'<li data-target="#step5" class=""><span class="badge">5</span>La communaut&eacute;</li>'+
									'</ul>'+
									'<div class="actions">'+
										'<button type="button" class="btn btn-white btn-xs btn-prev" disabled="disabled">Pr&eacute;cedent</button>'+
										'<button type="button" class="btn btn-white btn-xs btn-next" data-last="Finish">Suivant</button>'+
									'</div>'+
								'</div>'+
								// '<img class="backgroundImg" src="<?php echo $obj->core->url->img_url('tendoo_1.jpg');?>" style="position:absolute;">'+
								'<div class="step-content" style="">'+
									'<div class="step-pane active" id="step1">This is step 1</div>'+
									'<div class="step-pane" id="step2">This is step 2</div>'+
									'<div class="step-pane" id="step3">This is step 3</div>'+
									'<div class="step-pane" id="step4">This is step 3</div>'+
									'<div class="step-pane" id="step5">This is step 3</div>'+
								'</div>'+
							'</section>';
			$(document).ready(function(){
				tendoo.window.title('Bienvenue sur <?php echo $obj->core->tendoo->getVersion();?>').show(wizard);
				var cache	=	$('#WelCome').html();
				$('#WelCome').remove();
				$('.wizmodal #step1').html(cache);
				tendoo.silentAjax.bind(); // bind Event
				$('#quitTour').bind('click',function(){
					$modal	=	$(this).closest('.modal-dialog');
					$button	=	$($modal).find('[data-dismiss="modal"]').trigger('click');
				});
				$('.proceed').bind('click',function(){
					$('.actions button:eq(1)').bind('click',function(){
						alert('Ok');
					});
					$('.actions button:eq(1)').trigger('click');
				});
			});
			</script>
			<style type="text/css">
			@media (width: 1280px)
			{
				.wizmodal .logo_Girls
				{
					width:73.9%;position:absolute;top:0px;right:0;
				}
			}
			</style>
			<?php
		}

	}
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				page_header();
			}
		}
		else
		{
			$this->core->tendoo->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		page_header();
	}
	 echo is_array($body) ? $body['RETURNED'] : $body;
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				echo $this->core->file_2->js_load();
				page_bottom($options,$this);
			}
		}
		else
		{
			$this->core->tendoo->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		echo $this->core->file_2->js_load();
		page_bottom($options,$this);
	}
	