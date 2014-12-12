<?php
ob_start();
$success_color	=	'panel-success';
?>
<div id="theme_details_prototype" style="display:none">
	<section class="hbox stretch">
        <section id="vbox">
            <section class="scrollable">
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
        </section>
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
<?php

$footer_script		=	ob_get_clean();
$this->gui->col_config( 1 , array(
	'inner-opening-wrapper'		=>		'<div class="row themes_grid">',
	'inner-closing-wrapper'		=>		'</div>',
	'footer-script'				=>		$footer_script
) );

$this->gui->cols_width( 1 , 4 );

foreach( force_array( $themes_list ) as $_theme )
{
	$footer_buttons		=	array();
	$status				=	riake( 'active' , $_theme ) === true ? 'disabled="disabled"' : '';
	$footer_buttons[]	=	array(
		'text'			=>	__( 'Activate' ),
		'attrs'			=>	'data-action="ADMITSETDEFAULT" ' . $status
	);
	$footer_buttons[]	=	array(
		'text'			=>	__( 'Delete' ),
		'attrs'			=>	'data-action="ADMITDELETETHEME"'
	);
	$footer_buttons[]	=	array(
		'text'			=>	__( 'Details' ),
		'attrs'			=>	'data-action="OPENDETAILS"'
	);
	$this->gui->set_meta( array(
		'type'				=>		'panel-footer',
		'title'				=>		riake( 'name' , $_theme ),
		'namespace'			=>		core_meta_namespace( array( 'admin' , 'themes' , riake( 'namespace' , $_theme ) ) ),
		'opening-wrapper'	=>	'<div class="col-lg-3 theme_head"  
		data-theme_namespace="' . $_theme[ 'namespace' ] . '" 
		data-theme_name="' . $_theme[ 'name' ] . '"
		data-theme_thumb="' . theme_thumb( $_theme[ 'namespace' ] ) . '"
		data-theme_author="' . $_theme[ 'author' ] . '"
		data-theme_version="' . $_theme[ 'version' ] . '"><input type="hidden" class="theme_details" value="' . htmlentities($_theme[ 'description' ]) . '">',
		'closing-wrapper'	=>		'</div>',
		'footer-buttons'	=>		$footer_buttons
	) )->push_to( 1 );
	
	$this->gui->set_item( array(
		'type'		=>		'dom',
		'value'		=>		'<img src="' . theme_thumb( $_theme[ 'namespace' ] ) . '" style="width:100%;min-height:250px;">',
	) )->push_to( core_meta_namespace( array( 'admin' , 'themes' , riake( 'namespace' , $_theme ) ) ) );
}

$this->gui->get();