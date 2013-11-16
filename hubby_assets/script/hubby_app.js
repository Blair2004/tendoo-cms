// Hubby 0.9.2
var hubby				=	new Object();
	hubby.notice		=	new function() {
		var parent		=	'#appendNoticeHere';
		var countNotice	=	function(){
			return $(parent).find('.alert').length;
		};
		this.alert		=	function(showMsg,type){
			if(type	==	'success') 
			{
				title	=	'Effectu&eacute;';
				icon	=	'ok-sign';
			}
			else if(type	==	'warning')
			{
				title	=	'Attention';
				icon	=	'warning-sign';
			}
			else if(type	==	'danger')
			{
				title	=	'Erreur';
				icon	=	'remove-sign';
			}
			else
			{
				title	=	'Notification';
				icon	=	'eye-open';
			}
			var element	=	typeof type	==	'undefined' ? 'info' : type;
			var index	=	countNotice();
			$(parent).append('<div data-notice-index="'+index+'" class="alert alert-'+element+' alert-block"> <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button> <h4><i class="icon-'+icon+'"></i>'+title+'</h4> <p>'+showMsg+'</p> </div>');
		}
	};