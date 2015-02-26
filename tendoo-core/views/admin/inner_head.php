<header class="main-header">
    <a href="<?php echo get_instance()->url->site_url( array( 'admin' ) );?>" class="logo"><img style="height:40px;" src="<?php echo img_url( 'logo_minim.png' );?>" alt="<?php echo get( 'version' );?>" /></a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li><!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li><!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo current_user('avatar_link');?>" class="user-image" alt="User Image"/>
              <span class="hidden-xs"><?php echo sprintf( __( 'Hello, %s' ) , ucwords($this->instance->users_global->current('PSEUDO')) );?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo current_user('avatar_link');?>" class="img-circle" alt="User Image" />
                <p>
                 <?php echo sprintf( __( 'Hello, %s' ) , ucwords($this->instance->users_global->current('PSEUDO')) );?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!--
              <li class="user-body">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </li>
              -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $this->instance->url->site_url(array('admin','profile'));?>" class="btn btn-default btn-flat"><?php _e( 'Profile' );?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $this->instance->url->site_url(array('logoff?ref=' . urlencode( $this->instance->url->site_url() ) ));?>" class="btn btn-default btn-flat"><?php _e( 'Sign out' );?></a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
<?php
return;
?>
<header class="header">
    <a href="../index.html" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Tendoo
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-left">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <?php 
				if( true == false ): // ignore this
				?>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <div style="position: relative; overflow: hidden; width: auto; height: 200px;" class="slimScrollDiv"><ul style="overflow: hidden; width: 100%; height: 200px;" class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img do="/img/avatar3.png" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li><!-- end message -->
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img do="/img/avatar2.png" class="img-circle" alt="user image">
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img do="/img/avatar.png" class="img-circle" alt="user image">
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img do="/img/avatar2.png" class="img-circle" alt="user image">
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img do="/img/avatar.png" class="img-circle" alt="user image">
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul><div style="background: none repeat scroll 0% 0% rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px;" class="slimScrollBar"></div><div style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: none repeat scroll 0% 0% rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <!-- Notifications: style can be found in dropdown.less -->
                <?php 
				if( current_user()->isAdmin() ):			
					$sysNot			=	$this->instance->tendoo_admin->get_sys_not();
					$ttSystNot		=	count($sysNot);
	            ?>
                <li class="dropdown notifications-menu pull-left">
                	<?php 
					if($ttSystNot > 0)
					{
						?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-warning"></i>
                        <span class="label label-warning"><?php echo $ttSystNot;?></span>
                    </a>
					<?php
					}
					?>
                    <ul class="dropdown-menu">
                        <li class="header"><?php echo sprintf( __( 'You have %s notification(s)' ) , $ttSystNot );?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <div style="position: relative; overflow: hidden; width: auto; height: 200px;" class="slimScrollDiv"><ul style="overflow: hidden; width: 100%; height: 200px;" class="menu">
                            <?php
                        if($ttSystNot > 0)
                        {
                            foreach($sysNot as $s)
                            {
                        ?>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-info"></i> <?php echo riake( 'TITLE' , $s );?>
                                        <!-- <p style="width:50%;display:block;"><?php echo riake( 'CONTENT' , $s );?></p>-->
                                    </a>
                                </li>
							<?php
                            }
						}
						else
						{
							?>
                            <li>
                                <a href="#">
                                    <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                </a>
                            </li>
                            <?php
						}
                        ?>
                            </ul><div style="background: none repeat scroll 0% 0% rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px;" class="slimScrollBar"></div><div style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: none repeat scroll 0% 0% rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <?php endif;?>
                
                <?php 
				if( true == false ): // ignore this
				?>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-tasks"></i>
                        <span class="label label-danger">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <div style="position: relative; overflow: hidden; width: auto; height: 200px;" class="slimScrollDiv"><ul style="overflow: hidden; width: 100%; height: 200px;" class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Create a nice theme
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Some task I need to do
                                            <small class="pull-right">60%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Make beautiful transitions
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                            </ul><div style="background: none repeat scroll 0% 0% rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px;" class="slimScrollBar"></div><div style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: none repeat scroll 0% 0% rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;" class="slimScrollRail"></div></div>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>Jane Doe <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img do="/img/avatar3.png" class="img-circle" alt="User Image">
                            <p>
                                Jane Doe - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php endif;?>
            </ul>
        </div>
    </nav>
