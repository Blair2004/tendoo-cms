/*
*	[tewi_meta] - meta des widgets (namespace, mod_namespace, human_name...)
	.widget_item - widget class.
	[meta_widgetParamsName=""] support meta params name. add to params attr name as field attr name.
	lorsqu'il y a plus d'1 meta_widgetParams, ceci doit nécessaire avoir l'attribut "meta_widgetParamsName" pour individualiser chaque parametres. 
	Ceci sera également utile lors de l'envoi des paramètres dans l'espace utilisateur. Les différents parametres seront convertir en tableau associatif.
	
	- En cas de collision de noms, les nouveaux écraseront les anciens.
	
	- S'il est omis d'ajouter "meta_widgetParamsName", celui-ci prendra la valeur "undefined" pour tous les champs et créera une collision de noms.
*
*/
$(document).ready(function(){
	$(function(){
		var bindTewiRemover	=	function(){
			$('.tewi_remover').bind('click',function(){ // Tewi Remover
				$(this).closest('.widget_item').hide(500,function(){
					$(this).remove();
				});
			});	
		};
		var setIdForTeWi	=	function(section_panel){ // ID affecter.
			var startIndex		=	0;
			var tewi_section	=	$(section_panel).attr('widget-section');	
			$(section_panel).find('.widget_item').find('[tewi_meta]').each(function(){
				$(this).find('[meta_title]').attr('name','tewi_wid['+tewi_section+']['+startIndex+'][title]');
				$(this).find('[meta_modnamespace]').attr('name','tewi_wid['+tewi_section+']['+startIndex+'][modnamespace]');
				$(this).find('[meta_namespace]').attr('name','tewi_wid['+tewi_section+']['+startIndex+'][namespace]');
				$(this).find('[meta_human_name]').attr('name','tewi_wid['+tewi_section+']['+startIndex+'][human_name]');
				// In case there is too many params.
				// Dans le cas ou l'attribut meta_widgetParamsName est définie.
				if($(this).find('[meta_widgetParams]').length > 0)
				{
					if($(this).find('[meta_widgetParams]').find('[meta_widgetParamsName]').length > 0)
					{
						$(this).find('[meta_widgetParams]').each(function(){
							$(this).attr('name','tewi_wid['+tewi_section+']['+startIndex+'][params]['+$(this).attr('meta_widgetParamsName')+']');
						});
					}
					else
					{
						$(this).find('[meta_widgetParams]').each(function(){
							$(this).attr('name','tewi_wid['+tewi_section+']['+startIndex+'][params]');
						});
					}
				}
				else
				{
					$(this).find('[meta_widgetParams]').attr('name','tewi_wid['+tewi_section+']['+startIndex+'][params]');
				}
				startIndex++ // Increase Index.
			});
		};
		// draggable() // starting;
		var sortable	=	function(WIC){
			var isOverWIC	=	false; // Is Over Widget Item Container
			var WIC_clone	=	$(WIC).clone();
			$(WIC).sortable({
				start	:	function(e,el){
					$('[widget-section] [active-widget-panel-body]').each(function(){
						if($(this).hasClass('collapse'))
						{
							$(this).closest('[widget-section]').find('header').eq(0).find('.panel-toggle').trigger('click');
						}
					});
					$(this).sortable('refresh');
				},
				stop	:	function(e,el){
				},
				placeholder	:	'widget_item_add',
				connectWith	:	'[widget-section] [active-widget-panel-body]',
				opacity		: 0.8,
				scroll		:	true,
				out			:	function(e,x){
				},
				stop		:	function(e,x){
					$(this).replaceWith($(WIC_clone));
					sortable(WIC_clone);
				}
			});	
			
			$('[widget-section] [active-widget-panel-body]').sortable({
				opacity		: 0.8,
				out 		:	function(){
				},
				over		:	function(e,element){					
				},
				receive		:	function(e,element){
					var totalW				=	$(this).find('.widget_item').length;
					var tewi_namespace		=	$(element.item).attr('widget-namespace');
					var tewi_modnamespace	=	$(element.item).attr('widget-modnamespace');
					var tewi_human_name		=	$(element.item).attr('widget-human_name');
					var clone				=	$(element.item);
					var text				=	$.trim($(clone).find('header').text());
					var tewi_section		=	$(this).closest('[widget-section]').attr('widget-section');
					var components			=	$(element.item).find('[widget-hidden_content]').length > 0 ? $(element.item).find('[widget-hidden_content]').clone() : {};
					if($(components).length > 0)
					{
						if($(components).find('[meta_widgetParams]').length > 1)
						{
							$(components).find('[meta_widgetParams]').each(function(){
								$(this).attr('name','tewi_wid['+tewi_section+']['+totalW+'][params]['+$(this).attr('meta_widgetParamsName')+']');
							});
						}
						else
						{
							$(components).find('[meta_widgetParams]').attr('name','tewi_wid['+tewi_section+']['+totalW+'][params]');
						}
						components_html			=	$(components).html() == null ? '' : $(components).html(); // Retreiving components edited
						$(element.item).find('[widget-hidden_content]').remove(); // Suppression de l'échantillon pour éviter les conflits.
					}
					$(clone)
					.find('header')
					.html(
						'<ul class="nav nav-pills pull-left">'+
							'<li><a class="tewi_remover" href="javascript:void(0)"><i class="fa fa-times"></i></a></li>'+
						'</ul>'+
						'<ul class="nav nav-pills pull-right">'+
							'<li>'+
								'<a class="panel-toggle text-muted active" href="javascript:void(0)">'+
									'<i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i>'+
								'</a>'+
							'</li>'+
						'</ul>'+
						text
								
					);
					if($(clone).find('[tewi_meta]').length == 0)
					{
						$(clone).append('<div tewi_meta></div>');
					}
					$(clone).find('[tewi_meta]')
					.html(
						'<input meta_modnamespace type="hidden" name="tewi_wid['+tewi_section+']['+totalW+'][modnamespace]" value="'+tewi_modnamespace+'">'+
						'<input meta_namespace type="hidden" name="tewi_wid['+tewi_section+']['+totalW+'][namespace]" value="'+tewi_namespace+'">'+
						'<input meta_human_name type="hidden" name="tewi_wid['+tewi_section+']['+totalW+'][human_name]" value="'+tewi_human_name+'">'+
						'<div class="panel-body">'+
							'<div class="form-group">'+
								'<input type="text" meta_title placeholder="Titre du widget" class="form-control" name="tewi_wid['+tewi_section+']['+totalW+'][title]">'+
							'</div>'+
							components_html+
						'</div>'
					);
					bindTewiRemover();			
					setIdForTeWi($(this).closest('[widget-section]')); // setting new Ids
				},
				activate	:	function(){
				},
				update		:	function(){
					setIdForTeWi($(this).closest('[widget-section]')); // setting new Ids
				},
				tolerance	:	'intersect',
				start		:	function(){
				},
				connectWith	:	'[widget-section] [active-widget-panel-body]',
				placeholder	:	'widget_item_add'
			})
		}
		sortable('.widget_item_container');
		bindTewiRemover();
	});
})