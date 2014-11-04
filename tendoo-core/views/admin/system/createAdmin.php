<?php echo get_core_vars( 'inner_head' );?>

<section id="content">
<section class="hbox stretch">
    <?php echo get_core_vars( 'lmenu' );?>
    <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted">
                            <?php echo get_page('description');?>
                        </p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/comment-creer-un-utilisateur" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i> </a>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f">
                    <?php echo output('notice');?> <?php echo validation_errors();?> <?php echo fetch_error_from_url();?>
                    <div class="row">
                        <div class="col-lg-8">
                            <section class="panel">
                                <header class="panel-heading text-center"> Cr&eacute;er un utilisateur </header>
                                <form method="post" class="panel-body">
                                    <div class="form-group">
                                        <label class="label-control">Pseudo</label>
                                        <input type="text" class="form-control" name="admin_pseudo" placeholder="Pseudo" />
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control">Mot de passe</label>
                                        <input type="password" class="form-control" name="admin_password" placeholder="Mot de passe"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control">Confirmer le mot de passe</label>
                                        <input type="password" class="form-control" name="admin_password_confirm" placeholder="Confirmer le mot de passe"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control">Email</label>
                                        <input type="text" class="form-control" name="admin_password_email" placeholder="Email"/>
                                    </div>
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
                                            <option value="RELPIMSUSE">Utilisateur</option>
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
                                    <input class="btn btn-sm <?php echo theme_button_class();?>" type="submit" value="Cr&eacute;er" />
                                    <input type="reset" class="btn btn-sm btn-danger" value="Annuler" />
                                </form>
                            </section>
                        </div>
                        <div class="col-lg-4">
                            <?php
$field_1	=	(form_error('admin_pseudo')) ? form_error('admin_pseudo') : 'L\'utilisateur doit avoir un pseudo unique.<br>';
$field_2	=	(form_error('admin_password')) ? form_error('admin_password') : 'L\'adresse email de l\'utilisateur sera utilis&eacute; pour la récupération du mot de passe.<br>';
$field_3	=	(form_error('admin_password_confirm')) ? form_error('admin_password_confirm') : 'Choisir un privil&egrave;ge c\'est classer cet utilisateur dans un groupe disposant d\'action.<br>';
$field_6	=	(form_error('admin_password_email')) ? form_error('admin_password_email') : 'Email.';
$field_4	=	(form_error('admin_sex')) ? form_error('admin_sex') : '';
$field_5	=	(form_error('admin_privilege')) ? form_error('admin_privilege') : '';
?>
                            <section class="panel">
                                <header class="panel-heading text-center"> Plus d'information </header>
                                <div class="wrapper">
                                    <?php if(strlen($field_1) > 0):;?>
                                    <?php echo $field_1; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_2) > 0):;?>
                                    <?php echo $field_2; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_3) > 0):;?>
                                    <?php echo $field_3; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_4) > 0):;?>
                                    <?php echo $field_4; ?>
                                    <?php endif;?>
                                    <?php if(strlen($field_5) > 0):;?>
                                    <?php echo $field_5; ?>
                                    <?php endif;?>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
                <footer class="footer bg-white b-t">
                    <div class="row m-t-sm text-center-xs">
                        <div class="col-sm-2" id="ajaxLoading">
                        </div>
                        <div class="col-sm-10 text-right text-center-xs">
                            <input controller_save_edits type="button" data-dismiss="modal" class="btn btn-sm <?php echo theme_class();?>" value="Sauvegardez vos modifications">
                        </div>
                    </div>
                </footer>
            </section>
        </section>
    </section>
</section>
