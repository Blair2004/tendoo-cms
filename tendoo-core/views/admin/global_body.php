<?php
	$options	=	get_core_vars( 'options' );
	$body		=	get_core_vars( 'body' );
	function page_header()
	{
	?>
<body style="background:<?php echo theme_background_color();?>">
    <section class="vbox">
<?php
    }
	function page_bottom($options,$obj)
	{
		if( get_user_meta( 'new_comer' ) === true )	 // Set 1 after creating
		{
			?>
<!-- Step 1 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
    	<div class="row">
            <div class="col-lg-7" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 style="margin:0;">Bienvenue sur <?php echo get('core_version');?></h1>
                        <smaill>La nouvelle génération de Tendoo</small>
                        <hr class="line-dashed">
                        <h3>Tendoo, c'est pour vous !!!</h3>
Que vous soyez un adepte des technologies de la communication ou un professionnel qui voudrait déployer son site web, Tendoo peut être utilisé selon vos envies et vos ambitions. Vous aurez dans chaque cas des outils mis à votre disposition par Tendoo, qui vous permettrons de surveiller l'évolution de votre site web ou tout simplement du taux d'audience de votre site web.</p>
                        <p> <a class="btn <?php echo theme_button_class();?> btn-large proceed">Découvrir les nouveautés</a> <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" dismissmodal id="quitTour"> Ne plus afficher </a> </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 text-center"> <i class="fa fa-gift" style="font-size:350px;dislay:compact;width:auto;margin-top:40px;"></i> </div>
        </div>
    </div>
</div>
<!-- Step 2 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4"> 
                    	<img style="width:100%;" src="<?php echo $obj->instance->url->img_url('Hub_back.png');?>" alt="girl"> 
                        <img style="width:100%;margin-top:10px;" src="<?php echo $obj->instance->url->img_url('install_apps.jpg');?>" alt="girl"> 
                    </div>
                    <div class="col-lg-8">
                    	<h4>Découvrir les nouveautés</h4>
                        <p>
                        	<ul>
                            	<li>Le module Blogster à été mis à jour et proposes des sous pages pour vos catégories, mots-clés (tags) et articles.</li>
                                <li>Le module Tendoo Index Manager à été simplifier en proposant un bouton pour sauvegarder tous les modifications.</li>
                                <li>Le thème Nevia à été mis à jour et corrige l'erreur sur la page d'accueil.</li>
                                <li>Le module Contact Manager à également été mis à jour.</li>
							</ul>
                            Toutes ces applications fonctionnent uniquement sur la version <?php echo get('core_id');?> de Tendoo.
						</p>
       					<h4>C'est quoi Tendoo ?</h4>                 
                        <p>Tendoo est une application qui vous permet de mettre sur pied un site web sans avoir besoin d'avoir des connaissance en codage. Il vous permet de créer plusieurs type de site web (blog, forum, boutique e-Commerce, site vitrine). L'interface qu'il propose est suffisament intuitive pour faciliter sa prise en main.</p>
                        <p>Bien que la gestion d'un site web va au-delà de son contenu, vous serrez souvent amener à répondre à des problèmes de sécurité, de référencement ou tout simplement d'optimisation. Tendoo mets à votre disposition divers outils qui sont accèssibles depuis l'emplacement "Outils" & "Paramètres", afin d'améliorer non seulement les performances de votre site web, mais aussi de vous assurer d'avoir un meilleur positionnement sur les résultats des moteurs de recherche.</p>
                        <h4>Etendez les fonctionnalités de base avec les applications</h4>
                        <p>Vous pouvez étendre les fonctionnalités de base de votre site web Tendoo en installant les applications Tendoo. Les applications sont de deux types : Modules et Thèmes.<br>
                        	<p> <a class="btn <?php echo theme_button_class();?> btn-large proceed"> Comment ça marche ? </a> <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" id="quitTour" dismissmodal> Ne plus afficher </a> </p>
                        </p>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Step 3 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4"> <img style="width:100%;" src="<?php echo $obj->instance->url->img_url('how_does_it_work.jpg');?>" alt="girl">  </div>
                    <div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Comment ça marche ?</h4>
                                <p>Tendoo est fourni avec des applications par défaut, afin de vous permettre de mettre sur pied un blog assez complet avec un gestionnaire de page d'accueil, un gestionnaire d'article (Blogster), une page de contact et un éditeur de page HTML, un gestionnaire de widgets, il s'agit ici de modules. <br><br>Les modules sont de deux types. Soit ils s'exécutent sur tous votre blog dans l'interface publique (on dit qu'il s'agit d'un module de type "<strong>GLOBAL</strong>"), soit ils s'exécutent uniquement sur une page dans laquelle ils ont été assignés (on dit qu'il s'agit d'un module de type "<strong>UNIQUE</strong>", ou par page).</p>
                                <p>Un même module peut être exécuté sur plusieurs pages. Pour exécuter un module sur une page, il faut "l'affecter" dans la page de création et d'édition de pages. Une fois installé les applications disposent d'une interface embarquée, cette interface vous permet d'utiliser les fonctionnalités du module. Un page qui n'exécute pas un module ou dans laquelle une page n'est pas liée, génèrera une erreur lors de son accès.</p>
                                <p> <a class="btn <?php echo theme_button_class();?> btn-large proceed"> Comment utiliser les outils ? </a> <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" id="quitTour" dismissmodal> Ne plus afficher </a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Step 4 -->
