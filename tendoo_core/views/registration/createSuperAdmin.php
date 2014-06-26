    <section id="content" class="wrapper-md animated fadeInUp scrollable wrapper"> 
        <div class="row">
            <div class="col-lg-4 col-sm-offset-2">
            	<section class="panel">
                	<div class="panel-heading">Cr&eacute;er un super administrateur</div>
                	<form method="post" class="panel-body">
                        <div class="form-group text">
                        	<label class="control-label">Pseudo</label>
                            <input type="text" name="super_admin_pseudo" class="form-control" placeholder="Pseudo" />
                            <span><?php echo form_error('super_admin_pseudo');?></span>
                        </div>
                        <div class="form-group password">
                        	<label class="control-label">Mot de passe</label>
                            <input class="form-control" type="password" name="super_admin_password" placeholder="Mot de passe"/>
                            <span><?php echo form_error('super_admin_password');?></span>
                        </div>
                        <div class="form-group password">
                        	<label class="control-label">Confirmer le mot de passe</label>
                            <input class="form-control" type="password" name="super_admin_password_confirm" placeholder="Confirmer le mot de passe"/>
                            <span><?php echo form_error('super_admin_password_confirm');?></span>
                        </div>
                        <div class="form-group text">
                        	<label class="control-label">Email</label>
                            <input class="form-control" type="text" name="super_admin_mail" placeholder="Email"/>
                            <span><?php echo form_error('super_admin_mail');?></span>
                        </div>
                        <div class="form-group select">
                        	<label class="control-label">Selection du sexe</label>
                            <select class="form-control" name="super_admin_sex" laceholder="Selection du sexe">
                                <option value="">Selection du sexe</option>
                                <option value="MASC">Masculin</option>
                                <option value="FEM">Feminin</option>
                            </select>
                            <span><?php echo form_error('super_admin_sex');?></span>
                        </div>
                        <input class="btn btn-info" type="submit" value="Cr&eacute;er" />
                        <input class="btn btn-darken" type="reset" value="Annuler" />
                    </form>
                </section>                
            </div>
            <div class="col-lg-4">
            	<section class="panel">
                    <header class="panel-heading">Pourquoi cette page s'affiche ?</header>
                    <div class="panel-body">Aucun super-administrateur n'a &eacute;t&eacute; trouvé pour ce site.
                    Le super-administrateur est l'utilisateur ayant le maximum de privil&egrave;ges. Il a des attributs illimités et peut effectuer plusieurs opérations qui lui sont propre.
                    </div>
                </section>
            </div>
        </div>
    </section>