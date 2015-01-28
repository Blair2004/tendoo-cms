<?php echo $inner_head;?>
<section>
    <section class="hbox stretch">
        <?php echo $lmenu;?>
        <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="hbox stretch">
                <section class="wrapper"> 
					<?php echo output('notice');?> 
					
                    <?php echo fetch_notice_from_url();?>
                	<section class="panel">
                    	<div class="panel-heading">
                        <?php _e( 'Manage Comments' );?>
                        </div>
                        <div class="table-responsive">
                            <form method="post" class="panel-body">
                                <div class="form-group">
                                	<label class="control-label"><?php _e( 'Author' );?></label>
                                    <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['AUTEUR'] == '' ? __( 'Unspecified' ) : $speComment['AUTEUR'];?>" />
                                </div>
                                <div class="form-group">
                                	<label class="control-label"><?php _e( 'Related Post' );?></label>
                                    <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['ARTICLE_TITLE'];?>" />
                                </div>
                                <div class="form-group">
                                	<label class="control-label"><?php _e( 'Status' );?></label>
                                    <?php echo $speComment['SHOW'] == '0'	? __( 'Unapproved' ) : __( 'Approved' );?>
                                </div>
                                <div class="form-group">
                                	<label class="control-label"><?php _e( 'Comment' );?></label>
                                    <textarea class="form-control" disabled="disabled" name="currentComment" placeholder="<?php _e( 'Type a comment' );?>"><?php echo $speComment['CONTENT'];?></textarea>
                                </div>
                                <input name="hiddenId" value="<?php echo $speComment['ID'];?>" type="hidden" />
                                <?php
                                if($speComment['SHOW'] == '0')
                                {
                                    ?>
                                <input class="btn btn-success" name="approve" value="<?php _e( 'Approuve' );?>" type="submit" />
                                    <?php
                                }
                                else
                                {
                                    ?>
                                <input class="btn btn-warning" name="disapprove" value="<?php _e( 'Disapprove' );?>" type="submit" />
                                    <?php
                                }
                                    ?>
                                    <input class="btn btn-danger" type="submit" value="<?php _e( 'Delete' );?>" name="delete" />
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>