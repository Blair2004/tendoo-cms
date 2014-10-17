<?php echo $lmenu;?>

<section id="content">
    <section class="bigwrapper"><?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-lg-3 pull-right">
                    <input type="button" link-to-form="#submition" class="btn btn-sm pull-right <?php echo theme_button_class();?>" value="Créer la page">
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
                </div>
            </header>
            <section class="bigwrapper">
                <section class="wrapper"> <?php echo output('notice');?> <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                    <form method="post" id="submition">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="panel">
                                    <div class="panel-heading"> Cr&eacute;er une nouvelle page </div>
                                    <div class="panel-body">
                                        <div class="form-group textarea"> <?php echo $this->instance->visual_editor->getEditor(array('name'=>'page_content','id'=>'editor','defaultValue'	=>	set_value( 'page_content' ) ));?> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel">
                                    <div class="panel-heading"> Détails sur la page </div>
                                    <div class="panel-body">
                                        <div class="form-group text">
                                            <input class="form-control" type="text" name="page_title" placeholder="Titre" value="<?php echo set_value( 'page_title' );?>">
                                        </div>
                                        <div class="form-group text">
                                            <textarea class="form-control" rows="5" type="text" name="page_description" placeholder="Description" style="resize:none;"><?php echo set_value( 'page_description' );?></textarea>
                                        </div>
                                        <div class="form-group text">
                                            <select class="form-control" rows="5" type="text" name="page_parent">
                                                <option value="0">Choisir un parent...</option>
                                                <?php
												if( is_array( $available_pages ) ){
													foreach( $available_pages as $_page ){
														?><option <?php echo set_select( 'page_parent' , $_page[ 'ID' ] );?> value="<?php echo $_page[ 'ID' ];?>"><?php echo $_page[ 'TITLE' ];?></option><?php
													}
												}
												?>
                                            </select>
                                        </div>
                                        <div class="form-group text">
                                            <select class="form-control" rows="5" type="text" name="page_controller_id">
                                                <option value="">Attribuer à un contrôleur...</option>
                                                <?php
                                                if(is_array( $available_controllers ) )
                                                {
                                                    foreach( $available_controllers as $c)
                                                    {
                                                        ?>
                                                <option <?php echo set_select( 'page_parent' , $c[ 'PAGE_CNAME' ] );?> value="<?php echo $c['PAGE_CNAME'];?>"><?php echo $c['PAGE_NAMES'];?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group text">
                                            <label  class="label-control switch" >
                                                <input type="checkbox" name="page_status" value="1" checked/>
                                            <span></span>
                                            <p style="display:inline-block;vertical-align:bottom;font-weight:normal;margin-left:10px;">Publier directement</p>
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
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> 
</section>
