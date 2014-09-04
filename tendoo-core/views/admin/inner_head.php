<?php
$options	=	get_core_vars( 'options' );
if($this->instance->users_global->current('ADMIN_THEME') == 1)
{
?>
		<div id="canvasBubbles" class="bg-light dk">           
        </div>
        <style type="text/css">
		/* Large devices (large desktops, 1200px and up) */
		@media (min-width: 1200px) {
			#canvasBubbles{
				position:absolute;
				height:50px;
				width:100%;
				top:0;
			}
			#headish
			{
				position:relative !important;
			}
		}
		/* Medium devices (desktops, 992px and up) */
		@media (min-width: 992px) {
			#canvasBubbles{
				position:absolute;
				height:50px;
				width:100%;
				top:0;
			}
			#headish
			{
				position:relative !important;
			}
		}
		@media (min-width: 768px) and (max-width: 991px) {
			#canvasBubbles{
				display:none;
			}
		}
		</style>
        <?php
		}
		?>
		<header id="headish" class="header b-b <?php echo theme_class();?>">
            <div class="collapse navbar-collapse pull-in">
            	<form class="navbar-form navbar-left m-t-sm" role="search">
                    <a onclick="document.location	=	'<?php echo $this->instance->url->site_url(array('admin'));?>'" type="submit" class="btn btn-sm btn-white"><i class="fa fa-dashboard"></i> <?php echo translate( 'dashboard' );?></a>
                </form>
				<?php
				if(true == false) // NOT YET ACTIVE $options[0]['CONNECT_TO_STORE'] == "1"
				{
				?>
                <form class="navbar-form navbar-left m-t-sm" role="search">
                    <a href="javascript:void(0)" id="tendooAppStore" class="btn btn-sm btn-white"><i class="fa fa-shopping-cart"></i> <?php echo translate( 'app_store' );?></a>
                </form>
				<?php
				}
				?>
                <ul class="nav navbar-nav m-l-n" style="margin-left:10px;">
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus-sign-alt"></i> Outils <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/stats');?>"><?php echo translate( 'stats' );?></a> </li>
                            <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/calendar');?>"><?php echo translate( 'calendar' );?></a> </li>
							<li> <a href="<?php echo $this->instance->url->site_url('admin/tools/seo');?>"><?php echo translate( 'seo_tools' );?></a> </li>
							<!--<li> <a href="<?php echo $this->instance->url->site_url('admin/tools/filExplorer');?>">Explorateur de fichiers</a> </li>-->
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left m-t-sm" role="search">
                    <div class="form-group">
                        <div class="input-group input-s">
                            <input type="text" class="form-control input-sm no-border bg-white" placeholder="<?php echo translate( 'search' );?>">
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-sm btn-info btn-icon" id="toolbarSearch"><i class="fa fa-search"></i></button>
                            </span> 
						</div>
                    </div>
                </form>
                <script>
				$('#toolbarSearch').bind('click',function(){
					tendoo.notice.alert('<?php echo translate( 'unavaiable_for_this_tendoo' );?>','info');
				});
				</script>
                <ul class="nav navbar-nav navbar-right">
					<?php
                    $sysNot			=	$this->instance->tendoo_admin->get_sys_not();
                    $ttSystNot		=	count($sysNot);
                    ?>
                    <li class="hidden-xs"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell text-white"></i> 
                    	<?php 
						if($ttSystNot > 0)
						{
							?>
                    	<span class="badge up bg-info m-l-n-sm"><?php echo $ttSystNot;?></span> 
                        <?php
						}
						?></a>
                        <section class="dropdown-menu animated fadeInUp input-s-lg">
                            <section class="panel bg-white">
                                <header class="panel-heading"> 
                                	<strong><?php echo translate( 'you_got' );?> : <span class="count-n"><?php echo $ttSystNot;?></span> notification(s)</strong> 
								</header>
                                <?php
								if($ttSystNot > 0)
								{
									foreach($sysNot as $s)
									{
								?>
                                <div class="list-group"> 
                                	<a href="<?php echo $s['LINK'];?>" class="media list-group-item"> 
                                    	<?php
										if($s['THUMB'] != null)
										{
										?>
                                    	<span class="pull-left thumb-sm"> 
                                        	<img src="<?php echo $s['THUMB'];?>" class="img-circle"> 
										</span> 
                                        <?php
										}
										?>
                                        <span class="media-body block m-b-none"><?php echo $s['TITLE'];?><br>
                                    		<small class="text-muted"><?php echo $s['CONTENT'];?></small>
                                        </span> 
									</a> 
								</div>
                                <?php
									}
								?>
                                <footer class="panel-footer text-sm"> <a href="#" class="pull-right"><i class="fa fa-cog"></i></a> <a href="#">See all the notifications</a> </footer>
                                <?php
								}
								else
								{
									?>
                                <div class="list-group"> 
                                	<a href="#" class="media list-group-item"> 
                                        <span class="media-body block m-b-none"> Aucune notification disponible</span> 
									</a> 
								</div>    
                                    <?php
								}
								?>
                            </section>
                        </section>
                    </li>
                    <li data-intro="Profil, messagerie, aide et déconnexion, accédez à ces différents liens en cliquant sur ce menu déroulant." data-step="16" data-position="bottom" class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left m-t-n-xs m-r-xs"> <img src="<?php echo current_user('AVATAR');?>" alt="<?php echo ucwords(current_user('PSEUDO'));?>"> </span> <?php echo ucwords($this->instance->users_global->current('PSEUDO'));?>, <?php echo $this->instance->users_global->current('PRIVILEGE') == 'NADIMERPUS' ? 'Super administrateur' : 'Administrateur';?> <b class="caret"></b> </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li> <a href="<?php echo $this->instance->url->site_url(array('account','update'));?>">Param&ecirc;tres</a> </li>
                            <li> <a href="<?php echo $this->instance->url->site_url(array('account'));?>">Profil</a> </li>
                            <?php
							$ttMessage	=	$this->instance->users_global->getUnreadMsg();
							if($ttMessage == 0)
							{
							?>
                            <li> <a href="<?php echo $this->instance->url->site_url(array('account','messaging','home'));?>"> Messagerie </a> </li>
                            <?php
							}
							else
							{
								?>
                            <li> <a href="<?php echo $this->instance->url->site_url(array('account','messaging','home'));?>"> <span class="badge bg-danger pull-right"><?php echo $ttMessage;?></span> Messagerie </a> </li>
                            <?php
							}
							?>
                            <li> <a href="#">Aide</a> </li>
                            <li> <a href="<?php echo $this->instance->url->site_url(array('logoff'));?>">Deconnexion</a> </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>