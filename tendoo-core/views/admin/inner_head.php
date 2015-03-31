<header class="main-header">
    <a href="<?php echo get_instance()->url->site_url( array( 'admin' ) );?>" class="logo" id="tendoo-admin-logo"><img style="height:40px;" src="<?php echo img_url( 'logo_minim.png' );?>" alt="<?php echo get( 'version' );?>" id="admin-logo-image" /></a>
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
			<?php if( true == false ): // DISABLED ?>
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
          <?php endif;?>
          <!-- Notifications: style can be found in dropdown.less -->
          <?php
		  $count_admin_notices	=	count( $admin_notices	=	get_instance()->admin_notices->get( 'info' ) );
		  ?>
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <?php if( ( int ) $count_admin_notices > 0 && $admin_notices !==  FALSE )
			  {
				  ?>
              <span class="label label-warning"><?php echo $count_admin_notices;?></span>
              	<?php
			  }
			  ?>
            </a>
            <ul class="dropdown-menu">
            	<?php if( ( int ) $count_admin_notices > 0 && $admin_notices !==  FALSE )
			  {
				  ?>
              <li class="header"><?php echo sprintf( translate( 'You got %s notifications' ) , $count_admin_notices );?></li>
              <?php
			  }
			  else
			  {
				  ?>
                  <li class="header"><?php _e( 'Nothing to display right now' );?></li>
                  <?php
			  }
			  ?>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                	<?php foreach( force_array( $admin_notices ) as $notice )
					{
						?>
                  <li>
                    <a href="<?php echo riake( 'link' , $notice );?>">
                      <i class="fa <?php echo riake( 'icon' , $notice );?> text-aqua"></i> <?php echo riake( 'message' , $notice );?>
                    </a>
                  </li>
                  <?php
					}
				  ?>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <?php if( true == false ): // DISABLED ?>
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
          <?php endif;?>
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