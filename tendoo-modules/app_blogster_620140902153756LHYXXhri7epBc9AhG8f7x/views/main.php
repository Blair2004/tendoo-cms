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
                        <div class="row">
                            <div class="col-lg-8">
                                <section class="panel">
                                    <div class="panel-heading">
                                        <a href="<?php echo module_url('index');?>"><?php echo sprintf( __( 'All posts (%s)' ) , $ttNews );?></a> | 
                                        <a href="<?php echo module_url('index?filter=mines');?>"><?php echo sprintf( __( 'Mines (%s)' ) , $ttMines );?></a> | 
                                        <a href="<?php echo module_url('index?filter=scheduled');?>"><?php echo sprintf( __( 'Scheduled (%s)' ) , $ttScheduled );?></a> |
                                        <a href="<?php echo module_url('index?filter=draft');?>"><?php echo sprintf( __( 'Draft (%s)' ) , $ttDraft );?></a>
                                    </div>
                                    <table class="table table-striped">
                                        <form method="POST">
                                            <tbody>
                                                <?php
								if(count($getNews) > 0)
								{
									foreach($getNews as $g)
									{
										$relatedCategory	=	$news->getArticlesRelatedCategory($g['ID']);
										$allCategory		=	array();
										foreach($relatedCategory as $rC)
										{
											$allCategory[]	=	$news->getSpeCat($rC['CATEGORY_REF_ID']);
										}
										$user		=	$this->instance->users_global->getUser($g['AUTEUR']);
								?>
                                                <tr>
                                                    <td class="action articlePanel" style="padding-top:10px;padding-bottom:10px"><strong> <a class="view" href="<?php echo $this->instance->url->site_url(array('admin','open','modules',$module[ 'namespace' ],'edit',$g['ID']));?>"><?php echo $g['TITLE'];?></a> </strong>
                                                        <hr class="line line-dashed" style="margin:5px 0">
                                                        <small>
                                                        <?php 
											if($g['ETAT'] == '1')
											{
												echo __( 'Published' ); 
											}
											else if($g['ETAT']	==	'2')
											{
												echo __( 'Draft' );
											}
											else if($g['ETAT']	==	'3')
											{
												echo __( 'Scheduled' );
											}
											else if($g['ETAT']	==	'4')
											{
												echo __( 'Pending review' );
											}
											else
											{
												echo sprintf( __( '%s : Unknow status' ) , $g['ETAT'] );
											}
											;?>
                                                        </small> | <small><?php _e( 'On' );?>
                                                        <?php 
											foreach($allCategory as $aC)
											{
												?>
                                                        <a style="text-decoration:underline;" href="<?php echo module_url(array('category','manage',$aC['ID']));?>"><?php echo $aC['CATEGORY_NAME'];?></a>,
                                                        <?php
											}
											;?>
                                                        </small> | <small><?php _e( 'By' );?> <strong>
                                                        <a href="<?php echo $this->instance->url->site_url(array('account','profile',$user['PSEUDO']));?>"><?php echo $user['PSEUDO'];?></a></strong></small> | 
                                                        <small><?php echo $this->instance->date->timespan($g['DATE']);?></small> | 
                                                        <small><a data-doAction style="color:#FF7F7F" href="<?php echo $this->instance->url->site_url(array('admin','open','modules',$module[ 'namespace' ],'delete',$g['ID']));?>"><?php _e( 'Delete' );?></a></small> <small>
                                                        <input style="display:none;" type="checkbox" name="art_id[]" value="<?php echo $g['ID'];?>">
                                                        </small></td>
                                                </tr>
                                                <?php
									}
								}
								else
								{
									?>
                                                <tr>
                                                    <td colspan="5"><?php _e( 'No posts available.' );?></td>
                                                </tr>
                                                <?php
								}
								?>
                                                <script>
								$('[data-doAction]').each(function(){
									if(typeof $(this).attr('doAction-binded') == 'undefined')
									{
										$(this).attr('doAction-binded','true');
										$(this).bind('click',function(){
											var $this	=	$(this);
											tendoo.modal.confirm('<?php _e( 'Do you wish to delete this ?' );?>',function(){
												tendoo.doAction($this.attr('href'),function(e){
													tendoo.triggerAlert(e);
													if(e.status == 'success')
													{
														$this.closest('tr').fadeOut(500,function(){
															$(this).remove();
														});
													}
												},{});
											});
											return false;
										});
									}
								});
								</script>
                                            </tbody>
                                            <div style="display:none">
                                                <input type="submit" name="deleteSelected">
                                                <input type="submit" name="draftSelected">
                                                <input type="submit" name="publishSelected">
                                            </div>
                                        </form>
                                    </table>
                                    <script>
							$(document).ready(function(){
								$('table .delete').bind('click',function(){
									if(confirm('<?php _e( 'This post will be deleted with all his comments. Proceed ?' );?>'))
									{
										var current	=	this;
										var items = [];
										$.getJSON($(this).attr('href'), function(data) {
											if(data.requestStatus === true)
											{
												$(current).closest('tr').fadeOut(500,function(){
													$(this).remove();
												})
											}
											else
											{
												alert("<?php _e( 'Deletion failed. Selected post is not available or you don\'t have the permission to do that.' );?>");
											}
										});
										return false;
									}
								});
								$('.bulkActionTrigger').bind('click',function(){
									var selectedAction	=	$('.bulkActionChange').val();
									if(selectedAction == 'PublishSelected')
									{
										$('[name="publishSelected"]').trigger('click');
									}
									if(selectedAction == 'deleteSelected')
									{
										$('[name="deleteSelected"]').trigger('click');
									}
									if(selectedAction == 'moveToDraftSelected')
									{
										$('[name="draftSelected"]').trigger('click');
									}
								});
								$('.articlePanel').bind('click',function(){
									if(tools.isDefined($(this).find('[type="checkbox"]').attr('checked')))
									{
										$(this).removeClass('active_list');
										$(this).find('[type="checkbox"]').removeAttr('checked');
									}
									else
									{
										$(this).addClass('active_list');
										$(this).find('[type="checkbox"]').attr('checked','checked');
									}
								});
							});
							</script>
                                    <style>
							.active_list
							{
								background	:	#555 !important;
								color		:	#FEFEFE !important;
							}
							.active_list h1, .active_list h2, .active_list h3, .active_list h4, .active_list h5, .active_list a
							{
								color		:	#FEFEFE !important;
							}
							</style>
                                </section>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <?php _e( 'Recents comments' );?>
                                    </div>
                                    <table class="table panel-body">
                                        <form method="POST">
                                            <tbody>
                                                <?php
                                    if(count($lastestComments) > 0)
                                    {
                                        foreach($lastestComments as $g)
                                        {
                                            $news_concerned	=	$news->getSpeNews($g['REF_ART']);
                                            $user			=	$this->instance->users_global->getUser($g['AUTEUR']);
                                            $pseudo			=	$g['AUTEUR'];
                                            if(is_array($user) && count($user) > 0)
                                            {
                                                $pseudo	=	$user['PSEUDO'];
                                                ?>
                                                <tr>
                                                    <td><h5><?php echo $pseudo;?> <?php _e( 'Says :' );?> <a style="text-decoration:underline" href="<?php echo module_url(array('comments_manage',$g['ID']));?>"><?php echo word_limiter($g['CONTENT'],10);?></a> <?php _e( 'On' );?> <a style="text-decoration:underline" href="<?php echo module_url(array('edit',$news_concerned[0]['ID']));?>"><?php echo $news_concerned[0]['TITLE'];?></a> </h5></td>
                                                </tr>
                                                <?php
                                            }
                                            else
                                            {
                                                $pseudo	=	$g[ 'OFFLINE_AUTEUR' ];
                                                ?>
                                                <tr>
                                                    <td><h5><?php echo $pseudo;?> <?php _e( 'Says :' );?> <a style="text-decoration:underline" href="<?php echo module_url(array('comments_manage',$g['ID']));?>"><?php echo word_limiter($g['CONTENT'],10);?></a> <?php _e( 'On' );?> <a style="text-decoration:underline" href="<?php echo module_url(array('edit',$news_concerned[0]['ID']));?>"><?php echo $news_concerned[0]['TITLE'];?></a> </h5></td>
                                                </tr>
                                                <?php
                                            }
                                    
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                                <tr>
                                                    <td colspan="5"><?php _e( 'No comment available' );?></td>
                                                </tr>
                                                <?php
                                    }
                                    ?>
                                            </tbody>
                                        </form>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-sm-3">
                        <select class="input-sm form-control inline bulkActionChange">
                            <option value="0"><?php _e( 'Bulk Actions' );?></option>
                            <option value="deleteSelected"><?php _e( 'Delete' );?></option>
                            <option value="moveToDraftSelected"><?php _e( 'Set as draft' );?></option>
                            <option value="PublishSelected"><?php _e( 'Publish' );?></option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-sm btn-white bulkActionTrigger"><?php _e( 'Apply' );?></button>
                    </div>
                    <div class="col-sm-4 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm"><?php sprintf( __( 'Displays %s to %s elements' ) , $paginate[1] , $paginate[2] );?></small>
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
</section>
