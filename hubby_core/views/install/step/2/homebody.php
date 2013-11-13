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
                    <div class="tile double double-vertical bg-color-greenDark">
                        <div class="tile-content">
                        	<h2>Connexion &agrave; la base de donn&eacute;es</h2>
                            <br>
                            <br>
                            <p>Nous allons procéder à la création de votre site web. vous devez spécifier toutes les informations d'accès à la base de données. <br><br>La base de donn&eacute;e que vous devez fournir doit exister. Dans le cas contraire, le site ne pourra &ecirc;tre installé. <br><br>Verifiez que le nom de la base de donn&eacute;e, de l'h&ocirc;te et le mot de passe correspondent &agrave; ceux que vous sp&eacute;cifiez ci-apr&egrave;s.</p>
                            <div class="brand">
    	                    	<i class="icon-broadcast icon" style="font-size:30px;margin:0 0 10px 10px;"></i>
	                        </div>
                        </div>
                    </div>
                    <div class="tile triple double-vertical bg-color-purple">
                        <div class="tile-content">
                        	<h2>Connexion &agrave; la base de donn&eacute;e</h2>
                            <br>
                            <form method="post" action="" class="hubby_form install_step_form">
                                <div class="input-control text">
                                    <input type="text" name="host_name" placeholder="Identifiant de l'h&ocirc;te">
                                </div>
                                <div class="input-control text">
                                    <input type="text" name="user_name" placeholder="Nom de l'utilisateur">
                                </div>
                                <div class="input-control text">
                                    <input type="password" name="host_password" placeholder="Mot de passe de l'utilisateur">
                                </div>
                                <div class="input-control text">
                                    <input type="text" name="db_name" placeholder="Nom de la base de donn&eacute;e">
                                </div>
                                <div class="input-control text">
                                    <select name="db_type" style="color:#333;background:#FFF;">
                                        <option value="" style="color:#333">Type de la base de donn&eacute;e</option>
                                        <option value="mysql" style="color:#333">Mysql</option>
                                        <option value="mysqli" style="color:#333">Mysql Lite</option>
                                        <option value="sqlite" style="color:#333">Sql Lite</option>
                                    </select>
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