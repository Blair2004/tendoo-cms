<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 	@details : Admin header page
 *	@role : This page page is used to displays dashboard header
 * 	@since : 1.5
 *
**/
?>
<body class="<?php echo xss_clean($this->events->apply_filters('dashboard_body_class', 'skin-blue'));?> fixed sidebar-mini" <?php echo xss_clean($this->events->apply_filters('dashboard_body_attrs', 'ng-app="tendooApp"'));?>>
    <?php echo $this->events->do_action( 'before_body_content' );?>
    <div class="wrapper">
        <header class="main-header">

            <!-- Logo -->
            <a href="<?php echo site_url(array( 'dashboard' ));?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><?php echo $this->events->apply_filters('dashboard_logo_small', $this->config->item('tendoo_logo_min'));?></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><?php echo xss_clean($this->events->apply_filters('dashboard_logo_long', $this->config->item('tendoo_logo_long')));?></span> </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas"> <span class="sr-only">Toggle navigation</span> </a>
                <?php echo $this->events->apply_filters( 'tendoo_spinner', '<div class="pull-left" id="tendoo-spinner" style="margin-top:7px;margin-left:7px"></div>' );?>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <?php $this->events->do_action('display_admin_header_menu');?>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <?php
                        // Fetch notices from filter "ui_notices".
                        $ui_notices    =    $this->events->apply_filters('ui_notices', array());

                        UI::push_notice($ui_notices);

                        // Fetch declared notices
                        $notices        =    UI::get_notices();
                        $notices_nbr    =    count($notices);

                        ?>
                        <li class="dropdown notifications-menu"> 
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                                <i class="fa fa-bell-o"></i>
                                <?php if ($notices_nbr > 0):?>
                                <span class="label label-warning"><?php echo $notices_nbr;?></span>
                                <?php endif;?>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php echo sprintf(__('You have %s notices'), count($notices));?> </li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                    <?php
                                    foreach ($notices as $notice):
                                        if ( isset($notice[ 'icon' ])) {
                                            $notice_icon    =    @$notice[ 'icon' ];
                                        } else {
                                            switch ( @$notice[ 'type' ]) {
                                                case 'success' : $notice_icon = 'thumbs-up'; break;
                                                case 'warning' : $notice_icon = 'warning'; break;
                                                default : $notice_icon = 'info-circle'; break;
                                            }
                                        }
                                    ?>
                                        <li>
                                            <a style="white-space:normal" href="<?php echo xss_clean( @$notice[ 'href' ]);?>">
                                                <i class="fa fa-<?php echo xss_clean($notice_icon);?> text-aqua"></i>
                                                <?php echo xss_clean( @$notice[ 'message' ] );?>
                                                <span
                                                    data-prefix="<?php echo @$notice[ 'prefix' ];?>"
                                                    data-namespace="<?php echo @$notice[ 'namespace' ];?>" class="btn btn-xs btn-warning pull-right remove_ui_notice">
                                                    <i class="fa fa-remove"></i>
                                                </span>
                                            </a>
                                        </li>
									<?php endforeach;?>
                                    </ul>
                                </li>
                                <!-- <li class="footer"><a href="#">View all</a></li> -->
                            </ul>
                        </li>
                        <script type="text/javascript">
                        $( document ).ready( function(){
                            $( '.remove_ui_notice' ).bind( 'click', function(e){
                                $this       =   $( this );
                                var url     =    '<?php echo site_url( array( 'rest', 'core', 'app_cache', 'clear' ) );?>/' + $( this ).attr( 'data-namespace' ) + '/' + $( this ).attr( 'data-prefix' );
                                $.ajax({
                                    url     :  url,
                                    method  :   'DELETE',
                                    success :   function(){
                                        $this.closest( 'li' ).fadeOut( 500, function(){
                                            $(this).remove();
                                        });
                                    }
                                })
                                return false;
                            })
                        })
                        </script>

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        	<img class="img-circle" alt="<?php echo $this->events->apply_filters('user_menu_card_avatar_alt', '');?>" src="<?php echo $this->events->apply_filters('user_menu_card_avatar_src', '');?>" width="20"/>
                            <span class="hidden-xs"><?php echo xss_clean($this->events->apply_filters('user_menu_name', $this->config->item('default_user_names')));?></span> </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                	<img class="img-circle" alt="<?php echo $this->events->apply_filters('user_menu_card_avatar_alt', '');?>" src="<?php echo $this->events->apply_filters('user_menu_card_avatar_src', '');?>"/>
                                    <p><?php echo xss_clean($this->events->apply_filters('user_menu_card_header', $this->config->item('default_user_names')));?></p>
                                </li>
                                <!-- Menu Body -->
                                <?php echo xss_clean($this->events->apply_filters('after_user_card', ''));?>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left"> <a href="<?php echo xss_clean($this->events->apply_filters('user_header_profile_link', '#'));?>" class="btn btn-default btn-flat"><?php _e('Profile');?></a> </div>
                                    <div class="pull-right"> <a href="<?php echo xss_clean($this->events->apply_filters('user_header_sign_out_link', site_url(array( 'sign-out' )) . '?redirect=' . urlencode(current_url())));?>" class="btn btn-default btn-flat"><?php _e('Sign Out');?></a> </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
