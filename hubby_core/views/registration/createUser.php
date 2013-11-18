    <section id="content" class="m-t-lg wrapper-md animated fadeInUp scrollable wrapper"> 
        <div class="row">
            <div class="col-lg-6 col-sm-offset-3">
                    <?php
			$field_1	=	(form_error('user_pseudo')) ? form_error('user_pseudo') : '';
			$field_2	=	(form_error('user_password')) ? form_error('user_password') : '';
			$field_3	=	(form_error('user_password_confirm')) ? form_error('user_password_confirm') : '';
			;
			$field_4	=	(form_error('user_mail')) ? form_error('user_mail') : '';
			$field_5	=	(form_error('user_sex')) ? form_error('user_sex') : '';
			;
			?>
            	<?php echo $this->core->notice->parse_notice();?>
            	<section class="panel">
                	<header class="panel-heading bg bg-color-green text-center"><?php echo $pageTitle;?></header>
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
                        <div class="form-group select">
                        	<label class="control-label">Selection du sexe <?php echo $field_5;?></label>
                            <select class="form-control" name="user_sex">
                                <option value="">Selection du sexe</option>
                                <option value="MASC">Masculin</option>
                                <option value="FEM">Feminin</option>
                            </select>
                        </div>
                        <div class="line line-dashed"></div>
                        <input class="btn btn-info" type="submit" value="Cr&eacute;er" />
                        <input class="btn btn-danger" type="reset" value="Annuler" />
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->core->url->site_url(array('login'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="icon-signin text"></i> <span class="text">Ouvrir un compte</span> <i class="icon-ok text-active"></i></a>
                    </form>
                </section>                
            </div>
        </div>
    </section>