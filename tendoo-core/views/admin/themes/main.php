<?php echo get_core_vars( 'lmenu' );?>

<section id="content">
<section class="vbox"> <?php echo get_core_vars( 'inner_head' );?>
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
                    <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                    <p class="block text-muted"><?php echo translate( 'list of installed themes' );?></p>
                </div>
            </div>
        </header>
        <section class="vbox">
            <section class="wrapper w-f"> <?php echo output('notice');?> 
                <div class="row themes_grid">
                    <?php 
	if(isset($themes_list) && $themes_list !== FALSE )
	{
		if(count($themes_list) > 0)
		{
			foreach($themes_list as $t)
			{
				$color	=	'';
				$success_color	=	'panel-success';
				if($t['active']== false)
				{
					$color			=	'';
				}
				else if($t['active']	==	 'TRUE')
				{
					$color			=	$success_color;
				}
			?>
                    <div class="col-lg-3 theme_head" 
                    	data-theme_namespace="<?php echo $t[ 'namespace' ];?>" 
                        data-theme_name="<?php echo $t[ 'human_name' ];?>"
                        data-theme_thumb="<?php echo theme_thumb( $t[ 'namespace' ] );?>"
                        data-theme_author="<?php echo $t[ 'author' ];?>"
                        data-theme_version="<?php echo $t[ 'version' ];?>"
					>
                        <input type="hidden" class="theme_details" value="<?php echo htmlentities($t[ 'description' ]);?>">
                        <section class="panel pos-rlt clearfix <?php echo $color;?>">
                            <header class="panel-heading">
                                <ul class="nav nav-pills pull-right">
                                    <li> <a href="#" class="panel-toggle text-muted active"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
                                </ul>
                                <!-- <a class="view" href="<?php echo $this->instance->url->site_url(array('admin','open','themes',$t['namespace']));?>"></a>-->
                                <?php echo $t['human_name'];?></header>
                            <div class="panel-body clearfix"><img src="<?php echo theme_thumb( $t[ 'namespace' ] );?>" style="width:100%;min-height:203px;"> </div>
                            <footer class="panel-footer">
                                <div class="actions">
                                    <button type="button"
                                    <?php
									if($t['active'])
									{
										?>
                                        disabled="disabled"
                                        <?php
									}
									?>
                                     data-action="ADMITSETDEFAULT" class="btn btn-white btn-sm">Activer</button>
                                    <button type="button" data-action="ADMITDELETETHEME" class="btn btn-white btn-sm">Supprimer</button>
                                    <button type="button" data-action="OPENDETAILS" class="btn btn-white btn-sm">Détails</button>
                                </div>
                            </footer>
                        </section>
                    </div>
                    <?php
			}
		}
	} else {
		?>
        <div class="col-lg-12">
        <?php
		echo tendoo_info( translate( 'no theme was installed, check out on store for new app(themes and modules)' ) );
		?>
        </div>
        <?php        
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
                                              <li><a href="#"><?php echo translate( 'next' );?></a></li>
                                              <li><a href="#"><?php echo translate( 'previous' );?></a></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-8 text-right text-center-xs">
                                        	<input controller_save_edits="" type="button" data-action="activate" class="btn btn-sm <?php echo theme_button_class();?>" value="Activer">
                                            <input controller_save_edits="" type="button" data-dismiss="modal" class="btn btn-sm <?php echo theme_button_class();?>" value="Quitter">
                                        </div>
                                    </div>
                                </footer>
                                <section class="scrollable" id="pjax-container">
                                    <section class="vbox">
                                        <div class="wrapper">
                                        	<img class="theme_thumb" src="" style="max-height:90%;max-width:100%;"/>
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
					var theme_namespace			=	$(dom).closest('.theme_head').data('theme_namespace');
					var action			=	$(dom).data('action');
					tendoo.doAction(
					'<?php echo $this->instance->url->site_url(array('admin','themes','manage'));?>'+'/'+theme_namespace
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
						theme_namespace		:	theme_namespace
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
							var	papa				=	$(this).closest('.theme_head');
							var nextPapaBrother		=	$(papa).next();
							var prevPapaBrother		=	$(papa).prev();

							var parent			=	$(this).closest('.theme_head');
							var themePrototype	=	$('#theme_details_prototype');
							var clone			=	$(themePrototype).clone();
							
							$(clone).find('.theme_thumb').attr('src',$(parent).data('theme_thumb'));
							$(clone).find('.theme_name').html($(parent).data('theme_name'));
							$(clone).find('.theme_author').html($(parent).data('theme_author'));
							$(clone).find('.theme_version').html($(parent).data('theme_version'));
							$(clone).find('.theme_details').html($(parent).find('.theme_details').val());
							var content			=	$(clone).html();
							var modal			=	tendoo.window
								.size(800,device.height)
								.title('Détails &raquo; '+$(parent).data('theme_name'))
								.openBy('scale-in')
								.closeBy('scale-out')
								.show(content);
							$(modal).find('.modal-body .pagination li').eq(0).bind('click',function(){
								if($(prevPapaBrother).length > 0)
								{
									$(modal).find('[data-dismiss="modal"]').trigger('click');
									setTimeout(function(){
										$(prevPapaBrother).find('[data-action="OPENDETAILS"]').trigger('click');
									},0);
								}
								return false;
							});
							$(modal).find('.modal-body .pagination li').eq(1).bind('click',function(){
								
								if($(nextPapaBrother).length > 0)
								{
									$(modal).find('[data-dismiss="modal"]').trigger('click');
									setTimeout(function(){
										$(nextPapaBrother).find('[data-action="OPENDETAILS"]').trigger('click');
									},0);
								}
								return false;
							});
							if(tools.isDefined($(papa).find('[data-action="ADMITSETDEFAULT"]').attr('disabled')))
							{
								$(modal).find('.modal-body').find('[data-action="activate"]').attr('disabled','disabled');
							}
							$(modal).find('.modal-body').find('[data-action="activate"]').bind('click',function(){
								if($(papa).length > 0)
								{
									$(papa).find('[data-action="ADMITSETDEFAULT"]').trigger('click');
									$(modal).find('.modal-body').find('[data-action="activate"]').attr('disabled','disabled');
								}
								return false;
							});
						}
					});
				});
				</script>
            </section>
        </section>
    </section>
</section>
