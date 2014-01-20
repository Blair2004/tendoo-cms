// Hubby 0.9.2
var device 								= {};
    	device.height 						= window.innerHeight;
    	device.width 						= window.innerWidth;
    	device.widthIs						= function(min, max) {
        if (device.width >= min && device.width <= max){
            return true
		}
    };
var tools				=	new Object();
	tools.centerThis 	= function(concerned, parent, toScreen) {
			if (tools.isDefined(toScreen)) {
				var parentWidth = device.width;
				var parentHeight = device.height;
				var concernedWidth = $(concerned).outerWidth();
				var concernedHeight = $(concerned).outerHeight();
				var leftPosition = (parentWidth - concernedWidth) / 2;
				var topPosition = (parentHeight - concernedHeight) / 2;
				$(concerned).css({"position": "absolute","left": leftPosition + "px","top": topPosition + "px"})
			} else {
				var parentWidth = $(parent).outerWidth();
				var parentHeight = $(parent).outerHeight();
				var concernedWidth = $(concerned).outerWidth();
				var concernedHeight = $(concerned).outerHeight();
				var leftPosition = (parentWidth - concernedWidth) / 2;
				var topPosition = (parentHeight - concernedHeight) / 2;
				$(concerned).css({"position": "absolute","left": leftPosition + "px","top": topPosition + "px"})
			}
		};
var hubby				=	new Object();
	hubby.zIndex		=	new function(){
		this.modal		=	10000;
		this.notice		=	15000;
		this.loader		=	9000;
	};
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
	hubby.modal			=	new function(){
		this.show		=	function(){
			var modal	=	'<div style="z-index:'+hubby.zIndex.modal+';display:block;width:100%;height:100%;position:absolute;top:0;left:0;background:rgba(76,85,102,0.5)">'+
								'<div class="modal-dialog">'+
        							'<div class="modal-content">'+
          								'<div class="modal-header">'+
            								'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
            								'<h4 class="modal-title">Modal title</h4>'+
         								'</div>'+
										'<div class="modal-body">'+
											'<p>One fine body&hellip;</p>'+
										'</div>'+
										'<div class="modal-footer">'+
											'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
											'<button type="button" class="btn btn-primary">Save changes</button>'+
										'</div>'+
									'</div>'+
								'</div>'+
    						'</div>';
			$('body').append(modal);
		};
	};
	hubby.window		=	new function(){
		var ttWindows	=	0;
		this.getId		=	function(){
			return ttWindows++;
		};
		var title			=	'Modal Sans titre';
		var activateAjax	=	false;
		var loader	='<div class="progress progress-striped active" style="margin-bottom:0px;visibility:hidden">'+
						 ' <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">'+
						 ' </div>'+
					'</div>';

		this.title		=	function(e){
			title	=	e;
			return this;
		}
		this.ajax		=	function(e){
			activateAjax	=	e;
			return this;
		};
		var	ajaxBinder	=	function(currentId){
			var currentE	=	'[data-modal-id="'+currentId+'"]';
			$('[data-modal-id="'+currentId+'"]').find('a[href]').each(function(){
				$(this).bind('click',function(){
					$.ajax({
						beforeSend	:	function(){
							$(currentE).find('.progress').hide().css({'visibility':'visible'}).fadeIn(500);
						},
						success	:	function(data){
							$(currentE).find('.progress').fadeOut(500,function(){
								$(this).css({'visibility':'hidden'}).show(0);
								$(currentE).find('.modal-body').html(data);
								ajaxBinder(currentId);
							});
						},
						url			:	$(this).attr('href'),
						type		:	'GET',
						dataTYpe	:	'html'

					});
					return false;
				});
			});
			$('[data-modal-id="'+currentId+'"]').find('form[action]').each(function(){
				$(this).bind('submit',function(){
					var finalQuery = {};
					var datas = $(this).serializeArray();
					for (i = 0; i < datas.length; i++)
					{
						eval("finalQuery." + datas[i].name + ' = "' + datas[i].value + '"');
					}
					$.ajax({
						beforeSend	:	function(){
							$(currentE).find('.progress').hide().css({'visibility':'visible'}).fadeIn(500);
						},
						success	:	function(data){
							$(currentE).find('.progress').fadeOut(500,function(){
								$(this).css({'visibility':'hidden'}).show(0);
								$(currentE).find('.modal-body').html(data);
								ajaxBinder(currentId);
							});
						},
						url			:	$(this).attr('action'),
						type		:	'POST',
						dataType	:	'html',
						data		:	finalQuery,
						contentType	:	'multipart/form-data'
					});
					return false;
				});
			});
		};
		this.show		=	function(e){
			var currentId	=	this.getId();
			var currentE	=	'[data-modal-id="'+currentId+'"]';
			var modal	=	'<div data-modal-id="'+currentId+'" style="z-index:'+hubby.zIndex.modal+';display:block;width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(76,85,102,0.5);overflow:hidden">'+
								'<div class="modal-dialog" id="modalBox" style="width:'+parseInt(device.width-100)+'px;">'+
        							'<div class="modal-content">'+
          								'<div class="modal-header">'+
            								'<div type="button" class="close" data-dismiss="modal" aria-hidden="true">'+
												'<span type="button" class="btn btn-info btn-sm" data-reduce="modal" style="margin-right:10px;"><i class="icon-chevron-down"></i></span>'+
												'<span type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="icon-remove"></i></span>'+
											'</div>'+
            								'<h4 class="modal-title">'+title+'</h4>'+
         								'</div>'+
										'<div class="modal-body" style="height:'+parseInt(device.height-200)+'px;padding:10px;overflow:auto;width:100%;">'+
											e+
										'</div>'+
										'<div class="modal-footer">'+loader
										'</div>'+
									'</div>'+
								'</div>'+
    						'</div>';
			$('body').append(modal);
			if(activateAjax == true){
				ajaxBinder(currentId);
			};
			$('[data-modal-id="'+currentId+'"]').find('[data-dismiss="modal"] [data-dismiss="modal"]').bind('click',function(){
				$('#modalBox').fadeOut(0,function(){
					$('[data-modal-id="'+currentId+'"]').remove();
				})
			});
		};
	};
	hubby.app			=	new function(){
			$(document).ready(function(){
				$('.icon-grid .G-icon').each(function(){
				$(this).bind('click',function(){
					var iconRef		=	$(this).attr('data-icon-url');
					var windowRef	=	$(this).attr('data-url');
					var progressBar	=	'<div style="z-index:'+hubby.zIndex.loader+';position:fixed;bottom:15px;width:100%;">'+
											'<div class="progress progress-striped active" id="loadingBar" style="width:80%;margin:0 10%;">'+
											  '<div class="progress-bar"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">'+
												'<span class="sr-only">45% Complete</span>'+
											  '</div>'+
											'</div>'+
										'</div>';
					$.ajax({
						beforeSend		:	function(jqXHR, settings){
							// $('body').append(progressBar);
						},
						complete		:	function(jqXHR, textStatus){
							
						},
						cache			:	false,
						success			:	function(data, textStatus, jqXHR){
							hubby.window.ajax(true).title('Nouvelle page').show(data);
						},
						dataType		:	'html',
						error			:	function(jqXHR, textStatus, errorThrown){
						},
						type			:	'GET',
						url				:	windowRef
					});
				});
			});
		});
	};
