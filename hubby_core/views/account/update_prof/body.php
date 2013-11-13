<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Mettre &agrave; jour mon profil<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
            	<div class="grid">
                	<div class="row">
                    	<div class="span4 padding10 bg-color-teal fg-color-white">
                        	<h2 class="fg-color-white">Donn&eacute;es personnelles</h2>
                        	<form method="post">
                            	<div class="input-control text">
                                	<p>Nom :</p>
                                    <input type="text" placeholder="Nom" name="user_name" />
                                </div>
                                <div class="input-control text">
                                	<p>Pr&eacute;nom :</p>
                                    <input type="text" placeholder="Pr&eacute;nom" name="user_surname" />
                                </div>
                                <input type="submit" value="Enregistrer" />
                            </form>
                        </div>
                        <div class="span4 padding10 bg-color-pinkDark fg-color-white">
                        	<h2 class="fg-color-white">Informations de s&eacute;curit&eacute;</h2>
                            <h4 class="fg-color-white">Modifier le mot de passe</h4>
                            <br />
                        	<form method="post">
                            	<div class="input-control text">
                                	<p>Ancien Mot de passe :</p>
                                    <input type="password" placeholder="Ancien mot de passe" name="user_oldpass" />
                                </div>
                                <div class="input-control text">
                                	<p>Nouveau Mot de passe :</p>
                                    <input type="password" placeholder="Nouveau mot de passe" name="user_newpass" />
                                </div>
                                <div class="input-control text">
                                	<p>Retaper le mot de passe :</p>
                                    <input type="password" placeholder="Retaper le nouveau" name="user_confirmnewpass" />
                                </div>
                                <input type="submit" value="Enregistrer" class="bg-color-red" />
                            </form>
                        </div>
                        <div class="span4 padding10 bg-color-blueDark fg-color-white">
                        	<h2 class="fg-color-white">Donn&eacute;es de localisation</h2>
                            <br />
                        	<form method="post">
                            	<div class="input-control text">
                                	<p>Pays :</p>
                                    <input type="text" placeholder="Pays" name="user_state" />
                                </div>
                                <div class="input-control text">
                                	<p>Ville :</p>
                                    <input type="text" placeholder="Ville" name="user_town" />
                                </div>
                                <input type="submit" value="Enregistrer" />
                            </form>
                        </div>
                    </div>
                	
                </div>
            </div>
        </div>
    </div>
</div>