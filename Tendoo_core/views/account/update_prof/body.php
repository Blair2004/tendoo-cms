<?php echo $smallHeader;?>
<section class="bg-light lt scrollable">
    <div class="panel-content">
        <div class="container wrapper">
        	<?php echo $this->core->notice->parse_notice();?>
            <?php echo notice_from_url();?>
            <?php echo validation_errors();?>
			<div class="panel">
				<div class="panel-heading">
                	Donn&eacute;es personnelles
				</div>
                <form method="post" class="panel-body">
                    <div class="form-group">
                        <label class="label-control">Nom :</label>
                        <input class="form-control" type="text" placeholder="Nom" name="user_name" />
                    </div>
                    <div class="form-group">
                        <label class="label-control">Pr&eacute;nom :</label>
                        <input class="form-control" type="text" placeholder="Pr&eacute;nom" name="user_surname" />
                    </div>
                    <div class="line line-dashed"></div>
                    <input class="btn btn-white" type="submit" value="Enregistrer" />
                </form>
            </div>
            <div class="panel">
                <div class="panel-heading">
                	Informations de s&eacute;curit&eacute;
				</div>
                <form method="post" class="panel-body">
                    <div class="form-group">
                        <label class="label-control">Ancien Mot de passe :</label>
                        <input class="form-control" type="password" placeholder="Ancien mot de passe" name="user_oldpass" />
                    </div>
                    <div class="form-group">
                        <label class="label-control">Nouveau Mot de passe :</label>
                        <input class="form-control" type="password" placeholder="Nouveau mot de passe" name="user_newpass" />
                    </div>
                    <div class="form-group">
                        <label class="label-control">Retaper le mot de passe :</label>
                        <input class="form-control" type="password" placeholder="Retaper le nouveau" name="user_confirmnewpass" />
                    </div>
                    <div class="line line-dashed"></div>
                    <input class="btn btn-white" type="submit" value="Enregistrer" />
                </form>
            </div>
            <div class="panel">
                <div class="panel-heading">
                	Donn&eacute;es de localisation
				</div>
                <form method="post" class="panel-body">
                    <div class="form-group">
                        <label class="label-control">Pays :</label>
                        <input class="form-control" type="text" placeholder="Pays" name="user_state" />
                    </div>
                    <div class="form-group">
                        <label class="label-control">Ville :</label>
                        <input class="form-control" type="text" placeholder="Ville" name="user_town" />
                    </div>
                    <div class="line line-dashed"></div>
                    <input class="btn btn-white" type="submit" value="Enregistrer" />
                </form>
            </div>
        </div>
    </div>
</section>
