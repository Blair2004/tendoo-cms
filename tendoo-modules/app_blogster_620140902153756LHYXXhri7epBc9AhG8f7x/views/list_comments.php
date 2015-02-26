<?php
$this->gui->cols_width( 1 , 3 );

$this->gui->set_meta( 'comment-list' , __( 'Comment List' ) , 'panel-ho' )->push_to( 1 );

$this->gui->set_item( array(
	'type'		=>	'dom',
	'value'		=>	module_view( 'views/comment-list-table' , true , 'blogster' )
) )->push_to( 'comment-list' );

$this->gui->get();

return;
?>
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
                    <?php echo output('notice');?> <?php echo fetch_notice_from_url();?>
                    <section class="panel">
                        <div class="panel-heading">
                            <?php _e( 'Comments' );?>
                        </div>
                        
                    </section>
                </section>
            </section>
        </section>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-4">
                    <!--<select class="input-sm form-control input-s-sm inline">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-white">Apply</button>-->
                </div>
                <div class="col-sm-4 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm"><!-- showing 20-30 of 50 items --></small>
                </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <?php 
					if(is_array($paginate[4]))
					{
						foreach($paginate[4] as $p)
						{
							?>
                        <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
                        <?php
						}
					}
				?>
                    </ul>
                </div>
            </div>
        </footer>
    </section>
</section>
