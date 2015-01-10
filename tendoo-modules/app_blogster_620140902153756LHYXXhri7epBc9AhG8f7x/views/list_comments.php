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
                    <?php echo output('notice');?> <?php echo fetch_error_from_url();?>
                    <section class="panel">
                        <div class="panel-heading">
                            <?php _e( 'Comments' );?>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th><?php _e( 'Author' );?></th>
                                        <th width="400"><?php _e( 'Preview' );?></th>
                                        <th><?php _e( 'Related Post' );?></th>
                                        <th><?php _e( 'Posted on' );?></th>
                                        <th><?php _e( 'Status' );?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                if(count($getComments) > 0)
                                {
                                    foreach($getComments as $g)
                                    {
                                        if($g['AUTEUR'] != '0')
                                        {
                                            $user				=	$this->instance->users_global->getUser($g['AUTEUR']);
                                        }
                                        else
                                        {
                                            $user['PSEUDO']		=	$g['OFFLINE_AUTEUR'];
                                        }
                                ?>
                                    <tr>
                                        <td><?php echo $user['PSEUDO'];?></td>
                                        <td><a href="<?php echo $this->instance->url->site_url(array('admin','open','modules',$module[ 'namespace' ],'comments_manage',$g['ID']));?>"><?php echo word_limiter($g['CONTENT'],20);?></a></td>
                                        <td><?php 
                                        $article	=	$news->getSpeNews($g['REF_ART']);
                                        echo $article[0]['TITLE'];
                                        ?></td>
                                        <td><?php echo timespan($g['DATE']);?></td>
                                        <td><?php
                                        if($setting['APPROVEBEFOREPOST'] == 0)
                                        {
                                            echo __( 'N/A' );
                                        }
                                        else
                                        {
                                            echo $g['SHOW'] == '0' ? __( 'Unapproved' ) : __( 'Approved' );
                                        }
                                        ?></td>
                                    </tr>
                                    <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr>
                                        <td colspan="5"><?php _e( 'There is no comment right now' );?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
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
