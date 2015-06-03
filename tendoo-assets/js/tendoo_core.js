// JavaScript Document
$('.panel-toggle').each(function(){
});
tendoo.panel_toggle		=	new function(){
	var __switchStatus	=	function(e){
		if($(e).hasClass('active'))
		{
			$(e).find('i[class="icon-caret-down"]').show();
			$(e).find('i[class="icon-caret-up"]').hide();
		}
		ekse
		{
			$(e).find('i[class="icon-caret-down"]').hide();
			$(e).find('i[class="icon-caret-up"]').show();
		}
	};
	this.init			=	new function(){
			$('a[class|="panel-toggle"]').each(function(){
			alert('True');
			__switchStatus(this);
		});
	};
	this.bind			=	function(e){
		if(typeof $(e).attr('panel_toogle_bound') == 'udefined')
		{
			$(e).attr('panel_toogle_bound','true');
			$(e).bind('click',function(){
				if($(e).hasClass('active')){
					$(e).removeClass('active');
					__switchStatus(e);
				};
			});
		}
	};
};