$(document).ready(function(){
	tendoo.controllers	=	new function(){
		__getRootPrev		=	function(currentRow){
			var prev	=	$(currentRow).prevAll();
			var realPrev=	null;
			for(i=0;i<prev.length;i++)
			{
				var title	=	$(prev[i]).attr('title');
				if(title	==	'racine')
				{
					realPrev	=	$(prev[i]);
					break;
				}
			}
			return realPrev;
		};
		__getChilren		=	function(r){
			var next	=	$(r).nextAll();
			var finalChilds	=	[];
			for(i=0;i<next.length;i++)
			{
				var title	=	$(next[i]).attr('title');
				if(typeof title	== 'undefined')
				{
					finalChilds.push($(next[i]));
				}
				else
				{
					break; // il n'y a plus d'enfant a copier.
				}
			}
			return finalChilds;
		};
		__moveChildrenTo		=	function(c,e){
			for(i=c.length;i>=0;i--)
			{
				$(c[i]).insertAfter($(e));
			}			
		};
		var upIcon	=	'<i class="icon-level-up" style="font-size:15px;"></i>';
		$('#controllersList').find('.upTaker').bind('click',function(){
			var row		=	$(this).closest('tr[title="racine"]');
			var childs	=	__getChilren(row);
			var realPrev	=	__getRootPrev(row);
			
			var prev2	=	__getRootPrev(realPrev);
			var upTaker	=	$(this);
			//$(childs).fadeOut(100);
			$(row).fadeOut(100,function(){
				$(this).insertBefore($(realPrev));
				$(this).fadeIn(200);
				// childs
				__moveChildrenTo(childs,this);
				childs	=	__getChilren(this);
				$(childs).fadeIn(500);
				// end childs
				$(realPrev).find('.upTaker').html(upIcon);
				$(realPrev).find('[data-requestType="silent"]').removeAttr('silent-ajax-event');
				if($(prev2).length == 0)
				{
					$(upTaker).attr('silent-ajax-event','lock'); // lock ajax event
					$(upTaker).html('---');
				}
			});
		});
	}
});