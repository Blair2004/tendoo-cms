<?php echo get_core_vars( 'lmenu' );?>

<section id="content" adminIndexIntro>
    <section class="vbox"><?php echo get_core_vars( 'inner_head' );?>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-2" id="ajaxLoading"> </div>
                <div class="col-sm-4 col-sm-offset-6 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                    </ul>
                </div>
            </div>
        </footer>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/apprendre/le-panneau-de-configuration/accueil" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </header>
            <section class="scrollable wrapper"> <?php echo fetch_error_from_url();?> 
                <!-- data-toggle="tooltip" data-placement="right" title="" data-original-title="Statistiques sur le traffic de votre site." -->
				<div class="row">
                	<?php ouput_admin_widgets();?>
                </div>
            </section>
        </section>
    </section>
    <a class="hide nav-off-screen-block" data-target="body" data-toggle="class:nav-off-screen" href="#"></a> 
</section>