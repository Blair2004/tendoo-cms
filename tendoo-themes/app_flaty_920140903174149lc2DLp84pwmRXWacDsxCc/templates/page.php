<?php
$page	=	get_core_vars( 'page' );
?>
<section id="title" class="emerald" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1><?php echo get_page( 'title' );?></h1>
                <p><?php echo $page[0]['PAGE_DESCRIPTION'];?></p>
            </div>
            <?php get_breads();?>
        </div>
    </div>
</section>
<section id="blog" class="container" style="padding-top:50px;">
    <div class="row">
        <?php $this->sidebar_right();?>
        <div class="col-sm-8 col-sm-pull-4">
            <div class="blog">
                <?php echo get_active_theme_vars( 'page_content' );?>
            </div>
        </div>
        <!--/.col-md-8--> 
    </div>
    <!--/.row--> 
</section>
<?php $this->sidebar_bottom();?>
