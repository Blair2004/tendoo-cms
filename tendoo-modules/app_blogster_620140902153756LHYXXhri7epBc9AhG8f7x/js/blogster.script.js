// 
$(document).ready(function(){
	$('.creatingCategory').bind('click',function(){
		if($(this).parent().find('[addCategory]').length == 0)
		{
			var addCategory	=	
			'<div addCategory>'+
				'<form method="POST" fjaxson action="'+$('.creatingCategory').attr('data-form-url')+'">'+
					'<div class="input-group">'+
						'<input type="text" class="form-control" name="categoryName" placeholder="Entrez le nom de la cat&eacute;gorie">'+
						'<div class="input-group-btn">'+
							'<button class="submitCategory btn btn-primary" type="submit"><i class="fa fa-save"></i></button>'+
						'</div>'+
					'</div>'+
				'</form>'+
				'<br>'+
			'</div>';
			$(this).before(addCategory);
			$(this).text('Annuler');
			tendoo.formAjax.bind();
		}
		else
		{
			$(this).text('Ajouter une catégorie');
			$(this).parent().find('[addCategory]').remove();
		}
		var __creatingCategoryBinder	=	function(){
			$('.submitCategory').bind('click',function(){
				
			});
		};
	});
});