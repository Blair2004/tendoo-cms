<?php echo $inner_head;?>

<section id="w-f">
    <section class="hbox stretch">
        <?php echo $lmenu;?>
        <section class="vbox">
            <section class="scrollable" id="pjax-container">
                <header>
                    <div class="row b-b m-l-none m-r-none">
                        <div class="col-sm-4">
                            <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                            <p class="block text-muted">
                                <?php echo get_page('description');?>
                            </p>
                        </div>
                    </div>
                </header>
                <section class="vbox">
                    <section class="wrapper">
                        <?php echo output('notice');?> <?php echo fetch_notice_from_url();?> <?php echo validation_errors(); ?>
                        <section class="panel">
                            <div class="panel-heading">
                                <?php _e( 'Create a category' );?>
                            </div>
                            <div class="span8">
                                <form action="" class="panel-body" method="post">
                                    <div class="form-group">
                                        <input class="form-control" name="cat_name" type="text" placeholder="<?php _e( 'Category name' );?>" />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="cat_description" type="text" placeholder="<?php _e( 'Category description' );?>"></textarea>
                                    </div>
                                    <input class="btn btn-sm btn-info" type="submit" value="<?php _e( 'Create a category' );?>">
                                </form>
                            </div>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
