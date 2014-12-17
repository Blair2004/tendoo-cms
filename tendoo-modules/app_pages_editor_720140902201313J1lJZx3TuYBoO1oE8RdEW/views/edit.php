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
                <section class="vbox stretch">
                    <section class="wrapper">
                        <?php echo output('notice');?> <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                        <form method="post" id="submition">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <?php _e( 'Edit a page' );?>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group textarea">
                                                <?php echo $this->instance->visual_editor->getEditor(array('name'=>'page_content','id'=>'editor','defaultValue'	=>	$current_page[0][ 'FILE_CONTENT' ] ));?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel">
                                        <div class="panel-heading">
                                           	<?php _e( 'Page Details' );?>
                                        </div>
                                        <div class="panel-body">
                                            <input name="page_id" value="<?php echo $current_page[0][ 'ID' ];?>" type="hidden" />
                                            <div class="form-group text">
                                                <input class="form-control" type="text" name="page_title" placeholder="Titre" value="<?php echo return_if_array_key_exists( 'TITLE' , $current_page[0] );?>">
                                            </div>
                                            <div class="form-group text">
                                                <textarea class="form-control" rows="5" type="text" name="page_description" placeholder="<?php _e( 'Description' );?>" style="resize:none;"><?php echo return_if_array_key_exists( 'DESCRIPTION' , $current_page[0] );?></textarea>
                                            </div>
                                            <div class="form-group text">
                                                <select class="form-control" rows="5" type="text" name="page_parent">
                                                    <option value="0"><?php _e( 'Choose a parent' );?></option>
                                                    <?php
												if( is_array( $available_pages ) ){
													foreach( $available_pages as $_page ){
														if( $_page[ 'ID' ] == $current_page[0][ 'PAGE_PARENT' ] ){
															$is_selected	=	'selected="selected"';
														}
														else{
															$is_selected 	=	'';
														}
														?>
                                                    <option <?php echo $is_selected;?> value="<?php echo $_page[ 'ID' ];?>"><?php echo $_page[ 'TITLE' ];?></option>
                                                    <?php
													}
												}
												?>
                                                </select>
                                            </div>
                                            <div class="form-group text">
                                                <select class="form-control" rows="5" type="text" name="page_controller_id">
                                                    <option value=""><?php _e( 'Bind to a controller' );?></option>
                                                    <?php
                                                if(is_array( $available_controllers ) )
                                                {
                                                    foreach( $available_controllers as $c)
                                                    {
														if( $c[ 'PAGE_CNAME' ] == $current_page[0][ 'CONTROLLER_REF_CNAME' ] ){
															$is_selected	=	'selected="selected"';
														}
														else{
															$is_selected 	=	'';
														}
                                                        ?>
                                                    <option <?php echo $is_selected ;?> value="<?php echo $c['PAGE_CNAME'];?>"><?php echo $c['PAGE_NAMES'];?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group text">
                                                <label  class="label-control switch" >
                                                <input type="checkbox" name="page_status" value="1" <?php echo (int)$current_page[0][ 'STATUS' ] == 1 ? 'checked' : '';?>/>
                                                <span></span>
                                                <p style="display:inline-block;vertical-align:bottom;font-weight:normal;margin-left:10px;">
                                                    <?php _e( 'Published ?' );?>
                                                </p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </section>
            </section>
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-lg-3 pull-right">
                        <input type="button" link-to-form="#submition" class="btn btn-sm pull-right <?php echo theme_button_class();?>" value="<?php _e( 'Save page' );?>">
                    </div>
                </div>
            </footer>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
