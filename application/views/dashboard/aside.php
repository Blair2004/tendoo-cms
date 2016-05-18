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
    <?php echo $this->events->apply_filters('before_dashboard_menu', '');?>
    <!-- search form -->
    <!-- 
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..."/>
        <span class="input-group-btn">
        <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span> </div>
    </form>
    -->
    <!-- /.search form --> 
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
	<?php Menu::load(); ?>
    </ul>
  </section>
  <!-- /.sidebar --> 
</aside>
