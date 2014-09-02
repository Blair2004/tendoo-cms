<?php echo $smallHeader;?>

<footer class="footer bg-white b-t">
    <div class="row m-t-sm text-center-xs">
        <div class="col-sm-2" id="ajaxLoading"> </div>
        <div class="col-sm-4 col-sm-offset-6 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
            </ul>
        </div>
    </div>
</footer>
<section class="wrapper scrollable bg-light lt">
    <div class="panel-content">
        <div class="wrapper scrollable"> <?php echo output('notice');?> <?php echo fetch_error_from_url();?> <?php echo validation_errors();?>
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel">
                        <div class="panel-heading"> Donn&eacute;es personnelles </div>
                        <form method="post" class="panel-body">
                            <div class="form-group">
                                <label class="label-control">Nom :</label>
                                <input class="form-control" type="text" placeholder="Nom" name="user_name" value="<?php echo current_user('NAME');?>" />
                            </div>
                            <div class="form-group">
                                <label class="label-control">Pr&eacute;nom :</label>
                                <input class="form-control" type="text" placeholder="Pr&eacute;nom" name="user_surname" value="<?php echo current_user('SURNAME');?>"/>
                            </div>
                            <div class="line line-dashed"></div>
                            <input class="btn btn-white" type="submit" value="Enregistrer" />
                        </form>
                    </div>
                    <div class="panel">
                        <div class="panel-heading"> Donn&eacute;es de localisation </div>
                        <form method="post" class="panel-body">
                            <div class="form-group">
                                <label class="label-control">Pays :</label>
                                <input class="form-control" type="text" placeholder="Pays" name="user_state" value="<?php echo current_user('STATE');?>" />
                            </div>
                            <div class="form-group">
                                <label class="label-control">Ville :</label>
                                <input class="form-control" type="text" placeholder="Ville" name="user_town" value="<?php echo current_user('TOWN');?>" />
                            </div>
                            <div class="line line-dashed"></div>
                            <input class="btn btn-white" type="submit" value="Enregistrer" />
                        </form>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-heading"> Profils & Réseau sociaux </div>
                        <div class="panel-body">
                            <form method="post" class="form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-3"> <img src="<?php echo current_user('AVATAR');?>" alt="<?php echo current_user('PSEUDO');?>_avatar" style="width:100px;border-radius:50px;overflow:hidden;border:solid 2px #999;box-shadow:0px 0px 5px #CCC;"> </div>
                                    <div class="col-lg-9"> <?php echo tendoo_info('Envoyez votre image dont les dimensions de doivent pas excéder 300px, en largeur et en hauteur.');?>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="avatar_file">
                                            <span class="input-group-addon">
                                            <input class="btn <?php echo theme_button_class();?>" type="radio" name="avatar_usage" value="system" checked
                                            <?php 
											if(current_user('AVATAR_TYPE') == 'system')
											{
												echo "checked";												
											}
											?>
