<body>
<?php echo current_user("menu"); ?>
<?php echo get_core_vars( 'theme_header' );?>
<div class="container" <?php if( current_user()->isConnected() ) { ?> style="margin-top:120px; <?php } else { ?> style="margin-top:60px;" <?php };?>">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="span9">
				<?php echo get_core_vars( 'module_content' );?>        
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php $this->sidebar_right();?>

        </div>
        <!-- /.row -->

        <hr>
    </div>
<?php echo get_core_vars( 'theme_footer' );?>
</body>
</html>