<div data-stepContent style="display:none">
    <div class="hero-unit">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4"> <img style="width:100%;" src="<?php echo $obj->instance->url->img_url('help_button.jpg');?>" alt="girl"> <img style="width:100%;margin-top:10px;" src="<?php echo $obj->instance->url->img_url('introjs_showcase.jpg');?>" alt="girl"> </div>
                    <div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Comment utiliser les outils ?</h4>
                                <p>Sur chaque page de l'espace administration, vous trouverez une bouton d'aide en haut à droite, qui vous permettra d'ouvrir une visite guidée. Pour avoir plus d'information sur Tendoo, <a href="http://tendoo.org/index.php/guide" target="_blank"><strong>lisez le manuel d'utilisation</strong></a>.</p>
                                <p>L'objectif des visites guidées, est de vous aider à mieux comprendre comment utiliser une fonctionnalité. C'est la raison pour laquelle, des petites boites modales flottantes indexeront certains éléments sur une page. Lorsqu'une page sera visitée pour la première fois, le bouton d'aide aura comme texte "<strong>Cliquez pour une visite</strong>". Après une visite, ce statut pourra être réinitialisé depuis la page des paramètres, dans la section des "<strong>autorisations</strong>".</p>
                                <p>Chaque visites guidées, disposent de bouton de navigation, vous permettant de facilement naviguer dans la visite guidée. Vous pourrez donc revenir sur un point que vous n'aurez pas totalement assimilé. </p>
                                <p>Utilisez les flèches de naviguation pour parcourir la visite guidée. Appuyez sur "ESC" sur votre clavier pour quitter la visite guidée.</p>
                                <p> 
                                <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" id="quitTour" dismissmodal> Ne plus afficher </a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Last Step -->
