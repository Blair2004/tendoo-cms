<body cz-shortcut-listen="true">
<header class="header bg-primary"> <p><a href="<?php echo $this->core->url->main_url();?>"><img style="height:30px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->hubby->getVersion();?></a></p></header>
<section id="content" class="m-t-lg wrapper-md animated fadeInDown scrollable wrapper"> 
    <div class="row">
    	<div class="col-lg-4">
            <div class="col-lg-13">
                <section class="panel">
                    <header class="panel-heading bg bg-success text-center">Connexion etablie</header>
                    <div class="panel-body">
                        <p>Hubby peut maintenant se connecter à votre base de donnée. Maintenant vous devez indiquez certaines inforamtions concernant votre nouveau site web.</p>
                    </div>
                </section>
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
            <section class="panel">
                <header class="panel-heading bg bg-color-green text-center">Erreur sur le formulaire</header>
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
                <header class="panel-heading bg bg-color-red text-center">Erreur sur le formulaire</header>
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
            <section class="panel">
                <header class="panel-heading bg bg-color-yellow text-center">Information de votre site web</header>
                <form id="siteNameForm" class="panel-body" method="post" action="<?php echo $this->core->url->site_url(array('install','etape',4));?>">
                    <div class="form-group">
                        <label class="host_name">Nom du site</label>
                        <input name="site_name" id="site_name" type="text" placeholder="Nom de votre site" class="form-control">
                    </div>
                    <div class="line line-dashed"></div>
                    <button type="submit" id="siteNameSubmiter" class="btn btn-info">Continuer</button>
                </form>
                    <div class="line"></div>
                    <div class="panel-body installingStatus">
                    </div>
                <script>
					function triggerInstall()
					{
						
						var installStatus		=	true;
						var defaultsApp			=	new Array();
							defaultsApp[0]		=	"blogster";
							defaultsApp[1]		=	"modus";
							defaultsApp[2]		=	"hubby_index_mod";
							defaultsApp[3]		=	"file_manager";
							defaultsApp[4]		=	"widget_admin";
							defaultsApp[5]		=	"PageEditor";
						var defaultsAppText		=	new Array();
							defaultsAppText[0]	=	'Installation du module Blogster...';
							defaultsAppText[1]	=	'Installation du thème Modus...';
							defaultsAppText[2]	=	'Installation du module Hubby_index_mod...';
							defaultsAppText[3]	=	'Installation du module Gestionnaire de fichiers...';
							defaultsAppText[4]	=	'Installation du module Gestionnaire de widgets...';
							defaultsAppText[5]	=	'Installation du module Page Editor...';
						var defaultsAppFinish	=	new Array();
							defaultsAppFinish[0]=	'<span style="color:green">Installation du module terminée</span>';
							defaultsAppFinish[1]=	'<span style="color:green">Installation du thème terminée</span>';
							defaultsAppFinish[2]=	'<span style="color:green">Installation du module Hubby_index_mod terminée</span>';
							defaultsAppFinish[3]=	'<span style="color:green">Installation du Gestionnaire de fichier terminée</span>';
							defaultsAppFinish[4]=	'<span style="color:green">Installation du Gestionnaire de widget terminée</span>';
							defaultsAppFinish[5]=	'<span style="color:green">Installation du module Page Editor terminée</span>';
						var defaultsAppHtml		=	
							"<h5>Installation des applications par d&eacute;faut</h5>"+
							'<ul class="statusList">'+
							'</ul>';
						$('.installingStatus').html('');
						$('.installingStatus').append(defaultsAppHtml);
						var iterator			=	0;
						var Interval			=	setInterval(function(){
							if(installStatus == true)
							{
								var curIterator	=	iterator
								var action		=	'';
								if(typeof defaultsApp[iterator] == 'undefined') // Lorsqu'il ny a plus aucune application a installer :D
								{
									clearInterval(Interval);
									$('.statusList').append('<li class="currentInstall_'+curIterator+'">Installation des applications terminée...</li>');
									$('#siteNameForm').submit();
								}
								else
								{
									switch(defaultsApp[iterator])
									{
										case "blogster"	:
											action	=	"<?php echo $this->core->url->site_url(array('install','installApp'));?>/blogster";
										break;
										case "modus"	:
											action	=	"<?php echo $this->core->url->site_url(array('install','installApp'));?>/modus";
										break;	
										case "hubby_index_mod":
											action	=	"<?php echo $this->core->url->site_url(array('install','installApp'));?>/hubby_index_mod";									
										break;
										case "file_manager":
											action	=	"<?php echo $this->core->url->site_url(array('install','installApp'));?>/file_manager";									
										break;
										case "widget_admin":
											action	=	"<?php echo $this->core->url->site_url(array('install','installApp'));?>/widget_admin";									
										break;
										case "PageEditor":
											action	=	"<?php echo $this->core->url->site_url(array('install','installApp'));?>/PageEditor";									
										break;
									}
									$.ajax({
										beforeSend	:	function()
										{
											installStatus	=	false;
											$('.statusList').append('<li class="currentInstall_'+curIterator+'">'+defaultsAppText[curIterator]+'</li>');
										},
										success		:	function(data)
										{
											installStatus	=	true;
											$('.statusList').find('.currentInstall_'+curIterator).html(defaultsAppFinish[curIterator]);
										},
										url			:	action
									});
								}
								iterator++;
							}
						},500);
					}
				$(document).ready(function(){
					$('#siteNameSubmiter').bind('click',function(){
						$.ajax({
							beforeSend	:	function()
							{
								$('.installingStatus').html('');
								$('.installingStatus').append('<h4>Configuration du site</h4><ul class="creatingTables"><li>Cr&eacute;ation des tables...</li></ul>');
							},
							type		:	'POST',
							data		:	{	'site_name'		:	$('#site_name').val()},
							dataType	:	'script',
							success		:	function(data)
							{
								if(data == 'true')
								{
									triggerInstall();
									$('.installingStatus').find('.creatingTables').html('<li style="color:green">Configuration termin&eacute;e</li>');
								}
								else
								{
									alert('Une erreur s\'est produite durant la configuration du site, vérifiez que le nom du site envoyé ne soit pas vide, assurez-vous que les données de connexion soit exactes, et re-essayer');
									$('.creatingTables').append('<li style="color:red">Erreur fatale, l\'installation &agrave; &eacute;chou&eacute;e!!!</li>');
								}
							},
							url			:	'<?php echo $this->core->url->site_url(array('install','createTables'));?>'
						});
						return false; // dont allow direct access :D
					});
				});
				</script>
            </section>
        </div>
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading bg bg-danger text-center">Information</header>
                <form class="panel-body" method="post">
                    Si vous rencontrez des difficult&eacute;s avec votre site, vous pouvez faire la restauration via l'espace administration.
                </form>
            </section>
        </div>
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder clearfix">
        <p> <small><?php echo $this->core->hubby->getVersion();?><br>
            © 2013</small> </p>
    </div>
</footer>
</body>
</html>