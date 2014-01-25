// Tendoo 0.9.2
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
// 	Tendoo has already beend declared
$(document).ready(function(){
	if(typeof Tendoo.app  ==  'undefined'){ // Pour évider le conflict d'un double appel via AJAX
		Tendoo.zIndex		=	new function(){
			this.modal		=	10000;
			this.notice		=	15000;
			this.loader		=	16000;
			this.window		=	9500;
		};
		Tendoo.notice		=	new function() {
			var parent		=	'#appendNoticeHere';
			var noticeId	=	0;
			var getNewId	=	function(){
				return noticeId++;
			};
			if($(parent).length == 0)
			{
				$('body').append('<div id="appendNoticeHere" style="position:fixed;top:10px;right:10px;z-index:'+Tendoo.zIndex.modal+';width:20%;"/>');
			}
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
				var index	=	getNewId();
				$(parent).prepend('<div style="width:100%;float:right" data-notice-index="'+index+'" class="alert alert-'+element+' alert-block"> <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button> <h4><i class="icon-'+icon+'"></i>'+title+'</h4> <p>'+showMsg+'</p> </div>');
				$('[data-notice-index="'+index+'"]').hide().css({
					'margin-right'	:	- ($('[data-notice-index="'+index+'"]').width()+100)+'px',
					'opacity'		:	0
				}).show().animate({
					'margin-right' 	:	0,
					'opacity'		:	1
				});
				var timeOut;
				function launchTimeOut(){
					timeOut	=	setTimeout(function(){
						$('[data-notice-index="'+index+'"]').fadeOut(500,function(){
							 $(this).remove();
						});
					},10000);
				}
				$('[data-notice-index="'+index+'"]').hover(function(){
					clearTimeout(timeOut);
				});
				$('[data-notice-index="'+index+'"]').bind('mouseleave',function(){
					launchTimeOut();
				});
				launchTimeOut();
			}
		};
		Tendoo.modal			=	new function(){
			this.show		=	function(){
				var modal	=	'<div style="z-index:'+Tendoo.zIndex.modal+';display:block;width:100%;height:100%;position:absolute;top:0;left:0;background:rgba(76,85,102,0.5)">'+
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
		Tendoo.window		=	new function(){
			var ttWindows	=	0;
			this.getId		=	function(){
				return ttWindows++;
			};
			var title			=	'Modal Sans titre';
			var activateAjax	=	false;
			var icon			=	'';
			this.title		=	function(e){
				title	=	e;
				return this;
			}
			this.icon		=	function(e){
				icon	=	e;
				return this;
			};
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
								Tendoo.loader.show($('#loadingStatus'));
							},
							success	:	function(data){
								Tendoo.loader.remove($('#loadingStatus'));
								$(this).css({'visibility':'hidden'}).show(0);
								$(currentE).find('.modal-body').html(data);
								ajaxBinder(currentId);
							},
							url			:	$(this).attr('href'),
							type		:	'GET',
							dataTYpe	:	'html'
	
						});
						return false;
					});
				});
				$('[data-modal-id="'+currentId+'"]').find('form[action]').each(function(){
					if(typeof $(this).attr('event-binded') == 'undefined')
					{
						$(this).bind('submit',function(){
							$(this).attr('event-binded','true');
							var finalQuery = {};
							var datas = $(this).serializeArray();
							for (i = 0; i < datas.length; i++)
							{
								eval("finalQuery." + datas[i].name + ' = "' + datas[i].value + '"');
							}
							$.ajax({
								beforeSend	:	function(){
									Tendoo.loader.show($('#loadingStatus'));
								},
								success	:	function(returned){
									Tendoo.loader.remove($('#loadingStatus'));
									if(returned != '')
									{
										$(currentE).find('.modal-body').html(returned);
									}
									else
									{
										Tendoo.notice.alert('Le serveur a renvoy&eacute; un contenu vide','warning');
									}
									ajaxBinder(currentId);
									
								},
								url			:	$(this).attr('action'),
								type		:	'POST',
								dataType	:	'html',
								data		:	finalQuery,
								contentType	:	'application/x-www-form-urlencoded',
								processData	:	true
							});
							return false;
						});
					}
				});
			};
			this.show		=	function(e){
				var currentId	=	this.getId();
				var currentE	=	'[data-modal-id="'+currentId+'"]';
				var modal	=	'<div data-modal-id="'+currentId+'" style="z-index:'+Tendoo.zIndex.window+';display:block;width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(76,85,102,0.5);overflow:hidden">'+
									'<div class="modal-dialog" id="modalBox" style="width:'+parseInt(device.width-100)+'px;">'+
										'<div class="modal-content" style="-webkit-border-radius:2px;-moz-border-radius:2px;-ms-border-radius:2px">'+
											'<div class="modal-header bg-primary" style="border-bottom:solid 0px;">'+
												'<div type="button" style="opacity:1" class="close" data-dismiss="modal" aria-hidden="true">'+
													'<span type="button" class="btn btn-info btn-sm" data-reduce="modal" style="margin-right:10px;"><i class="icon-chevron-down"></i></span>'+
													'<span type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="icon-remove"></i></span>'+
												'</div>'+
												'<h4 class="modal-title">'+title+'</h4>'+
											'</div>'+
											'<div class="modal-body" style="height:'+parseInt(device.height-200)+'px;padding:0px;overflow:auto;width:100%;">'+
												e+
											'</div>'+
											'<div class="modal-footer bg-primary" style="margin-top:0;border-top:solid 0px;">'+
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
		Tendoo.app			=	new function(){
				$(document).ready(function(){
					$('.icon-grid .G-icon').each(function(){
					$(this).bind('click',function(){
						if(typeof $(this).attr('data-status') == 'undefined' || $(this).attr('data-status') == 'clickable')
						{
							$(this).attr('data-status','clicked');
							var $this		=	$(this);
							var iconRef		=	$(this).attr('data-icon-url');
							var windowRef	=	$(this).attr('data-url');
							var loadingStatus	=	
							'<div id="loadingStatus" style="z-index:'+Tendoo.zIndex.loader+';position:fixed;right:15px;bottom:10px;">'+
							'</div>';
							var object;
							$.ajax({
								beforeSend		:	function(jqXHR, settings){
									if($('#loadingStatus').length == 0)
									{
										$('body').append(loadingStatus);
									}
									object	=	Tendoo.loader.show($('#loadingStatus'));
									 $('#loadingStatus').hide().fadeIn(500);
								},
								complete		:	function(jqXHR, textStatus){
									
								},
								cache			:	false,
								success			:	function(data, textStatus, jqXHR){
									Tendoo.loader.remove($('#loadingStatus'));
									object		=	void(0);
									Tendoo.window.ajax(true).title('Nouvelle page').show(data);
									$this.attr('data-status','clickable');
								},
								dataType		:	'html',
								error			:	function(jqXHR, textStatus, errorThrown){
									$this.attr('data-status','clickable');
								},
								type			:	'GET',
								url				:	windowRef
							});
						}
					});
				});
			});
		};
		Tendoo.loader		=	new function(){
			this.show		=	function(x){
				var cSpeed=9;
				var cWidth=50;
				var cHeight=50;
				var cTotalFrames=32;
				var cFrameWidth=50;
				var cImageSrc=	Tendoo.url.main()+'Tendoo_assets/img/images/sprites.png';
				var cImageTimeout=false;
				
				function startAnimation(){
					
					$(x).html('<canvas id="canvas" width="'+cWidth+'" height="'+cHeight+'"><p>Your browser does not support the canvas element.</p></canvas>');
					//FPS = Math.round(100/(maxSpeed+2-speed));
					FPS = Math.round(100/cSpeed);
					SECONDS_BETWEEN_FRAMES = 1 / FPS;
					g_GameObjectManager = null;
					g_run=genImage;
			
					g_run.width=cTotalFrames*cFrameWidth;
					genImage.onload=function (){cImageTimeout=setTimeout(fun, 0)};
					initCanvas(cTotalFrames);
				}
				
				
				function imageLoader(s, fun)//Pre-loads the sprites image
				{
					clearTimeout(cImageTimeout);
					cImageTimeout=0;
					genImage = new Image();
					genImage.onload=function (){cImageTimeout=setTimeout(fun(), 0)};
					genImage.onerror=new Function('alert(\'Could not load the image\')');
					genImage.src=s;
				}
				//The following code starts the animation
				return new imageLoader(cImageSrc, startAnimation);
			};
			this.remove		=	function(x){
				$(x).find('canvas').fadeOut(500,function(){
					$(this).remove();
				});
			};
		};
		Tendoo.boot			=	new function(){
			var tASE	=	'#tendooAppStore'; // TENDOO APP STORE DOM BUTTON ELEMENT
			$(tASE).bind('click',function(){
				Tendoo.notice.alert('Indisponible pour le moment.','info');
			});
		};
	}
});