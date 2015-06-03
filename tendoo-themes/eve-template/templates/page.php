<?php
$page	=	get_core_vars( 'page' );
?>
<!--start wrapper-->

<section class="wrapper">
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><?php echo get_page( 'title' );?></h2>
                    <?php get_breads();?>
                </div>
            </div>
        </div>
    </section>
    <section class="content blog">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="blog_medium"> <?php echo get_active_theme_vars( 'page_content' );?> </div>
                </div>
                
                <!--Sidebar Widget-->
                <?php $this->sidebar_right();?>
            </div>
            <!--/.row--> 
        </div>
        <!--/.container--> 
    </section>
</section>
<!--end wrapper-->