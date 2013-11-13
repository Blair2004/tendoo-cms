<input type="button" value="Boite de r&eacute;ception" class="tobr bg-color-blue fg-color-white" />
<input type="button" value="Ecrire un nouveau message" class="tonew bg-color-greenLight fg-color-white" />
<input type="button" value="Supprimer la conversation" class="todellconv bg-color-red fg-color-white" />
<script>
	$(document).ready(function(){
		$('.small_app tbody').find('tr').each(function(){
			$(this).find('input[type="checkbox"]').attr('isChecked','false');
			$(this).bind('click',function(){
				if($(this).find('input[type="checkbox"]').attr('isChecked') == 'true')
				{
					$(this).find('input[type="checkbox"]').removeAttr('checked');
					$(this).find('input[type="checkbox"]').attr('isChecked','false');
				}
				else
				{
					$(this).find('input[type="checkbox"]').attr('checked','checked');
					$(this).find('input[type="checkbox"]').attr('isChecked','true');
				}
			});
			$(this).bind('dblclick',function(){
				document.location	=	'<?php echo $this->core->url->site_url(array('account','messaging','open'));?>/'+$(this).find('input[type="checkbox"]').attr('value');
			});
		});
		$('.tobr').bind('click',function(){
			document.location	=	'<?php echo $this->core->url->site_url(array('account','messaging','home'));?>';
		});
		$('.tonew').bind('click',function(){
			document.location	=	'<?php echo $this->core->url->site_url(array('account','messaging','write'));?>';
		});
		$('.todellconv').bind('click',function(){
			if($('.small_app tbody').find('input[isChecked="true"]').length > 0)
			{
				$.Dialog({
					'title' 		: 'Confirmer votre action',
					'content' 		: '<div style="max-width:500px">En supprimant cette discussion, vous ne pourrez plus acc&eacute;der aux diff&eacute;rents messages qui ont &eacute;t&eacute; post&eacute; depuis. Cette action est irreversible.</div>',
					'draggable' 	: true,
					'overlay' 		: true,
					'closeButton' 	: true,
					'buttonsAlign'	: 'right',
					'keepOpened' 	: true,
					'buttons' 		: {
						'Confirmer' 		: {
							'action': function(){
								$('.small_app form').submit();
							}
						},
						'Annuler' 		: {
							'action': function(){}
						}
					}
				});
			}
			else if($('.conv_id').length > 0)
			{
				$.Dialog({
					'title' 		: 'Confirmer votre action',
					'content' 		: '<div style="max-width:500px">En supprimant cette discussion, vous ne pourrez plus acc&eacute;der aux diff&eacute;rents messages qui ont &eacute;t&eacute; post&eacute; depuis. Cette action est irreversible.</div>',
					'draggable' 	: true,
					'overlay' 		: true,
					'closeButton' 	: true,
					'buttonsAlign'	: 'right',
					'keepOpened' 	: true,
					'buttons' 		: {
						'Confirmer' 		: {
							'action': function(){
								$('.read_form_id').submit();
							}
						},
						'Annuler' 		: {
							'action': function(){}
						}
					}
				});
			}
			else
			{
				$.Dialog({
					'title' 		: 'Erreur',
					'content' 		: '<div style="max-width:500px">Vous ne pouvez pas supprimer une discution, si aucun message n\'est selectionn&eacute;.</div>',
					'draggable' 	: true,
					'overlay' 		: true,
					'closeButton' 	: true,
					'buttonsAlign'	: 'right',
					'keepOpened' 	: true,
					'buttons' 		: {
						'Fermer' 		: {
							'action': function(){}
						}
					}
				});
			}
		});
		$('.this').bind('mouseup',function(){
			if($(this).attr('checked')	== 'checked')
			{
				$('.small_app tbody').find('input[type="checkbox"]').trigger('click');
				$('.small_app tbody').find('input[type="checkbox"]').removeAttr('checked');
			}
			else
			{
				$('.small_app tbody').find('input[type="checkbox"]').trigger('click');
				$('.small_app tbody').find('input[type="checkbox"]').attr('checked','checked');
			}
		});
		var field	=	
		'<form method="post" class="reply_form">'+
			'<fieldset class="bg-color-blueLight">'+
				'<div class="input-control textarea">'+
					'<textarea name="reply" placeholder="Ajouter un post">'+
					'</textarea>'+
					'<input type="hidden" name="convid" value="'+$('.conv_id').val()+'"/>'+
				'</div>'+
				'<input type="submit" value="Poster"/>'+
			'</fieldset><br>'+
		'</form>';
		$('.answer_btn').toggle(function(){
			if($('.reply_form').length== 0)
			{
				$(field).insertBefore('.answer_table');
			}
			$('.reply_form').show();
		},function(){
			if($('.reply_form').length== 0)
			{
				$(field).insertBefore('.answer_table');
			}
			$('.reply_form').hide();
		});
	});
</script>