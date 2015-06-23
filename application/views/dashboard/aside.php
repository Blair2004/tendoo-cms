<?php
/**
 * 	File Name : aside.php
 *	Description :	hold dasboard aside section
 *	Since	:	1.4
**/
?>

<aside class="main-sidebar"> 
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar"> 
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image"> <!--<img class="img-circle" alt="user image"/>--> </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..."/>
        <span class="input-group-btn">
        <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span> </div>
    </form>
    <!-- /.search form --> 
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
	<?php
	
	/**
	 * 	Trigger before_admin_menu action in order to get defined menu
	**/

    show_admin_menu( 'before' , 'menu' );					
	
   	show_admin_menu( 'before' , 'dashboard' );
    Menu::get_admin_menu_core( 'dashboard' );
    show_admin_menu( 'after' , 'dashboard' );
    
    
    show_admin_menu( 'before' , 'media' );
    Menu::get_admin_menu_core( 'media' );
    show_admin_menu( 'after' , 'media' );
    
    // Controller menu has been deprecated
    
    show_admin_menu( 'before' , 'installer' );
    Menu::get_admin_menu_core( 'installer' );
    show_admin_menu( 'after' , 'installer' );
    
    show_admin_menu( 'before' , 'modules' );
    Menu::get_admin_menu_core( 'modules' );
    show_admin_menu( 'after' , 'modules' );
    
    if( riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'website' )
    {						
        show_admin_menu( 'before' , 'themes' );
        Menu::get_admin_menu_core( 'themes' );
        show_admin_menu( 'after' , 'themes' );
    }
    
    show_admin_menu( 'before' , 'users' );
    Menu::get_admin_menu_core( 'users' );
    show_admin_menu( 'after' , 'users' );

    show_admin_menu( 'before' , 'roles' );
    Menu::get_admin_menu_core( 'roles' );
    show_admin_menu( 'after' , 'roles' );

    show_admin_menu( 'before' , 'settings' );
    Menu::get_admin_menu_core( 'settings' );
    show_admin_menu( 'after' , 'settings' );

    if( riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'website' )
    {
        show_admin_menu( 'before' , 'frontend' );
        Menu::get_admin_menu_core( 'frontend' );
        show_admin_menu( 'after' , 'frontend' );
    }
    
    show_admin_menu( 'before' , 'about' );
    Menu::get_admin_menu_core( 'about' );
    show_admin_menu( 'after', 'about' );
    
    show_admin_menu( 'after' , 'menu' );
    ?>
    </ul>
  </section>
  <!-- /.sidebar --> 
</aside>
