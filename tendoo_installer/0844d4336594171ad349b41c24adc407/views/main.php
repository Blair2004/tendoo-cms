<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
		
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-3">
                    <select class="input-sm form-control inline bulkActionChange">
                        <option value="0">Actions Group&eacute;es</option>
                        <option value="deleteSelected">Supprimer</option>
                        <option value="moveToDraftSelected">D&eacute;placer dans les brouillons</option>
                        <option value="PublishSelected">Publier les articles</option>
                    </select>
                </div>
				<div class="col-sm-1"><button class="btn btn-sm btn-white bulkActionTrigger">Effectuer</button></div>
                <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">Affiche <?php echo $paginate[1];?> &agrave; <?php echo $paginate[2];?> &eacute;l&eacute;ments</small> </div>
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
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            
            <section class="vbox">
                <section class="wrapper"> 
					<?php echo $this->core->notice->parse_notice();?> 
					<?php echo $success;?>
                    <?php echo notice_from_url();?>
					<div class="row">
						<div class="col-lg-12">
						<section class="panel">
							<div class="panel-heading">
								<strong>
							Articles
								</strong>
							</div>
							<table class="table table-striped m-b-none">
								<form method="POST">
								<tbody>
								<?php
								if(count($getNews) > 0)
								{
									foreach($getNews as $g)
									{
										$cat_name	=	$news->getSpeCat($g['CATEGORY_ID']);
										$user		=	$this->core->users_global->getUser($g['AUTEUR']);
								?>
									<tr>
										<td class="action articlePanel" style="padding-top:10px;padding-bottom:10px">
											<strong>
											<a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$g['ID']));?>"><?php echo $g['TITLE'];?></a>
											</strong>
											<hr class="line line-dashed" style="margin:5px 0">
											<small><?php echo $g['ETAT'] == '1' ? 'Publi&eacute;' : 'Brouillon';?></small> |
											<small>Dans <?php echo $cat_name['CATEGORY_NAME'];?></small> | 
											<small>Par <strong><a href="<?php echo $this->core->url->site_url(array('account','profile',$user['PSEUDO']));?>"><?php echo $user['PSEUDO'];?></a></strong></small> |
											<small><?php echo $this->core->tendoo->timespan($g['DATE']);?></small> |
											<small><a style="color:#FF7F7F" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$g['ID']));?>">Supprimer</a></small> |
											<small><input type="checkbox" name="art_id[]" value="<?php echo $g['ID'];?>"></small>
										</td>
									</tr>
								<?php
									}
								}
								else
								{
									?>
									<tr>
										<td colspan="5">Aucun article publié ou dans les brouillons</td>
									</tr>
									<?php
								}
								?>
								
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
									if(confirm('Cette publication sera supprimé avec tous les commentaires qui y sont attachés. Continuer ?'))
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
												alert('La suppréssion à échoué. Cette publication est introuvable, ou vous n\'avez pas le droit d\'effectuer cette suppréssion');
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
									if($(this).find('[type="checkbox"]').attr('checked'))
									{
										$(this).find('[type="checkbox"]').removeAttr('checked');
									}
									else
									{
										$(this).find('[type="checkbox"]').attr('checked','checked');
									}
								});
							});
							</script>
						
						</section>
						
						</div>
					</div>
				</section>
            </section>
        </section>
		
	</section>
	
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
