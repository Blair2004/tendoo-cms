	<!-- Site wrapper -->
	<div class="wrapper">
		<?php echo get_core_vars( 'inner_head' );?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php output( 'content-left-menu' );?>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <?php output( 'content-header' );?>
            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <?php output( 'content-cards' );?>
                <!-- /.row -->
    
                <!-- Widgets as boxes -->
                <?php output( 'content-widgets' );?>
    
                <!-- /.row -->
    
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
	</div>