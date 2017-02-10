$(document).ready(function(){
	function __doSort(event,ui){
		ui.item.closest(".row .box").parent().find('.draggable_widgets').each(function(){
			$(this).children(function(){
				alert($(this).attr('widget_id'));
			})
		});
		var tab		=	new Array;
		var section	=	1;
		var newSet	=	{};
		$('.row .meta-row').each(function(){
			if(typeof tab[section] == 'undefined')
			{
				tab[section] = new Array;
			}
			$(this).find('div[data-meta-namespace]').each(function(){
				tab[section].push($(this).data( 'meta-namespace' ) );
			});
			// Saving Each Fields
			_.extend(newSet,_.object([ section ],[ tab [ section ] ]));
			section++;
		});
		tendoo.options.set( 'dashboard_widget_position', newSet, true );
	}

	var actionAllower	=	{};

	$('.row .meta-row').sortable({
		grid			:	[ 10 , 10 ],
		connectWith		: 	".row .meta-row",
		items			:	"div[data-meta-namespace]",
		placeholder		:	"widget-placeholder",
		forceHelperSize	:	false,
		// zIndex			:	tendoo.zIndex.draggable,
		forcePlaceholderSize	:	true,
		stop			:	function(event, ui){
			__doSort(event, ui);
		},
		delay			: 	150
	});
});
