/**
 * Tendoo Core Functions
**/
tendoo.app		=	function(){
	
	$this			=	this;
	/**
	 * Handle sidebar status
	**/
	this.sidebar		=	new function(){
		$( '.sidebar-toggle' ).bind( 'click' , function(){
			if( $( 'body' ).hasClass( 'sidebar-collapse' ) )
			{
				$this.options.save( 'dashboard-sidebar' , 'sidebar-collapse' , tendoo.user.id );
			}
			else
			{
				$this.options.save( 'dashboard-sidebar' , 'sidebar-expanded' , tendoo.user.id );
			}
		});
	}
	
	this.options		=	new function(){
		/**
		 * Save Custom meta 
		**/
		this.save		=	function( key , value , user_id, callback ){
			if( typeof user_id === 'undefined' ){
				// Objdata								=	_.object( [ key ], [ value ] ); Not tested
				eval( 'Objdata		= { '+ key + ' 	: 	value }' ); 
				Objdata.gui_saver_expiration_time	=	tendoo.form_expire; // Saving Gui Expire Form
				
				$.ajax({ 
					url : tendoo.dashboard_url + '/options/save?mode=json',
					data: Objdata,
					type : 'POST',
					beforeSend: function(){
						tendoo.ui.loader.start();
					},
					success	:	function(){
						if( typeof callback !== 'undefined' ) {
							callback();
						}
					}
				});
			} else {
				// Objdata								=	_.object( [ key, 'user_id' ], [ value, user_id ] ); Not tested
				eval( 'Objdata		= { "' + key + '" 	: 	value, "user_id" : user_id }' );
				Objdata.gui_saver_expiration_time	=	tendoo.form_expire; // Saving Gui Expire Form
				
				$.ajax({ 
					url : tendoo.dashboard_url + '/options/save_user_meta?mode=json',
					data: Objdata,
					type : 'POST',
					beforeSend: function(){
						$this.ui.loader.start();
					},
					success	:	function(){
						if( typeof callback !== 'undefined' ) {
							callback();
						}
					}
				});
			}
		}
	}
	
	this.ui				=	new function(){
		this.loader		=	new function(){
			this.start	=	function(){
			}
		}
	}
};

// Tendoo notify
tendoo.notify			=	new function(){
	this.error			=	function( title, msg, url, dismiss, delay ){
		$.notify({
			icon			:	'fa fa-ban',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'danger',
			allow_dismiss	:	dismiss,
			delay			:	delay
		})
	};
	
	// Info
	this.info			=	function( title, msg, url, dismiss, delay ){
		$.notify({
			icon			:	'fa fa-exclamation-circle',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'info',
			allow_dismiss	:	dismiss,
			delay			:	delay
		})
	};
	
	// Warning
	this.warning			=	function( title, msg, url, dismiss, delay ){
		$.notify({
			icon			:	'fa fa-times',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'warning',
			allow_dismiss	:	dismiss,
			delay			:	delay
		})
	};
	
	// Success
	this.success			=	function( title, msg, url, dismiss, delay ){
		$.notify({
			icon			:	'fa fa-check',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'success',
			allow_dismiss	:	dismiss,
			delay			:	delay
		})
	};
}
$(document).ready(function(){
	new tendoo.app();
});
