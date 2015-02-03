// Tendoo 0.9.2
/**
*	Device Object : 
*	Cet objet permet de récuperé les dimensions de l'écran de l'appareil. "device.height" pour la hauteur, "device.width" pour la largeur.
*	device.widthIs renvoie "true" si la largeur de l'écran est comprise entre la largeur minimal et maximal.
**/
var device 								= {};
    	device.height 						= window.innerHeight;
    	device.width 						= window.innerWidth;
    	device.widthIs						= function(min, max) {
			if (device.width >= min && device.width <= max){
				return true
			}
			return false;
		};
/**
*  Tools Object:
*		tools.isDefined : renvoi "true" ou "false" à la question de savoir si une variable est définie.
**/
var tools				=	new Object();
    tools.isDefined     =   function(e){
        return typeof e == 'undefined' ? false : true;
    };
/**
*		tools.isDefinedOrLike : renvoi "true" ou "false" à la question de savoir si une variable est définie ou est comparable au deuxième paramètre.
**/
	tools.isDefinedOrLike=	function(e,f){
		if(!tools.isDefined(e))
		{
			if(e == f)
			{
				return true;
			}
			return false;
		}
		return true
	};
/**
*		tools.centerThis : permet de centrer un objet jQuery (element DOM) au milieu d'un élément "parent" ou par rapport à l'écran.
		concerned : Objet jQuery à centrer.
		parent: objet Jquery, parent de l'élément à centrer.
		toScreen: "true" pour centrer un élément par rapport à l'écran. 
**/
	tools.centerThis 	= 	function(concerned, parent, toScreen) {
			if (!tools.isDefined(toScreen)) {
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
/**
*		tools.inArray : Permet de déterminé si le premier parametre se trouve dans le tableau qui est le deuxième parametres.
**/
	tools.inArray		= 	function(e,array){
		for(i=0;i<array.length;i++)
		{
			if(e == array[i])
			{
				return true;
			}
		}
		return false;
	};
	// 	Tendoo has already beend declared
$(document).ready(function(){
	if(typeof tendoo.app  ==  'undefined'){ // Pour évider le conflict d'un double appel via AJAX
		tendoo.zIndex		=	new function(){
			this.modal		=	10000;
			this.notice		=	15000;
			this.loader		=	16000;
			this.window		=	9500;
			this.draggable	=	9000;
		};
		/**
		*		tools.notice : Permet d'afficher les notification en haut à droite de l'écran.
					a pour méthode ".alert([message à afficher],[format de l'alerte]);
					l'alerte peut avoir pour format (success,warning,danger).
		**/
		tendoo.notice		=	new function(){
			var parent		=	'#appendNoticeHere';
			var noticeId	=	0;
			var etimeOut	=	null;
			var getNewId	=	function(){
				return noticeId++;
			};
			if($(parent).length == 0)
			{
				$('body').append('<div id="appendNoticeHere" style="position:fixed;top:10px;right:10px;z-index:'+tendoo.zIndex.modal+';width:20%;"/>');
			}
			/*
				this.timeout	: Définit une durée d'affichage de la notification
			*/
			this.timeout	=	function(e){
				etimeOut	=	e;
				return this;
			}
			this.alert		=	function(showMsg,type){
				if(type	==	'success') 
				{
					title	=	'Effectu&eacute;';
					icon	=	'check';
				}
				else if(type	==	'warning')
				{
					title	=	'Attention';
					icon	=	'warning';
				}
				else if(type	==	'danger')
				{
					title	=	'Erreur';
					icon	=	'ban';
				}
				else
				{
					title	=	'Notification';
					icon	=	'eye';
				}
				var element	=	typeof type	==	'undefined' ? 'info' : type;
				var index	=	getNewId();
				$(parent).prepend('<div style="width:100%;float:right" data-notice-index="'+index+'" class="alert alert-'+element+' alert-block"> <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button> <h4><i class="fa fa-'+icon+'"></i> '+title+'</h4> <p>'+showMsg+'</p> </div>');
				$('[data-notice-index="'+index+'"]').hide().css({
					'margin-right'	:	- ($('[data-notice-index="'+index+'"]').width()+100)+'px',
					'opacity'		:	0
				}).show().animate({
					'margin-right' 	:	0,
					'opacity'		:	1
				});
				$('[data-dismiss="alert"]').bind('click',function(){
					$(this).closest('[data-notice-index="'+index+'"]').fadeOut(500,function(){
						$(this).remove();
					});
				});
				var timeOut;
				function launchTimeOut(){
					if(etimeOut)
					{
						timeout	=	etimeOut;
					}
					else
					{
						timeout	=	3000; // le timeout n'est pas expressément définit.
					}
					timeOut	=	setTimeout(function(){
						$('[data-notice-index="'+index+'"]').fadeOut(500,function(){
							 $(this).remove();
						});
					},timeout);
					// Attribue Null à la variable etimeOut, pour les prochaines notification.
					etimeOut	=	null;
				}
				$('[data-notice-index="'+index+'"]').hover(function(){
					clearTimeout(timeOut);
				});
				$('[data-notice-index="'+index+'"]').bind('mouseleave',function(){
					launchTimeOut(etimeOut);
				});
				launchTimeOut(etimeOut);
				
			}
		};
		/**
				tendoo.modal	: Permet d'afficher une boite modale permanente soit d'alerte soit de confirmation.
					.alert([message])
					.confirm([message],callback)
		**/
		tendoo.modal		=	new function(){ 
			var count		=	0;
			var confirmTitle=	'Confirmez votre action';
			var alertTitle	=	'Attention';
			var getId		=	function(){
				return count++;
			};
			this.show		=	function(){
				var id		=	getId();
				var modal	=	'<div modal_id="'+id+'" style="z-index:'+tendoo.zIndex.modal+';display:block;width:100%;height:100%;position:absolute;top:0;left:0;background:rgba(76,85,102,0.5)">'+
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
			this.confirm	=	function(msg,f){
				var id		=	getId();
				var modal	=	'<div modal_id="'+id+'" id="confirm_box" style="z-index:'+tendoo.zIndex.modal+';display:block;width:100%;height:100%;position:absolute;top:0;left:0;background:rgba(76,85,102,0.5)">'+
									'<div class="modal-dialog">'+
										'<div class="modal-content">'+
											'<div class="modal-header">'+
												'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
												'<h4 class="modal-title">'+confirmTitle+'</h4>'+
											'</div>'+
											'<div class="modal-body">'+
												'<p>'+msg+'</p>'+
											'</div>'+
											'<div class="modal-footer">'+
												'<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>'+
												'<button type="button" data-confirm="modal" class="btn btn-primary">Confirmer</button>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';
				$('body').append(modal);
				$('[modal_id="'+id+'"]').find('[data-dismiss="modal"]').bind('click',function(){
					$('[modal_id="'+id+'"]').find('.modal-dialog').fadeOut(500,function(){
						$('[modal_id="'+id+'"]').remove();
					});
				});
				$('[modal_id="'+id+'"]').find('[data-confirm="modal"]').bind('click',function(){
					$('[modal_id="'+id+'"]').find('.modal-dialog').fadeOut(500,function(){
						$('[modal_id="'+id+'"]').remove();
						f(); // execute la fonction en parametre.
					});
				});
				
			}
			this.alert		=	function(msg){
				var id		=	getId();
				var modal	=	'<div modal_id="'+id+'" id="alert_box" style="z-index:'+tendoo.zIndex.modal+';display:block;width:100%;height:100%;position:absolute;top:0;left:0;background:rgba(76,85,102,0.5)">'+
									'<div class="modal-dialog">'+
										'<div class="modal-content">'+
											'<div class="modal-header">'+
												'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
												'<h4 class="modal-title">'+alertTitle+'</h4>'+
											'</div>'+
											'<div class="modal-body">'+
												'<p>'+msg+'</p>'+
											'</div>'+
											'<div class="modal-footer">'+
												'<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';
				$('body').append(modal);
				$('[modal_id="'+id+'"]').find('[data-dismiss="modal"]').bind('click',function(){
					$('[modal_id="'+id+'"]').find('.modal-dialog').fadeOut(500,function(){
						$('[modal_id="'+id+'"]').remove();
					});
				});
			}
			this.alertTitlte=	function(e){
				alertTitle			=	e;
				return this;
			}
			this.confirmTitle=	function(e){
				confirmTitle		=	e;
				return this;
			}
			this.alertTitle=	function(e){
				alertTitle		=	e;
				return this;
			}
			this.dismiss	=	function(){
				$('.modal-dialog').find('[data-dismiss="modal"]').trigger('click');
			};
		};
		/**
		*		tools.window : Permet d'afficher une boite modale sur une page. A pour méthodes.
					".title([titre de la boite modale])"
					".icon([icône de la boite modale])" // utiliser les icones fontawesome.
					".ajax([true ou false pour activer ajax dans la boite modale])"
					".show([contenu de la boite modale])"
		**/
		tendoo.window		=	new function(){
			var ttWindows	=	0;
			this.getId		=	function(){
				return ttWindows++;
			};
			var title			=	'Modal Sans titre';
			var activateAjax	=	false;
			var icon			=	'';
			var modalWidth		= device.width;
			var modalHeight		= device.height;
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
			var openBy		=	"normal";
			var openTimeout	=	500;
			var closeBy		=	"normal";
			var closeTimeout=	300;
			this.openBy		=	function(action){ // Scale-in, Scale-out
				openBy		=	action;
				return this;
			};
			this.closeBy	=	function(action){ // Scale-in, Scale-out
				closeBy		=	action;
				return this;
			};
			var	ajaxBinder		=	function(currentId){
				var currentE	=	'[data-modal-id="'+currentId+'"]';
				$('[data-modal-id="'+currentId+'"]').find('a[href!="#"]').each(function(){
					if(typeof $(this).attr('ajax_binder_escapeThis') === 'undefined')
					{
					$(this).bind('click',function(){
						$.ajax({
							beforeSend	:	function(){
								tendoo.loader.display();
							},
							success	:	function(data){
								tendoo.loader.hide();
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
					}
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
									tendoo.loader.display();
								},
								success	:	function(returned){
									tendoo.loader.hide();
									if(returned != '')
									{
										$(currentE).find('.modal-body').html(returned);
									}
									else
									{
										tendoo.notice.alert('Le serveur a renvoy&eacute; un contenu vide','warning');
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
			this.size			=	function(width,height){ // modifier la taille de la boite modal, remplacera les valeurs device.height et device.width
				modalWidth	=	width;
				modalHeight	=	height;
				return this;
			};
			this.restoreSize	=	function(){
				modalWidth	=	device.width;
				modalHeight	=	device.height;
			}
			var addOverlay		=	function(overlayID){
				if($('body').find('[modal-window-overlay]').length == 0)
				{
					$('body').append('<div data-overlay-id="'+overlayID+'" style="z-index:'+parseInt(tendoo.zIndex.window)+';display:block;width:100%;height:100%;position:fixed;top:0;left:0;background:rgba(76,85,102,0.5);"/>');
				}
				else
				{
					$('[data-overlay-id]').attr('data-overlay-id', overlayID);
				}
			};
			var	removeOverlay	=	function(overlayID){
				$('[data-overlay-id="'+overlayID+'"]').remove();
			};
			this.show		=	function(e){
				var currentId	=	this.getId();
				var currentE	=	'[data-modal-id="'+currentId+'"]';
				addOverlay(currentId);
				var modal	=	'<div data-modal-id="'+currentId+'" style="z-index:'+tendoo.zIndex.window+';display:block;width:100%;height:100%;position:fixed;top:0;left:0;overflow:hidden">'+
									'<div class="modal-dialog" id="modalBox" style="width:'+parseInt(modalWidth-50)+'px;">'+
										'<div class="modal-content" style="-webkit-border-radius:2px;-moz-border-radius:2px;-ms-border-radius:2px">'+
											'<div class="modal-header bg-primary" style="border-bottom:solid 0px;">'+
												'<div type="button" style="opacity:1" class="close" data-dismiss="modal" aria-hidden="true">'+
													/* '<span type="button" class="btn btn-info btn-sm" data-reduce="modal" style="margin-right:10px;"><i class="icon-chevron-down"></i></span>'+ */
													'<span type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></span>'+
												'</div>'+
												'<h4 class="modal-title">'+title+'</h4>'+
											'</div>'+
											'<div class="modal-body" style="height:'+parseInt(modalHeight-120)+'px;padding:0px;overflow:auto;width:100%;">'+
												e+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';
				$('body').append(modal);
				if(openBy != 'normal')
				{
					if(openBy == 'scale-in')
					{
						$('[data-modal-id="'+currentId+'"]').find('.modal-dialog').transit({
							opacity	:	0,
							scale	:	0.75
						},0).transit({
							opacity	:	1,
							scale	:	1
						},openTimeout);
					}
					if(openBy == 'scale-out')
					{
						$('[data-modal-id="'+currentId+'"]').find('.modal-dialog').transit({
							opacity	:	0,
							scale	:	1.25
						},0).transit({
							opacity	:	1,
							scale	:	1
						},openTimeout);
					}
				}
				if(activateAjax == true){
					ajaxBinder(currentId);
				};
				$('[data-modal-id="'+currentId+'"]').find('[data-dismiss="modal"]').bind('click',function(){
					var closeWindow	=	function(){
						$('*[data-modal-id="'+currentId+'"] #modalBox').fadeOut(0,function(){
							$('[data-modal-id="'+currentId+'"]').remove();
						})
					};
					if(closeBy != 'normal')
					{
						if(closeBy == 'scale-in')
						{
							$('[data-modal-id="'+currentId+'"]').find('.modal-dialog').transit({
								opacity	:	0,
								scale	:	0.75
							},closeTimeout,function(){
								closeWindow();
								removeOverlay(currentId);
							});
						}
						if(closeBy == 'scale-out')
						{
							$('[data-modal-id="'+currentId+'"]').find('.modal-dialog').transit({
								opacity	:	0,
								scale	:	1.25
							},closeTimeout,function(){
								closeWindow();
								removeOverlay(currentId);
							})
						}
					}
					else
					{
						closeWindow();
						removeOverlay(currentId);
					}
				});
				this.restoreSize();
				return $('[data-modal-id="'+currentId+'"]');
			};
		};
		/**
		*		tools.app : // Bientôt déprécié.
		**/
		tendoo.app			=	new function(){
			this.bind		=	function(){
				$(document).ready(function(){
					$('.icon-grid .tendoo-icon-set').each(function(){
						$(this).bind('click',function(){
							if(typeof $(this).attr('tendoo_app_binded') == 'undefined')
							{
								$(this).attr('tendoo_app_binded','true');
								if(typeof $(this).attr('data-status') == 'undefined' || $(this).attr('data-status') == 'clickable')
								{
									window.location	=	$(this).attr('data-url');
									return; 
									// Were no more handling ajax modal boxes
									$(this).attr('data-status','clicked');
									var $this		=	$(this);
									var iconRef		=	$(this).attr('data-icon-url');
									var windowRef	=	$(this).attr('data-url');
									var title		=	$(this).attr('modal-title') ? $(this).attr('modal-title') : "Page Sans Titre";
									var object;
									$.ajax({
										beforeSend		:	function(jqXHR, settings){
											tendoo.loader.display();
										},
										complete		:	function(jqXHR, textStatus){
										},
										cache			:	false,
										success			:	function(data, textStatus, jqXHR){
											tendoo.loader.hide();
											object		=	void(0);
											tendoo.window.ajax(true).title(title).show(data);
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
							}
						});
					});
				});
			};
			this.bind();
		};
		/**
		*		tools.loader : Cette méthode affiche un indice de chargement AJAX dans les pages qui dispose d'espace spécifié pour l'élément.
		**/
		tendoo.loader		=	new function(){
			this.show		=	function(x,obj){
				var cSpeed=9;
				var cWidth=50;
				var cHeight=50;
				var cTotalFrames=32;
				var cFrameWidth=50;
				var cImageSrc=	tendoo.url.main()+'tendoo-assets/img/images/sprites.png';
				var cImageTimeout=false;
				if(typeof obj != 'undefined')
				{
					var cSpeed			=	obj.cSpeed 			? obj.cSpeed : 9
					var cWidth			=	obj.cWidth 			? obj.cWidth : 50
					var cHeight			=	obj.cHeight 		? obj.cHeight : 50
					var cTotalFrames	=	obj.cTotalFrames 	? obj.cTotalFrames : 32
					var cFrameWidth		=	obj.cFrameWidth 	? obj.cFrameWidth : 50
					var cImageSrc		=	obj.cImageSrc 		? obj.cImageSrc : tendoo.url.main()+'tendoo-assets/img/images/sprites.png';
					var cImageTimeout	=	obj.cImageTimeout 	? obj.cImageTimeout : 50
				}
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
					genImage.onload=function (){cImageTimeout=setTimeout(function(){
					fun()
					}, 0)};
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
			this.display	=	function(){
				$('#ajaxLoading').css({'visibility':'visible','opacity':1}).fadeIn(500);
			};
			this.dontdisplay=	function(){
				$('#ajaxLoading').css({
					'visibility'	:	'hidden'
				});
			};
			this.hide		=	function(){
				$('#ajaxLoading').animate({
					'opacity'	:	0
				});
			};
			// By default.
			if($('#ajaxLoading').length > 0)
			{
				this.show('#ajaxLoading',{
					cHeight		:	30,
					cWidth		:	30,
					cFrameWidth	:	30
				});
				this.dontdisplay();
			}
		};
		/**
		*		tendoo.boot : Démarrage du script.
		**/	
		tendoo.boot			=	new function(){
			var tASE	=	'#tendooAppStore'; // TENDOO APP STORE DOM BUTTON ELEMENT
			// var tTab	=	'.showAppTab'; // Tendoo Tab, panel d'application disponible partout.
			$(tASE).bind('click',function(){
				tendoo.notice.alert('Indisponible pour le moment.','info');
				tendoo.loader.display();
				setTimeout(function(){
					tendoo.loader.hide();
				},2000);
			});
			/*$(tTab).bind('click',function(){
				tendoo.tab.show();
			});*/
			if($(tASE).length > 0)
			{
				$.ajax(tendoo.url.base_url()+'admin/ajax/store_connect');
				$.ajax(tendoo.url.base_url()+'admin/ajax/check_updates');
			}
			var interval 	=	setInterval(function(){
				if($('.alert').length > 0)
				{
					$('.alert').find('button[class="close"]').bind('click',function(){
						$(this).closest('.alert').fadeOut(500,function(){
							$(this).remove();
						});
					});
				}
				if($('[dismissmodal]').length > 0)
				{
					if(!tools.isDefined($('[dismissmodal]').attr('binded')))
					{
						$('[dismissmodal]').bind('click',function(){
							tendoo.modal.dismiss();
						});
					}
				}
			},500);
			$(document).keypress(function(event){
				// Ferme toutes les boites modales ouvertes.
				if(event.which == 0)
				{
					tendoo.modal.dismiss();
				}
			});
		};
		/**
		/**
		*		tendoo.doAction		: Effectue une requete AJAX en attente d'un format JSON
		**/
		tendoo.doAction		=	function(url,callback,object){
			$.ajax(url,{
				beforeSend	:	function(e){
					tendoo.loader.show();
				},
				success		:	function(e){
					tendoo.loader.hide();
					callback(e);
				},
				dataType	:	'json',
				type		:	"POST",
				data		:	object
			})
		}
		/**
		*		tendoo.triggerAlert	: Exécute une réponse JSON et génère le cas échéant une erreur
		**/
		tendoo.triggerAlert=	function(object){
			if(object.alertType	==	'notice'){
				if(_.inArray(object.status,['warning','success','danger','info']))
				{
					tendoo.notice.alert(object.message,object.status);
				}			
			};
			if(object.alertType	==	'modal'){
				if(_.inArray(object.status,['warning','success','danger','info']))
				{
					tendoo.modal.alert(object.message,object.status);
				}			
			};
		};			
		/**
				tendoo.dropDown : Attache un évènement afin de transformer le dropdown du twitter bootstrap en un réel input de type select. 
				Le button d'avoir avoir pour attribut "select" et les sélections doivent avoir comme attribut "value" afin que la valeur soit récupérée et attribuée au champ masqué. Tendoo. 0.9.8
		**/
		tendoo.dropdown		=	new function(){
			this.bind		=	function(){
				$('[data-toggle="dropdown"][select]').each(function(){
					if(typeof $(this).attr('dropdown-binded') == 'undefined')
					{
						$(this).attr('dropdown-binded','true');
						// Ajout d'un élément caché qui servira d'imput à la place du button.
						$(this).after('<input type="hidden" class="button_hidden" name="'+$(this).attr('name')+'">');
						// 
						var thisName	=	$(this).attr('name');
						var inputSource	=	$(this);
						var inputHead	=	$(this).next('[name="'+thisName+'"]');
						var defaulValue	=	$(this).text();
						//
						$(this).removeAttr('name');
						// $(this).next('ul[class="dropdown-menu"]').prepend('<li><a value="" href="#">'+defaulValue+'</a></li>');
						$(this).parent().find('ul[class="dropdown-menu"]').find('li a[value]').each(function(){
							$(this).bind('click',function(){
								$(inputSource).text($(this).text());
								$(inputHead).val($(this).attr('value'));
							});
						});
					}
				});
			}
			this.bind();
		}
		/**
		*		tendoo.tableMultiSelect	: Permet d'attacher un évènement de selection dans un tableau <table> donc l'attribut tableMultiSelect est définie.
		**/
		tendoo.tableMultiSelect	=	new function(){
			this.bind		=	function(){
				$('table[tableMultiSelect]').each(function(){
					if(!tools.isDefined($(this).attr('binded')))
					{
						var isOverCheckBox	=	false;
						$(this).attr('binded','true');
						$(this).find('tbody tr input[type="checkbox"]').mouseenter(function(){
							isOverCheckBox	=	true;
						});
						$(this).find('tbody tr input[type="checkbox"]').mouseleave(function(){
							isOverCheckBox	=	false;
						});
						$(this).find('tbody tr').bind('click',function(){
							if(!isOverCheckBox)
							{
								$(this).find('input[type="checkbox"]').trigger('click');
							}
						});
						$(this).find('thead tr input').bind('click',function(){
							$(this).closest('table').find('tbody input[type="checkbox"]').trigger('click');
						});
					}
				})
			}
			this.bind();
		};
		/**
		*		tendoo.bulkselect		: Attache un évènement de selection sur des éléments hors formulaire et les insères en tant que champ de type "hidden", 
				avec les valeurs sélectionnées.
		**/
		tendoo.bulkSelect		=	new function(){
			this.bind			=	function(){
				$('[bulkSelect]').each(function(){
					if(!tools.isDefined($(this).attr('binded')))
					{
						var parent		=	$(this);
						var formTarget	=	$(this).attr('target');
						// Au cas ou aucune cible n'est spécifiée.
						if(!formTarget){return false}
						
						$(this).attr('binded','true');
						$(this).find('button').bind('click',function(){
							$(formTarget).append('<input type="hidden" name="'+$(parent).find('select').attr('name')+'" value="'+$(parent).find('select').val()+'">');
							$(formTarget).trigger('submit');
						});
					}
				});
			};
			this.bind();
		};
		/**		tendoo.formAjax : Permet d'attacher un évènement AJAX au formulaire ayant pour attribue "fjax", 
				les formulaires doivent avoir les attributs "action" et "method".
				Tendoo 0.9.8
					fjaxson		:	Effectue une requête AJAX POST en attente d'un JSON.
		**/			
		tendoo.formAjax		=	new function(){ // For Post Method Only
			this.bind		=	function(){
				$('form[fjax]').each(function(){
					if($(this).attr('fjax') == '')
					{
						$(this).attr('fjax','true');
						$(this).bind('submit',function(){
							if($(this).attr('method') == 'post' || $(this).attr('method') == 'POST')
							{
								var finalQuery = {};
								var datas = $(this).serializeArray();
								for (i = 0; i < datas.length; i++)
								{
									eval("finalQuery." + datas[i].name + ' = datas[i].value;');
								}
								$.ajax($(this).attr('action'),{
									beforeSend	:	function(){
										tendoo.loader.display();
									},
									complete	:	function(){
										tendoo.loader.hide();
									},
									type		:	'POST',
									data		:	finalQuery,
									dataType	:	'script'
								});
							}
							return false;
						});
					}
				});
				// FJAXSON
				$('form[fjaxson]').each(function(){
					if($(this).attr('fjaxson') == '')
					{
						$(this).attr('fjaxson','true');
						$(this).bind('submit',function(){
							if($(this).attr('method') == 'post' || $(this).attr('method') == 'POST')
							{
								var finalQuery = {};
								var datas = $(this).serializeArray();
								for (i = 0; i < datas.length; i++)
								{
									eval("finalQuery." + datas[i].name + ' = datas[i].value;');
								}
								$.ajax($(this).attr('action'),{
									beforeSend	:	function(){
										tendoo.loader.display();
									},
									success		:	function(e){
										tendoo.loader.hide();
										tendoo.triggerAlert(e);	
										eval('var x	=	'+e.exec);
										if(typeof x == 'function')
										{
											x();
										}
									},
									type		:	'POST',
									data		:	finalQuery,
									dataType	:	'json'
								});
							}
							return false;
						});
					}
				});
			}
			this.bind();
		};
		/**
		*		tendoo.confirmEvent : Attache un évènement sur un élément du DOM, pour qu'en cas de clic, une action déterminé dans l'attribut confirm-do="" s'exécute, après avoir afficher une boite de confirmation, dont le contenu se trouve dans l'attribut confirm-text=""
		**/
		tendoo.confirmEvent	=	new function(){
			this.bind		=	function(){
				$('[confirm-do]').each(function(index, element) {
                    if(!tools.isDefined($(this).attr('confirm-binded')))
					{
						var $this	=	$(this);
						$(this).attr('confirm-binded','true');
						$(this).bind('click',function(){							
							if(tools.isDefined($(this).attr('confirm-text')))
							{
								tendoo.modal.confirm($(this).attr('confirm-text'),function(){
									if($this.attr('confirm-do') == 'click')
									{
										var name	=	tools.isDefined($this.attr('name')) ? $this.attr('name') : '';
										var value	=	tools.isDefined($this.attr('value')) ? $this.attr('value') : '';
										$this.closest('form').append('<input type="hidden" name="'+name+'" value="'+value+'">');
										$this.closest('form').trigger('submit');
									}
									else if ($this.attr('confirm-do') == 'fadeOutParent') // Supprime le parent "confirm-parent" après une requête ajax fructueuse.
									{
										// in process
									}
									else if($this.attr('confirm-do') == 'follow-link')
									{
										document.location	=	$this.attr('href');
									}
								});
								return false;
							}
							// throw "Confirm event badly defined";
							return false;
						});
					}
                });
			};
			// Launch binder
			this.bind();
		};

		/**
		*		tools.silentAjax : Attache un évènement AJAX au clic sur un élément ayant l'attribut 'data-requestType="silent"' et "data-url" indiquant l'adresse de la requêtes. Ne prend aucun paramêtre.
		**/					
		tendoo.silentAjax	=	new function(){
			this.bind		=	function(){
				$('[data-requestType="silent"]').each(function(){
					$(this).bind('click',function(){
						if(typeof $(this).attr('data-url') != 'undefined')
						{
							var requestDataType	=	typeof $(this).attr('data-type') != 'undefined' ? $(this).attr('data-type') : false;
							if(typeof $(this).attr('silent-ajax-event') == 'undefined')
							{
								$.ajax($(this).attr('data-url'),{
									beforeSend	:	function(){
										tendoo.loader.display();
									},
									complete	:	function(){
										tendoo.loader.hide();
									},
									dataType	:	requestDataType
								});
							}
						}
					});
				});
			}
			this.bind();
		}
		/**
		*		tools.tab : Affiche un panel d'applications (modules). [DEPRECATED]
		**/
		/** tendoo.tab			=	new function(){
			this.show		=	function(){
				$.ajax(tendoo.url.base_url()+'admin/ajax/get_app_tab',{
					beforeSend	:	function(){
						tendoo.loader.display();
					},
					success	:	function(e){
						tendoo.loader.hide();
						if(device.width >= 1000)
						{
							tendoo.window.size(600,device.height).title('Applications Tendoo').show(e);
						}
						else if(device.width >= 300 && device.width < 1000)
						{	
							tendoo.window.size(200,200).title('Applications Tendoo').show(e);
						}
						tendoo.app.bind();
					}
				});
			};
		};
		**/
		/**
		*		tendoo.set_data	: équivalent de la fonction php set_data de tendoo
		**/	
		tendoo.set_meta		=	function(key,value,callback){
			$.ajax(tendoo.url.site_url('admin/ajax/set_meta'),{
				type		:	'POST',
				dataType	:	'json',
				data		:	{
					"key"	:	key,
					"value"	:	value
				},
				complete	:	function(){
					if( typeof callback == "function" ){
						callback();
					}
				}
			});
		}
		/**
		*		tendoo.set_user_meta : équivalent de la fonction php set_user_meta pour les données utilisateurs
		**/
		tendoo.set_user_meta		=	function(key,value,callback){
			$.ajax(tendoo.url.site_url('admin/ajax/set_user_meta'),{
				type		:	'POST',
				dataType	:	'json',
				data		:	{
					"key"	:	key,
					"value"	:	value
				},
				complete	:	function(){
					if( typeof callback == "function" ){
						callback();
					}
				}
			});
		}
		/**
		*		tendoo.toggleLeftMenu : sauvegarde le statut de menu gauche
		**/	
		tendoo.toggleLeftMenu		=	new function(){
			$('[data-toggle="class:nav-vertical"]').bind('click',function(){
				var currentStatus		=	$('body > section.thinwrapper > aside').hasClass('nav-vertical');
				if( currentStatus ){
					tendoo.set_user_meta( 'admin-left-menu-status' , 'nav-expanded' );
				}
				else
				{
					tendoo.set_user_meta( 'admin-left-menu-status' , 'nav-vertical' );
				}
			});
		};
		/**
				tendoo.indirect_form. Déclenche la soumission d'un formulaire par un bouton qui ne se trouve pas dans le formulaire.
				<x link-to-form=".primary-form">Soumettre</x>
		**/
		tendoo.indirect_form		=	new function(){
			$(document).ready(function(e) {
               $('[link-to-form]').each(function(){
					var form_ref	=	$(this).attr('link-to-form');
					if( $(form_ref).length > 0 ){
						$(this).bind( 'click' , function(){
							$(form_ref).submit();
						});
					}
				}); 
            });
		}
	}
});