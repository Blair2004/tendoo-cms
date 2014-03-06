    <section id="content" class="wrapper-md animated fadeInUp scrollable wrapper"> 
        <div class="row">
            <div class="col-lg-4 col-sm-offset-2">
            	<section class="panel">
                	<div class="panel-heading bg-danger text-center">Cr&eacute;er un super administrateur</div>
                	<form method="post" class="panel-body">
                        <div class="form-group text">
                        	<label class="control-label">Pseudo</label>
                            <input type="text" name="super_admin_pseudo" class="form-control" placeholder="Pseudo" />
                        </div>
                        <div class="form-group password">
                        	<label class="control-label">Mot de passe</label>
                            <input class="form-control" type="password" name="super_admin_password" placeholder="Mot de passe"/>
                        </div>
                        <div class="form-group password">
                        	<label class="control-label">Confirmer le mot de passe</label>
                            <input class="form-control" type="password" name="super_admin_password_confirm" placeholder="Confirmer le mot de passe"/>
                        </div>
                        <div class="form-group text">
                        	<label class="control-label">Email</label>
                            <input class="form-control" type="text" name="super_admin_mail" placeholder="Email"/>
                        </div>
                        <div class="form-group select">
                        	<label class="control-label">Selection du sexe</label>
                            <select class="form-control" name="super_admin_sex" laceholder="Selection du sexe">
                                <option value="">Selection du sexe</option>
                                <option value="MASC">Masculin</option>
                                <option value="FEM">Feminin</option>
                            </select>
                        </div>
                        <input class="btn btn-info" type="submit" value="Cr&eacute;er" />
                        <input class="btn btn-darken" type="reset" value="Annuler" />
                    </form>
                </section>                
            </div>
            <div class="col-lg-4">
            	<section class="panel">
                    <header class="panel-heading bg-info text-center">Pourquoi cette page ?</header>
                    <div class="panel-body">Aucun super-administrateur n'a &eacute;t&eacute; trouvé pour ce site.
                    Le super-administrateur est l'utilisateur ayant le maximum de privil&egrave;ges. Il a des attributs illimités et peut effectuer plusieurs opérations qui lui sont propre.
                    </div>
                </section>
            </div>
                    <?php
    $field_1	=	(form_error('super_admin_pseudo')) ? form_error('super_admin_pseudo') : '';
    $field_2	=	(form_error('super_admin_password')) ? form_error('super_admin_password') : '';
    $field_3	=	(form_error('super_admin_password_confirm')) ? form_error('super_admin_password_confirm') : '';
    ;
    $field_4	=	(form_error('super_admin_mail')) ? form_error('super_admin_mail') : '';
    $field_5	=	(form_error('super_admin_sex')) ? form_error('super_admin_sex') : '';
    ;
    ?>
    		<?php
			if(strlen($field_1) > 0 || strlen($field_2) > 0 || strlen($field_3) > 0 || strlen($field_4) > 0 || strlen($field_5) > 0)
			{
			?>
            <div class="col-lg-4">
            	<section class="panel">
                    <header class="panel-heading bg bg-color-red text-center">Pourquoi cette page ?</header>
                    <div class="panel-body">
                        <p style="padding:3px 0;"><?php echo $field_1; ?></p>
                        <p style="padding:3px 0;"><?php echo $field_2; ?></p>
                        <p style="padding:3px 0;"><?php echo $field_3; ?></p>
                        <p style="padding:3px 0;"><?php echo $field_4; ?></p>
                        <p style="padding:3px 0;"><?php echo $field_5; ?></p>
                    </div>
                </section>
            </div>
            <?php
			}
			?>
        </div>
    </section>