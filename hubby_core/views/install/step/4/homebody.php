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
                        <div class="tile double-vertical double bg-color-pinkDark">
                            <div class="tile-content">
                                <h2>Installation termin&eacute;e</h2>
                                <br>
                                <p>En d&eacute;cidant de continuer, il ne sera plus possible de d'acc&eacute;der &agrave; cette page d'installation, par cons&eacute;quent de modifier les informations peronnelles de votre site web. En cas d'irr&eacute;gularité dans votre site web, vous ne pourrez faire des modifications qu'&agrave; partir de la <cite><strong>page d'administration</strong></cite>. En ce qui concerne les informations de connexion &agrave; la base de donn&eacute;e, compte tenu de l'importance de ces informations, leurs modifications est impossible. Seul la re-installation du site corrigera le probl&egrave;me.</p>
                                <div class="brand">
                                    <i class="icon-info icon" style="font-size:30px;margin:0 0 10px 10px;"></i>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="span2">
                        <div class="tile bg-color-greenDark" title="Acc&eacute;der au site">
                            <div class="tile-content">
                                <i class="icon-arrow-right-3 toweb_l" style="font-size:120px;"></i>
                                <form method="post" style="display:none;">
                                    <div class="input-control text">
                                    </div>
                                    <input class="toweb" type="submit" value="Espace administrateur" name="web_access">
                                </form>
                                <script>
                                $(document).ready(function()
                                {
                                    $('.toweb_l').bind('click',function()
                                    {
                                        $('.toweb').trigger('click');
                                    });
                                });
                                </script>
                            </div>
                        </div>
                        <div class="tile bg-color-blue" title="Espace administration">
                            <div class="tile-content">
                                <i class="icon-home toadmin_l" style="font-size:120px;"></i>
                                <form method="post" style="display:none;">
                                    <div class="input-control text">
                                    </div>
                                    <input class="toadmin" type="submit" value="Espace administrateur" name="admin_access">
                                </form>
                                <script>
                                $(document).ready(function()
                                {
                                    $('.toadmin_l').bind('click',function()
                                    {
                                        $('.toadmin').trigger('click');
                                    });
                                });
                                </script>
                            </div>
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
<body>