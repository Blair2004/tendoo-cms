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
										$user		=	get_instance()->users_global->getUser($g['AUTEUR']);
								?>
                                                <tr>
                                                    <td class="action articlePanel" style="padding-top:10px;padding-bottom:10px"><strong> <a class="view" href="<?php echo module_url( array( 'edit' , $g[ 'ID' ] ) , 'blogster' );?>"><?php echo $g['TITLE'];?></a> </strong>
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
                                                        <a href="<?php echo get_instance()->url->site_url(array('account','profile',$user['PSEUDO']));?>"><?php echo $user['PSEUDO'];?></a></strong></small> | 
                                                        <small><?php echo get_instance()->date->timespan($g['DATE']);?></small> | 
                                                        <small><a data-doAction style="color:#FF7F7F" href="<?php echo module_url( array( 'delete' , $g[ 'ID' ] ) , 'blogster' );?>"><?php _e( 'Delete' );?></a></small> <small>
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