<!--<div data-stepContent style="display:none">
    <div class="hero-unit">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4"> <img style="width:100%;" src="<?php echo $obj->instance->url->img_url('help_button.jpg');?>" alt="girl"> <img style="width:100%;margin-top:10px;" src="<?php echo $obj->instance->url->img_url('introjs_showcase.jpg');?>" alt="girl"> </div>
                    <div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Par ou commencer ?</h4>
                                <p></p>
                                <p> <a data-requestType="silent" data-url="<?php echo $obj->url->site_url(array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" id="quitTour"> Quitter (et ne plus afficher) </a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<script>
			var wizard	=	'<section class="wizmodal">'+ 
								'<div class="wizard clearfix">'+
									'<ul class="steps">'+
										'<li data-target="#step1" class="active" >'+
										'<span class="badge badge-info">1</span>Accueil</li>'+
										'<li data-target="#step2" class=""><span class="badge">2</span>Découvrir les nouveautés</li>'+
										'<li data-target="#step3" class=""><span class="badge">3</span>Comment ça marche ?</li>'+
										'<li data-target="#step4" class=""><span class="badge">4</span>Comment utiliser les outils ?</li>'+
										//'<li data-target="#step5" class=""><span class="badge">5</span>Par où commencer ?</li>'+
									'</ul>'+
									'<div class="actions">'+
										'<button type="button" class="btn btn-white btn-xs btn-prev">Pr&eacute;cedent</button>'+
										'<button type="button" class="btn btn-white btn-xs btn-next">Suivant</button>'+
									'</div>'+
								'</div>'+
								// '<img class="backgroundImg" src="<?php echo $obj->instance->url->img_url('tendoo_1.jpg');?>" style="position:absolute;">'+
								'<div class="step-content" style="">'+
									'<div class="step-pane active" id="step1">This is step 1</div>'+
									'<div class="step-pane" id="step2">This is step 2</div>'+
									'<div class="step-pane" id="step3">This is step 3</div>'+
									'<div class="step-pane" id="step4">This is step 4</div>'+
									'<div class="step-pane" id="step5">This is step 5</div>'+
								'</div>'+
							'</section>';
			$(document).ready(function(){
				tendoo.window.title('Bienvenue sur <?php echo $obj->instance->version();?>').show(wizard);
				var steps	=	1;
				$('[data-stepContent]').each(function(){
					$('.wizmodal').find('#step'+steps).html($(this).html());
					steps++;
				});
				tendoo.silentAjax.bind(); // bind Event
				$('#quitTour').bind('click',function(){
					$modal	=	$(this).closest('.modal-dialog');
					$button	=	$($modal).find('[data-dismiss="modal"]').trigger('click');
				});
				var counter	=	1;
				$('.wizmodal ul[class="steps"] li').each(function(){
					$(this).data('id',counter);
					counter++;
				});
				$('.wizmodal .actions button:eq(0)').bind('click',function(){
					if($('.wizmodal ul[class="steps"] li[class="active"]').length == 0)
					{
						$('.wizmodal ul[class="steps"] li').eq(0).addClass('active').find('.badge').addClass('badge-info');
						
					}
					var activeId	=	$('.wizmodal ul[class="steps"] li[class="active"]').data('id');
					if(activeId > 1)
					{
						$('.wizmodal ul[class="steps"]')
							.find('li')
							.removeClass('active')
							.find('.badge')
							.removeClass('badge-info');
						$('.wizmodal ul[class="steps"]')
							.find('li')
							.eq(parseInt(activeId)-2)
							.addClass('active')
							.find('.badge')
							.addClass('badge-info');
						$('.wizmodal .step-content')
							.children()
							.hide()
							.removeClass('active');
						$('.wizmodal .step-content')
							.children()
							.eq(parseInt(activeId)-2)
							.addClass('active')
							.show();
					}
				});
				$('.wizmodal .actions button:eq(1)').bind('click',function(){
					if($('.wizmodal ul[class="steps"] li[class="active"]').length == 0)
					{
						$('.wizmodal ul[class="steps"] li').eq(0).addClass('active').find('.badge').addClass('badge-info');;
					}
					var activeId	=	$('.wizmodal ul[class="steps"] li[class="active"]').data('id');
					// Si le nom d'enfant est inférieur à l'identifiant de la page en cours, on parcours (+1)
					if(activeId < $('.wizmodal ul[class="steps"]').find('li').length)
					{
						$('.wizmodal ul[class="steps"]').children('li')
							.removeClass('active')
							.find('.badge')
							.removeClass('badge-info');
						$('.wizmodal ul[class="steps"]').children('li')
							.eq(parseInt(activeId))
							.addClass('active')
							.find('.badge')
							.addClass('badge-info');
								
						$('.wizmodal .step-content')
							.children()
							.each(function(){
								$(this).hide().removeClass('active');
							})
						$('.wizmodal .step-content')
							.children()
							.eq(parseInt(activeId))
							.addClass('active')
							.show();
					}
				});
				$('.proceed').bind('click',function(){
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
</body>
</html><?php
		}
		else
		{
		?>
    </section>
</body>
</html>
<?php
		}

	}
	if(is_array(get_core_vars( 'body' )))
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
			$this->instance->tendoo->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		page_header();
	}
	//*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=	Affiche le contenu par le module -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*//
	//*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*//
	echo is_array($body) ? $body['RETURNED'] : $body;
	//*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*//
	if(is_array($body))
	{
		if(array_key_exists('MCO',$body))
		{
			if($body['MCO'] == FALSE)
			{
				echo $this->instance->file_2->js_load();
				page_bottom($options,$this);
			}
		}
		else
		{
			$this->instance->tendoo->show_error('Le tableau renvoy&eacute; manque d\'information suffisante pour l\'affichage int&eacute;grale de la page','Interpr&eacute;tation mal exprimé');
		}
	}
	else
	{
		echo $this->instance->file_2->js_load();
		page_bottom($options,$this);
	}
	