<body class="metrouicss">
    <div id="header" class="nav-bar" style="background:inherit;">
        <div class="nav-bar-inner padding10">
            <span class="element brand">
                <img src="<?php echo $this->core->url->img_url("logo_4.png");?>" style="float:left;height:40px;position:relative;top:-10px;">
                <?php echo $this->core->hubby->getVersion();?>
            </span>
        </div>
    </div> 
    <div class="install_page" id="body">
        <div class="page-region-content" style="margin:1%;">
            <div class="grid">
                <div class="row">
                	<div class="span4">
                        <div class="tile double bg-color-blueDark">
                            <div class="tile-content">
                                <h2>Connexion etablie</h2>
                                <br>
                                <p>Hubby peut maintenant se connecter à votre base de donnée. Maintenant vous devez indiquez certaines inforamtions concernant votre nouveau site web.</p>
                                <div class="brand">
                                    <i class="icon-checkmark icon" style="font-size:30px;margin:0 0 10px 10px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="tile double bg-color-teal">
                            <div class="tile-content">
                                <h2>Information</h2>
                                <br>
                                <p>Si vous rencontrez des difficult&eacute;s avec votre site, vous pouvez faire la restauration via l'espace administration.</p>
                                <div class="brand">
                                    <i class="icon-info icon" style="font-size:30px;margin:0 0 10px 10px;"></i>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="tile double double-vertical bg-color-purple">
                        <div class="tile-content">
                        	<h2>Information de votre site web</h2>
                            <br>
                            <form method="post">
                                <div class="input-control text">
                                    <input type="text" name="site_name" placeholder="Nom de votre site web">
                                </div>
                                <input type="submit" value="Continuer" name="submit">
                            </form>
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
                        <div class="tile double double-vertical bg-color-red">
                        	<div class="tile-content">
                            	<h2>Erreur sur le formulaire</h2>
                                <br>
                                <ul>
                                    <?php echo $form_response;?>
                                </ul>
                            </div>
                            <div class="brand">
                                <i class="icon-warning icon" style="font-size:30px;margin:0 0 10px 10px;"></i>
                            </div>
                        </div>
                        <?php
					}
					else if($query_error)
					{
						?>
                        <div class="tile double double-vertical bg-color-red">
                        	<div class="tile-content">
                            	<h2>Erreur</h2>
                                <br>
								<?php echo $query_error;?>
                            </div>
                            <div class="brand">
                                <i class="icon-warning icon" style="font-size:30px;margin:0 0 10px 10px;"></i>
                            </div>
                        </div>
                        <?php
					}
					?>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-bar-inner float_box_100" id="footer">
    
    </div>
</body>
</html>