>
                                            </span> </div>
                                        <?php
										  if(true == false)
										  {
										  ?>
                                        <br>
                                        <?php echo tendoo_info('Souhaitez-vous partager votre profil facebook, google+ ou twitter ? Entrez l\'adresse de votre profile.<br><br> Si vous souhaitez utiliser l\'avatar de votre profil, veuillez selectionner le réseau social dont vous souhaitez utiliser l\'avatar.');?> <span class="input-group-btn">
                                        <button fb_log class="btn <?php echo theme_button_class();?>" type="button"><i class="fa fa-facebook"></i> - Ajouter mon facebook</button>
                                        </span> <br>
                                        <div class="input-group"> <span class="input-group-btn">
                                            <button class="btn <?php echo theme_button_class();?>" type="button"><i class="fa fa-facebook"></i> - Ajouter mon facebook</button>
                                            </span>
                                            <input type="text" class="form-control" name="facebook_profile" value="<?php echo current_user('FACEBOOK_PROFILE');?>">
                                            <span class="input-group-addon">
                                            <input class="btn <?php echo theme_button_class();?>" type="radio" name="avatar_usage" value="facebook" <?php 
											if(current_user('AVATAR_TYPE') == 'facebook')
											{
												echo "checked";												
											}
											?>>
                                            </span> </div>
                                        <br>
                                        <div class="input-group"> <span class="input-group-btn">
                                            <button class="btn <?php echo theme_button_class();?>" type="button"><i class="fa fa-google-plus"></i></button>
                                            </span>
                                            <input type="text" class="form-control" name="google_profile" value="<?php echo current_user('GOOGLE_PROFILE');?>">
                                            <span class="input-group-addon">
                                            <input class="btn <?php echo theme_button_class();?>" type="radio" name="avatar_usage" value="google" <?php 
											if(current_user('AVATAR_TYPE') == 'google')
											{
												echo "checked";												
											}
											?>>
                                            </span> </div>
                                        <br>
                                        <div class="input-group"> <span class="input-group-btn">
                                            <button class="btn <?php echo theme_button_class();?>" type="button"><i class="fa fa-twitter"></i></button>
                                            </span>
                                            <input type="text" class="form-control" name="twitter_profile" value="<?php echo current_user('TWITTER_PROFILE');?>">
                                            <span class="input-group-addon">
                                            <input class="btn <?php echo theme_button_class();?>" type="radio" name="avatar_usage" value="twitter" <?php 
											if(current_user('AVATAR_TYPE') == 'twitter')
											{
												echo "checked";												
											}
											?>>
                                            </span> </div>
                                        <?php
										  }
										?>
                                    </div>
                                    <div class="col-lg-12">
                                        <hr class="line line-dashed">
                                        <input class="btn btn-white" value="Modifier" type="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">Modifier le thème</div>
                        <form fjaxson method="post" class="panel-body" action="<?php echo $this->instance->url->site_url(array('account','ajax','setTheme'));?>">
                            <div class="form-group">
                                <label class="label-control">Modifier le thème du système</label>
                                <select class="form-control" name="theme_style">
                                    <option value="">Choisir le thème</option>
                                    <option value="0" <?php if((int)$this->instance->users_global->current('ADMIN_THEME') == 0): ?> selected="selected"<?php endif;?> >Inverse Theme</option>
                                    <option value="1" <?php if((int)$this->instance->users_global->current('ADMIN_THEME') == 1): ?> selected="selected"<?php endif;?>>Bubbles Showcase</option>
                                    <option value="2" <?php if((int)$this->instance->users_global->current('ADMIN_THEME') == 2): ?> selected="selected"<?php endif;?>>Green Day</option>
                                    <option value="3" <?php if((int)$this->instance->users_global->current('ADMIN_THEME') == 3): ?> selected="selected"<?php endif;?>>Red Horn</option>
                                    <option value="4" <?php if((int)$this->instance->users_global->current('ADMIN_THEME') == 4): ?> selected="selected"<?php endif;?>>Selective Orange</option>
                                    <option value="5" <?php if((int)$this->instance->users_global->current('ADMIN_THEME') == 5): ?> selected="selected"<?php endif;?>>Skies</option>
                                    <option value="6" <?php if((int)$this->instance->users_global->current('ADMIN_THEME') == 6): ?> selected="selected"<?php endif;?>>Blurry</option>
                                </select>
                            </div>
                            <div class="line line-dashed"></div>
                            <input class="btn btn-white" type="submit" value="Enregistrer" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading"> Informations de s&eacute;curit&eacute; </div>
                        <form fjaxson method="post" class="panel-body" action="<?php echo $this->instance->url->site_url(array('account','ajax','setPassword'));?>">
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
                </div>
                <div class="col-lg-6">
                	<div class="panel">
                    	<div class="panel-heading">Ma bio</div>
                        <form fjaxson method="post" class="panel-body" action="<?php echo $this->instance->url->site_url(array('account','ajax','set_user_meta'));?>">
                            <div class="form-group">
                            	<input type="hidden" name="key" value="user_bio">
                                <textarea name="value" rows="10" class="form-control"><?php echo current_user( 'BIO' );?></textarea>
                            </div>
                            <div class="line line-dashed"></div>
                            <input class="btn btn-white" type="submit" value="Enregistrer" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