</header>

<?php
return;
$options	=	get_core_vars( 'options' ); ?>

<header id="headish" class="header navbar pull-in <?php echo theme_class();?>">
    <div class="navbar-header nav-bar aside">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body"> <i class="fa fa-reorder"></i> </a> <span href="#" class="nav-brand <?php // echo theme_class();?>"> <img style="max-height:30px;" src="<?php echo $this->instance->url->img_url('logo_minim.png');?>" alt="logo"> </span> <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user"> <i class="fa fa-comment-alt"></i> </a>
    </div>
    <?php if( current_user()->isAdmin() ):?>
    <div class="collapse navbar-collapse pull-in">
    	<ul class="nav navbar-nav">
        	<?php
            $sysNot			=	$this->instance->tendoo_admin->get_sys_not();
            $ttSystNot		=	count($sysNot);
            ?>
            <li class="hidden-xs"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell text-white"></i>
                
                </a>
                <section class="dropdown-menu animated fadeInUp input-s-lg">
                    <section class="panel bg-white">
                        <header class="panel-heading"> <strong><?php echo translate( 'You got' );?> : <span class="count-n"><?php echo $ttSystNot;?></span> <?php _e( 'Notice(s)' );?></strong> </header>
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
                            <span class="pull-left thumb-sm"> <img src="<?php echo $s['THUMB'];?>" class="img-circle"> </span>
                            <?php
                                }
                                ?>
                            <span class="media-body block m-b-none"><?php echo $s['TITLE'];?><br>
                            <small class="text-muted"><?php echo $s['CONTENT'];?></small> </span> </a>
                        </div>
                        <?php
                            }
                        ?>
                        <!-- <footer class="panel-footer text-sm"><a href="#" class="pull-right"><i class="fa fa-cog"></i></a> <a href="#">See all the notifications</a> </footer> -->
                        <?php
                        }
                        else
                        {
                            ?>
                        <div class="list-group">
                            <a href="#" class="media list-group-item"> <span class="media-body block m-b-none"><?php _e( 'There is nothing to display now...' );?></span> </a>
                        </div>
                        <?php
                        }
                        ?>
                    </section>
                </section>
            </li>
            <?php if( is_enabled( 'tools' ) ):?>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus-sign-alt"></i> <?php _e( 'Tools' );?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/stats');?>"><?php echo translate( 'Stats' );?></a> </li>
                    <!-- <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/calendar');?>"><?php echo translate( 'Calendar' );?></a> </li>-->
                    <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/seo');?>"><?php echo translate( 'Seo' );?></a> </li>
                    <!--<li> <a href="<?php echo $this->instance->url->site_url('admin/tools/filExplorer');?>">Explorateur de fichiers</a> </li>-->
                </ul>
            </li>
            <?php endif;?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left m-t-n-xs m-r-xs">  </span> <?php echo ucwords($this->instance->users_global->current('PSEUDO'));?>,  <b class="caret"></b> </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li> <a href="<?php echo $this->instance->url->site_url(array('admin','profile'));?>"><?php _e( 'Profile' );?></a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url(array('admin','about'));?>"><?php _e( 'About' );?></a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url(array('logoff?ref=' . urlencode( $this->instance->url->site_url() ) ));?>"><?php _e( 'Sign out' );?></a> </li>
                </ul>
            </li>
        </ul>
    </div>
    <?php endif;?>
</header>
