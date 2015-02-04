<?php echo $inner_head;?>

<section id="w-f">
    <section class="hbox stretch">
        <?php echo $lmenu;?>
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
                    <?php echo output('notice');?>
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-heading">
                                    <?php _e( 'Send a new file' );?>
                                </div>
                                <div class="panel-body" style="padding:10px;">
                                    <p><?php _e( 'You can send video, audio and image files.' );?></p>
                                    <br />
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon"><?php _e( 'Name' );?></span>
                                            <input name="file_name" type="text" class="form-control" placeholder="<?php _e( 'Name' );?>">
                                        </div>
                                        <br />
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Description du fichier</span>
                                            <textarea style="height:200px;" name="file_description" placeholder="<?php _e( 'Description' );?>" type="text" class="form-control"></textarea>
                                        </div>
                                        <br />
                                        <div class="form-group">
                                            <input class="form-control" type="file" name="file" />
                                        </div>
                                        <input class="btn btn-info" type="submit" value="<?php _e( 'Upload this file' );?>" />
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
