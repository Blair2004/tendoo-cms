<aside class="<?php echo theme_class();?> aside-sm <?php echo get_user_data( 'admin-left-menu-status' );?>" id="nav" data-intro="Accédez à différents emplacements à l'aide de ce menu." data-step="2" data-position="right">
    <section class="vbox">
        <header class="dker nav-bar"> 
        	<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body"> 
            	<i class="fa fa-reorder"></i> 
			</a> 
            <span href="#" class="nav-brand <?php echo theme_class();?>">
            	<img style="max-height:30px;" src="<?php echo $this->instance->url->img_url('logo_minim.png');?>" alt="logo">
            </span> 
            <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user"> 
            	<i class="fa fa-comment-alt"></i>
			</a> 
		</header>
        <?php
		$redirective	=	urlencode($this->instance->url->request_uri());
		?>
		<!-- <?php echo $this->instance->url->site_url(array('logoff','tologin?ref='.$redirective));?> TO LOGIN REDIR -->
        <footer class="footer bg-gradient hidden-xs"> 
			<a data-intro="Cliquez-ici pour ouvrir la fenêtre des applications installées. Utilisez cette fenêtre pour rapidment accéder aux différentes applications." data-step="10" data-position="top" href="javascript:void(0)" class="showAppTab btn btn-sm pull-right"> 
				<i class="fa fa-th-large"></i> 
			</a> 
			<a href="#nav" data-toggle="class:nav-vertical" class="btn btn-sm btn-link m-l-n-sm"> 
				<i class="fa fa-arrows-h"></i> 
			</a> 
		</footer>
        <section>
		<?php 
		if(get_core_vars( 'tendoo_core_update' ) !== FALSE)
		{
			$ttNotice	=	0;
			foreach(get_core_vars( 'tendoo_core_update' ) as $global_notices)
			{
				$ttNotice +=	count($global_notices);
			}
		?>
			<nav class="nav-primary hidden-xs">
                <ul class="nav">					
                    <li class="openUpdateinstanceNotification"> 
						<a href="javascript:void(0)"> 
							<i class="fa fa-gift"></i> <span>tengoo.org</span> 
							<div class="nav-msg"> 
								<!-- class="dropdown-toggle" data-toggle="dropdown" -->
								<?php 
								if($ttNotice > 0)
								{
								?>
								<a href="javascript:void(0)">
									<b class="badge badge-white count-n"><?php echo $ttNotice;?></b> 
								</a> 
								<section class="dropdown-menu m-l-sm pull-left animated fadeInRight"> 
									<div class="arrow left"></div> 
									<section class="panel bg-white"> 
										<header class="panel-heading"> 
											<strong>Vous avez <span class="count-n"><?php echo $ttNotice;?></span> notification(s)</strong> 
										</header> 
										<div class="list-group"> 
											<?php
											foreach(get_core_vars( 'tendoo_core_update' ) as $global_notices)
											{
												foreach($global_notices as $unique_notice)
												{
												?>
												<a href="<?php echo $unique_notice['link'];?>" class="media list-group-item">
													<?php 
													if($unique_notice['thumb'] != false)
													{
													?>
													<span class="pull-left thumb-sm"> 
														<img src="<?php echo $unique_notice['thumb'];?>" alt="image" class="img-circle"> 
													</span> 
													<?php
													}
													?>
													<span class="media-body block m-b-none"><strong><?php echo word_limiter($unique_notice['title'],6);?></strong><br> 
														<?php echo word_limiter($unique_notice['content'],20);?><br>
														<small class="text-muted"><?php echo $unique_notice['date'];?></small> 
													</span> 
												</a>
												<?php
												}
											}
											?>
										</div>
									</section>
								</section>
								<?php
								}
								?>
							</div>
						</a>
					</li>
				</ul>
			</nav>
			<script type="text/javascript">
				$(document).ready(function(){
					var canMouseLeave	=	true;
					$('.openUpdateinstanceNotification').mouseleave(function(){
						$(document).bind('click',function(){
							if($('.openUpdateinstanceNotification').attr('expecting-close-after-leaving') == 'true')
							{
								$('.openUpdateinstanceNotification').find('.nav-msg').toggleClass('open');
								$('.openUpdateinstanceNotification').removeAttr('expecting-close-after-leaving');
							}
						});
					});
					$('.openUpdateinstanceNotification').bind('click',function(event){
						event.stopImmediatePropagation();
						$(this).find('.nav-msg').toggleClass('open');
						$(this).attr('expecting-close-after-leaving','true');
					});
				});
			</script>
		<?php
		}
		?>
			<nav class="nav-primary hidden-xs">
                <ul class="nav">
                	<?php echo get_admin_left_menus();?>					
					<?php // $this->instance->tendoo_admin->parseMenuBefore();?>
                    <li> <a data-intro="Accédez à cet emplacement pour créer des pages et affecter des modules ou un lien." data-step="3" data-position="right" href="<?php echo $this->instance->url->site_url('admin/controllers');?>"> <i class="fa fa-bookmark"></i> <span>Contrôleurs</span> </a>                    </li>
                    
                    <li class="dropdown-submenu" data-intro="Accédez à cet emplacement pour installer de nouvelles applications, gérer les modules et les thèmes déjà installés." data-step="4" data-position="right"> <a href="<?php echo $this->instance->url->site_url('admin/installer');?>"> <i class="fa fa-flask"></i> <span>Installer</span> </a>
                    </li>
                    <li data-intro="Accédez à cet emplacement pour gérer les modules installés." data-step="5" data-position="right"><a href="<?php echo $this->instance->url->site_url('admin/modules');?>"> <i class="fa fa-puzzle-piece"></i> <span>Modules</span> </a>
                    </li>
                    <li data-intro="Accédez à cet emplacement pour gérer les thèmes installés." data-step="6" data-position="right"><a href="<?php echo $this->instance->url->site_url('admin/themes');?>"> <i class="fa fa-columns"></i> <span>Thèmes</span> </a>
                    </li>
					<li data-intro="Accédez à cet emplacement pour configurer les informations de base du site, les autorisations et la sécurité (Espace sécurité reservé au super administrateur)." data-step="7" data-position="right"> <a href="<?php echo $this->instance->url->site_url('admin/setting');?>"> <!--<b class="badge bg-danger pull-right">3</b>--> <i class="fa fa-cogs"></i> <span>Param&egrave;tres</span> </a> </li>
                    <?php
					if($this->instance->users_global->current('PRIVILEGE') == 'NADIMERPUS')
					{
					?>
                    <li class="dropdown-submenu" data-intro="Accédez à cet emplacement pour gérer les utilisateurs, les actions, les privilèges et opérer restauration du site. (Privilège super administrateur requis)." data-step="8" data-position="right"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-wrench"></i> <span>Syst&egrave;me</span> </a> 
                        <ul class="dropdown-menu">
                        	<li> <a href="<?php echo $this->instance->url->site_url('admin/system');?>">&Agrave; propos de Tendoo</a> </li>
                            <li><a href="<?php echo $this->instance->url->site_url('admin/system/adminMain');?>">Gestion des utilisateurs</a></li>
                            <li><a href="<?php echo $this->instance->url->site_url('admin/system/createAdmin');?>">Cr&eacute;er un utilisateur</a></li>
                            <li> <a href="<?php echo $this->instance->url->site_url('admin/system/privilege_list');?>">Listes des privil&egrave;ges</a> </li>
                            <li> <a href="<?php echo $this->instance->url->site_url('admin/system/create_privilege');?>">Cr&eacute;er un privil&egrave;ge</a> </li>
                            <li> <a href="<?php echo $this->instance->url->site_url('admin/system/manage_actions');?>">Gestionnaire d'actions</a> </li>
                            <!--<li> <a href="<?php echo $this->instance->url->site_url('admin/system/restore/soft');?>">Restauration souple</a> </li>                -->            
                        </ul>
                    </li>
                    <?php
					}
					?>
                    <li> <a target="_top _blank" data-intro="Après avoir finis vos configurations, cliquez sur ce lien pour accéder à l'interface publique de votre site web." data-step="9" data-position="right" href="<?php echo $this->instance->url->site_url('index');?>"> <i class="fa fa-sign-out"></i> <span>Retour</span> </a> </li>
                    
					<?php $this->instance->tendoo_admin->parseMenuAfter();?>
                </ul>
            </nav>
        </section>
    </section>
</aside>