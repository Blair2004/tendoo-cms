<aside class="<?php echo theme_class();?> aside dk <?php // echo get_user_meta( 'admin-left-menu-status' );?>" id="nav">
    <section class="vbox">
        <?php
		$redirective	=	urlencode($this->instance->url->request_uri());
		?>
		<!-- <?php echo $this->instance->url->site_url(array('logoff','tologin?ref='.$redirective));?> TO LOGIN REDIR -->
        <section class="scrollable">
        	<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px">
			<?php 
			// count( get_core_vars( 'tendoo_core_update' ) ) > 0  && is_array( get_core_vars( 'tendoo_core_update' ) )
            if( true == false ) // Disabled for 1.4
            {
                $ttNotice	=	0;
                $ttNotice	=	count( get_core_vars( 'tendoo_core_update' ) );
            ?>
            <nav class="nav-primary hidden-xs" data-ride="collapse">
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
			<nav class="nav-primary hidden-xs" data-ride="collapse">
                <ul class="nav">
                	<?php 
					show_admin_menu( 'before' , 'menu' );					
					
					show_admin_menu( 'before' , 'dashboard' );
					get_instance()->menu->get_admin_menu_core( 'dashboard' );
					show_admin_menu( 'after' , 'dashboard' );
					
					if( riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'website' )
					{
					  	show_admin_menu( 'before' , 'controllers' );
						get_instance()->menu->get_admin_menu_core( 'controllers' );
						show_admin_menu( 'after' , 'controllers' );
					}
					
					show_admin_menu( 'before' , 'installer' );
					get_instance()->menu->get_admin_menu_core( 'installer' );
					show_admin_menu( 'after' , 'installer' );
					
					show_admin_menu( 'before' , 'modules' );
                    get_instance()->menu->get_admin_menu_core( 'modules' );
                    show_admin_menu( 'after' , 'modules' );
					
					if( riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'website' )
					{						
						show_admin_menu( 'before' , 'themes' );
						get_instance()->menu->get_admin_menu_core( 'themes' );
						show_admin_menu( 'after' , 'themes' );
					}
					
					show_admin_menu( 'before' , 'users' );
					get_instance()->menu->get_admin_menu_core( 'users' );
					show_admin_menu( 'after' , 'users' );

					show_admin_menu( 'before' , 'roles' );
					get_instance()->menu->get_admin_menu_core( 'roles' );
					show_admin_menu( 'after' , 'roles' );
				
					show_admin_menu( 'before' , 'settings' );
					get_instance()->menu->get_admin_menu_core( 'settings' );
					show_admin_menu( 'after' , 'settings' );

					if( riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'website' )
					{
						show_admin_menu( 'before' , 'frontend' );
						get_instance()->menu->get_admin_menu_core( 'frontend' );
						show_admin_menu( 'after' , 'frontend' );
					}
					
					show_admin_menu( 'before' , 'about' );
                   	get_instance()->menu->get_admin_menu_core( 'about' );
                    show_admin_menu( 'after', 'about' );
					
                    show_admin_menu( 'after' , 'menu' );
					?>
                </ul>
            </nav>
            </div>
        </section>
        <footer class="footer bg-gradient hidden-xs"> 
		</footer>
    </section>
</aside>