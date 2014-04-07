    <section id="content" class="wrapper-md animated fadeInUp scrollable wrapper"> 
        <div class="row">
            <div class="col-lg-6 col-sm-offset-3">
                    <?php
			$field_1	=	(form_error('user_pseudo')) ? form_error('user_pseudo') : '';
			$field_2	=	(form_error('user_password')) ? form_error('user_password') : '';
			$field_3	=	(form_error('user_password_confirm')) ? form_error('user_password_confirm') : '';
			;
			$field_4	=	(form_error('user_mail')) ? form_error('user_mail') : '';
			$field_5	=	(form_error('user_sex')) ? form_error('user_sex') : '';
			$field_6	=	(form_error('user_captcha')) ? form_error('user_captcha') : '';
			$field_7	=	(form_error('priv_id')) ? form_error('priv_id') : '';
			;
			?>
            	<?php echo $this->core->notice->parse_notice();?>
            	<section class="panel">
                	<header class="panel-heading <?php echo theme_class();?> text-center"><?php echo $pageTitle;?></header>
                	<form method="post" class="panel-body">
                        <div class="form-group text">
                        	<label class="control-label">Pseudo <?php echo $field_1;?></label>
                            <input type="text" name="user_pseudo" class="form-control" placeholder="Pseudo" />
                        </div>
                        <div class="form-group password">
                        	<label class="control-label">Mot de passe <?php echo $field_2;?></label>
                            <input class="form-control" type="password" name="user_password" placeholder="Mot de passe"/>
                        </div>
                        <div class="form-group password">
                        	<label class="control-label">Confirmer le mot de passe <?php echo $field_3;?></label>
                            <input class="form-control" type="password" name="user_password_confirm" placeholder="Confirmer le mot de passe"/>
                        </div>
                        <div class="form-group text">
                        	<label class="control-label">Email <?php echo $field_4;?></label>
                            <input class="form-control" type="text" name="user_mail" placeholder="Email"/>
                        </div>
                         <?php
						if($options[0]['ALLOW_PRIVILEGE_SELECTION'] == "1")
						{
						?>
                        <div class="form-group">
                        	<label class="control-label">Choisir un privil&egrave;ge <?php echo $field_7;?></label>
                            <select class="form-control" name="priv_id">
                                <option value="">Choisir un privil&egrave;ge</option>
                                <?php
								foreach($allowPrivilege as $a)
								{
									?>
                                    <option value="<?php echo $a['PRIV_ID'];?>"><?php echo $a['HUMAN_NAME'];?></option>
                                    <?php
								}
								?>
                            </select>
                        </div>
                        <?php
						}
						?>
                        <div class="form-group">
                        	<label class="control-label">Selection du sexe <?php echo $field_5;?></label>
                            <select class="form-control" name="user_sex">
                                <option value="">Selection du sexe</option>
                                <option value="MASC">Masculin</option>
                                <option value="FEM">Feminin</option>
                            </select>
                        </div>
                        <div class="form-group text">
                        	<img src="<?php echo $captcha['DIRECTORY'];?>" class="form-control" style="height:150px;" />
                            <input type="hidden" value="<?php echo $captcha['CODE'];?>" name="captchaCorrespondance" />
                        	<label class="control-label">Entrer le code pr&eacute;cedent dans le champ suivant <?php echo $field_6;?></label>
                            <input type="text" name="user_captcha" class="form-control" placeholder="Code captcha" />
                        </div>
                        <div class="line line-dashed"></div>
                        <input class="btn btn-info" type="submit" value="Cr&eacute;er" />
                        <input class="btn btn-danger" type="reset" value="Annuler" />
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->core->url->site_url(array('login'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="fa fa-signin text"></i> <span class="text">Ouvrir un compte</span> <i class="fa fa-ok text-active"></i></a>
                    </form>
                </section>                
            </div>
        </div>
    </section>