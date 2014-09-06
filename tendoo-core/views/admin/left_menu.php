<aside class="<?php echo theme_class();?> aside-sm <?php echo get_user_meta( 'admin-left-menu-status' );?>" id="nav" data-intro="Accédez à différents emplacements à l'aide de ce menu." data-step="2" data-position="right">
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
		if( count( get_core_vars( 'tendoo_core_update' ) ) > 0  && is_array( get_core_vars( 'tendoo_core_update' ) ) )
		{
			$ttNotice	=	0;
			$ttNotice	=	count( get_core_vars( 'tendoo_core_update' ) );
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
								<span href="javascript:void(0)">
									<b class="badge badge-white count-n" style="right:-3px;"><?php echo $ttNotice;?></b> 
								</span> 
								<section class="dropdown-menu m-l-sm pull-left animated fadeInRight"> 
									<div class="arrow left"></div> 
									<section class="panel bg-white"> 
										<header class="panel-heading"> 
											<strong>Vous avez <?php echo $ttNotice;?> notification(s)</strong> 
										</header> 
										<div class="list-group"> 
											<?php
											if( is_array( get_core_vars( 'tendoo_core_update' ) ) ){
												foreach(get_core_vars( 'tendoo_core_update' ) as $unique_notice)
												{
													?>
													<a href="<?php echo $unique_notice['link'];?>" class="media list-group-item">
														<?php 
														if( ( $thumb	=	return_if_array_key_exists( 'thumb' , $unique_notice ) ) != false)
														{
														?>
														<span class="pull-left thumb-sm"> 
															<img src="<?php echo $thumb;?>" alt="image" class="img-circle"> 
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
                    <li> <a href="<?php echo $this->instance->url->site_url('admin/controllers');?>"> <i class="fa fa-bookmark"></i> <span>Contrôleurs</span> </a>                    </li>
                    
                    <li class="dropdown-submenu"> <a href="<?php echo $this->instance->url->site_url('admin/installer');?>"> <i class="fa fa-flask"></i> <span>Installer</span> </a>
                    </li>
                    <li><a href="<?php echo $this->instance->url->site_url('admin/modules');?>"> <i class="fa fa-puzzle-piece"></i> <span>Modules</span> </a>
                    </li>
                    <li><a href="<?php echo $this->instance->url->site_url('admin/themes');?>"> <i class="fa fa-columns"></i> <span>Thèmes</span> </a>
                    </li>
					<li> <a href="<?php echo $this->instance->url->site_url('admin/setting');?>"> <!--<b class="badge bg-danger pull-right">3</b>--> <i class="fa fa-cogs"></i> <span>Param&egrave;tres</span> </a> </li>
                    <?php
					if($this->instance->users_global->current('PRIVILEGE') == 'NADIMERPUS')
					{
					?>
                    <li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-wrench"></i> <span>Syst&egrave;me</span> </a> 
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
                    <li> <a target="_top _blank" href="<?php echo $this->instance->url->site_url('index');?>"> <i class="fa fa-eye"></i> <span>Retour</span> </a> </li>
                    
                </ul>
            </nav>
        </section>
    </section>
</aside>