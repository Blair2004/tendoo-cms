<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f"> 
					<?php echo $this->core->notice->parse_notice();?>
                    <?php echo $success;?>
                    <?php echo notice_from_url();?>
                    <div class="row">
                    	<div class="col-lg-8">
                        	<header class="panel-heading text-center">
                                Cr&eacute;er un contr&ocirc;leur
                            </header>
                        	<section class="panel">
                                <form method="post" class="panel-body">
                                        <div class="form-group">
                                        	<label class="label-control">Pseudo</label>
                                            <input type="text" class="form-control" name="admin_pseudo" placeholder="Pseudo" /></div>
                                        <div class="form-group">
                                        	<label class="label-control">Mot de passe</label>
                                            <input type="password" class="form-control" name="admin_password" placeholder="Mot de passe"/></div>
                                        <div class="form-group">
                                        	<label class="label-control">Confirmer le mot de passe</label>
                                            <input type="password" class="form-control" name="admin_password_confirm" placeholder="Confirmer le mot de passe"/></div>
                                        <div class="form-group">
                                        	<label class="label-control">Email</label>
                                            <input type="text" class="form-control" name="admin_password_email" placeholder="Email"/></div>
                                        <div class="form-group">
                                        	<label class="label-control">Selection du sexe</label>
                                            <select name="admin_sex" class="form-control">
                                                <option value="">Selection du sexe</option>
                                                <option value="MASC">Masculin</option>
                                                <option value="FEM">Feminin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        	<label class="label-control">Choisir un privil&egrave;ge</label>
                                            <select name="admin_privilege" class="form-control">
                                                <option class="form-control" value="">Choisir un privil&egrave;ge</option>
                                                <?php
												foreach($getPrivs as $p)
												{
													?>
                                                    <option value="<?php echo $p['PRIV_ID'];?>"><?php echo $p['HUMAN_NAME'];?></option>
                                                    <?php
												}
												?>
                                            </select>
                                        </div>
                                        <input class="btn btn-sm btn-primary" type="submit" value="Cr&eacute;er" />
                                        <input type="reset" class="btn btn-sm btn-danger" value="Annuler" />
                                    </form>
                            </section>
                        </div>
                        <div class="col-lg-4">
                        	<header class="panel-heading text-center">
                                Plus d'information
                            </header>
<?php
$field_1	=	(form_error('admin_pseudo')) ? form_error('admin_pseudo') : 'L\'utilisateur doit avoir un pseudo unique';
$field_2	=	(form_error('admin_password')) ? form_error('admin_password') : 'L\'email de l\'utilisateur sera utilis&eacute; pour la récupération du mot de passe.';
$field_3	=	(form_error('admin_password_confirm')) ? form_error('admin_password_confirm') : 'Choisir un privil&egrave;ge c\'est classer cet utilisateur dans un groupe disposant d\'action';
$field_6	=	(form_error('admin_password_email')) ? form_error('admin_password_email') : 'Email.';
$field_4	=	(form_error('admin_sex')) ? form_error('admin_sex') : '';
$field_5	=	(form_error('admin_privilege')) ? form_error('admin_privilege') : '';
?>
    						<section class="panel">
                            	<div class="wrapper">
                                	<ul>
                                    	<?php if(strlen($field_1) > 0):;?><li><?php echo $field_1; ?></li><?php endif;?>
                                        <?php if(strlen($field_2) > 0):;?><li><?php echo $field_2; ?></li><?php endif;?>
                                        <?php if(strlen($field_3) > 0):;?><li><?php echo $field_3; ?></li><?php endif;?>
                                        <?php if(strlen($field_4) > 0):;?><li><?php echo $field_4; ?></li><?php endif;?>
                                        <?php if(strlen($field_5) > 0):;?><li><?php echo $field_5; ?></li><?php endif;?>                                       
                                    </ul>
                            	</div>
                            </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
    </section>