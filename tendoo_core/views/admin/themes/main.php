<?php echo $lmenu;?>

<section id="content">
<section class="vbox"> <?php echo $inner_head;?>
	<footer class="footer bg-white b-t">
        <div class="row m-t-sm text-center-xs">
            <div class="col-sm-4" id="ajaxLoading" style="visibility: hidden;"></div>
            <div class="col-sm-4 text-center"> </div>
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
                    <p class="block text-muted">Liste des th&egrave;mes install&eacute;s</p>
                </div>
            </div>
        </header>
        <section class="vbox">
            <section class="wrapper w-f"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?>
                <div class="row themes_grid">
                    <?php 
	if(isset($Themes))
	{
		if(count($Themes) > 0)
		{
			foreach($Themes as $t)
			{
				$color	=	'';
				$success_color	=	'panel-success';
				if($t['ACTIVATED']== '')
				{
					$t['ACTIVATED']	= 'Inactif';
					$color			=	'';
				}
				else if($t['ACTIVATED']	==	 'TRUE')
				{
					$t['ACTIVATED']	=	'Activ&eacute;';
					$color			=	$success_color;
				}
			?>
                    <div class="col-lg-3 theme_head" 
                    	data-theme_id="<?php echo $t['ID'];?>" 
                        data-theme_name="<?php echo $t['HUMAN_NAME'];?>"
                        data-theme_thumb="<?php echo $this->core->tendoo_admin->getThemeThumb($t['ID']);?>"
                        data-theme_author="<?php echo $t['AUTHOR'];?>"
                        data-theme_version="<?php echo $t['APP_VERS'];?>"
					>
                        <input type="hidden" class="theme_details" value="<?php echo $t['DESCRIPTION'];?>">
                        <section class="panel pos-rlt clearfix <?php echo $color;?>">
                            <header class="panel-heading">
                                <ul class="nav nav-pills pull-right">
                                    <li> <a href="#" class="panel-toggle text-muted active"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
                                </ul>
                                <a class="view" href="<?php echo $this->core->url->site_url(array('admin','themes','config',$t['ID']));?>"><?php echo $t['HUMAN_NAME'];?></a> </header>
                            <div class="panel-body clearfix"> <img src="<?php echo $this->core->tendoo_admin->getThemeThumb($t['ID']);?>"> </div>
                            <footer class="panel-footer">
                                <div class="actions">
                                    <button type="button" data-action="ADMITSETDEFAULT" class="btn btn-white btn-sm">Activer</button>
                                    <button type="button" data-action="ADMITDELETETHEME" class="btn btn-white btn-sm">Supprimer</button>
                                    <button type="button" data-action="OPENDETAILS" class="btn btn-white btn-sm">Détails</button>
                                </div>
                            </footer>
                        </section>
                    </div>
                    <?php
			}
		}
	}
?>
                </div>
                <div id="theme_details_prototype" style="display:none">
                    <section class="hbox stretch">
                        <section id="content">
                            <section class="vbox">
                                <footer class="footer bg-white b-t">
                                    <div class="row m-t-sm text-center-xs">
                                        <div class="col-sm-4">
                                            <ul class="pagination pagination-sm" style="margin:0;">
                                              <li><a href="#">Précédent</a></li>
                                              <li><a href="#">Suivant</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-8 text-right text-center-xs">
                                            <input controller_save_edits="" type="button" data-dismiss="modal" class="btn btn-sm <?php echo theme_button_class();?>" value="Quitter">
                                        </div>
                                    </div>
                                </footer>
                                <section class="scrollable" id="pjax-container">
                                    <section class="vbox">
                                        <div class="wrapper">
                                        	<img class="theme_thumb" src="" style="max-height:70%;max-width:100%;"/>
                                            <hr class="line line-dashed"/>
                                            <h3><span class="theme_name"></span> <small><span class="theme_version"></span></small></h3>
                                            <h5>Par <span class="theme_author"></span></h5>
                                            <hr class="line line-dashed"/>
                                            <p class="theme_details">
                                            </p>
                                        </div>
                                    </section>
                                </section>
                            </section>
                            <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"> </a> </section>
                    </section>
                </div>
                <script>
				function execAction(dom)
				{
					var themeID			=	$(dom).closest('.theme_head').data('theme_id');
					var action			=	$(dom).data('action');
					tendoo.doAction(
					'<?php echo $this->core->url->site_url(array('admin','themes','manage'));?>'+'/'+themeID
					,function(e){
						tendoo.triggerAlert(e);
						if(e.status == 'success')
						{
							if(e.response == 'theme_set')
							{
								$(dom).closest('.themes_grid').children('.theme_head').each(function(){
									$(this).find('[data-action="ADMITSETDEFAULT"]').removeAttr('disabled');
									$(this).find('.panel').removeClass('<?php echo $success_color;?>');
								})
								$(dom).closest('.theme_head').find('.panel').addClass('<?php echo $success_color;?>');
								$(dom).attr('disabled','disabled');
							}
							else if(e.response == 'theme_deleted')
							{
								$(dom)
								.closest('.theme_head')
								.transition({opacity: 0,scale: 0,x: 0,duration: 500},function(){
									$(this).hide(500,function(){
										$(this).remove();
									});
								})
							}
						}
					},{
						action			:	action,
						theme_id		:	themeID
					});
				}
				$('.themes_grid').children('div').each(function(){
					$(this).find('[data-action]').bind('click',function(){
						var $this	=	$(this);
						if($(this).data('action') == 'ADMITDELETETHEME')
						{
							tendoo.modal.confirm('Souhaitez-vous supprimer ce thème ?',function(){
								execAction($this);
							});
						}
						else if($(this).data('action') == 'ADMITSETDEFAULT')
						{
							execAction($(this));
						}
						else if($(this).data('action')	==	'OPENDETAILS')
						{
							var parent			=	$(this).closest('.theme_head');
							var themePrototype	=	$('#theme_details_prototype');
							var clone			=	$(themePrototype).clone();
							
							$(clone).find('.theme_thumb').attr('src',$(parent).data('theme_thumb'));
							$(clone).find('.theme_name').html($(parent).data('theme_name'));
							$(clone).find('.theme_author').html($(parent).data('theme_author'));
							$(clone).find('.theme_version').html($(parent).data('theme_version'));
							$(clone).find('.theme_details').html($(parent).find('.theme_details').val());
							var content			=	$(clone).html();
							tendoo.window
								.size(800,device.height)
								.title('Détails &raquo; '+$(parent).data('theme_name'))
								.show(content);
						}
					});
				});
				</script>
            </section>
        </section>
    </section>
</section>
