    <button type="button" class="tobr btn btn-sm btn-white">
        Boite de r&eacute;ception </button>
    <button type="button" class="tonew btn btn-sm btn-white">
        Ecrire un nouveau message 
	</button>
    <button type="button" class="todellconv btn btn-sm btn-white">
        Supprimer la conversation 
	</button>
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
				if(confirm('Voulez vous supprimer ce message ?'))
				{
					$('.small_app form').submit();
				}
			}
			else if($('.conv_id').length > 0)
			{
				if(confirm('Voulez vous supprimer ce message ?'))
				{
					$('.read_form_id').submit();
				}
			}
			else
			{
				alert('Selectionnez un message avant de le supprimer');
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
		'<div class="line"></div><div class="container"><div class="row"><div class="col-lg-10 col-lg-offset-1"><form method="post" class="panel-content reply_form">'+
			'<div class="form-group">'+
				'<textarea class="form-control" name="reply" placeholder="Ajouter un post">'+
				'</textarea>'+
				'<input type="hidden" name="convid" value="'+$('.conv_id').val()+'"/>'+
			'</div>'+
			'<input class="form-control btn btn-primary" type="submit" value="Poster"/>'+
		'</form></div></div></div><div class="line"></div>';
		$('.answer_btn').bind('click',function(){
			if($('.reply_form').length== 0)
			{
				$(field).insertBefore('.answer_table');
			}
			if(typeof $(this).attr('clicked') == 'undefined')
			{
				$(this).attr('clicked','TRUE');
				$('.reply_form').show();
			}
			else
			{
				if($(this).attr('clicked') == 'TRUE')
				{
					$(this).attr('clicked','FALSE');
					$('.reply_form').hide();
				}
				else
				{
					$(this).attr('clicked','TRUE');
					$('.reply_form').show();
				}
			}			
		});
	});
</script>