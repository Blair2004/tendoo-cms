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
		this.save		=	function( key , value , user_id ){
			if( typeof user_id === 'undefined' ){
				eval( 'Objdata		= { '+ key + ' 	: 	value }' );
				Objdata.gui_saver_expiration_time	=	tendoo.form_expire; // Saving Gui Expire Form
				
				$.ajax({ 
					url : tendoo.dashboard_url + '/options/save?mode=json',
					data: Objdata,
					type : 'POST',
					beforeSend: function(){
						tendoo.ui.loader.start();
					}
				});
			} else {
				eval( 'Objdata		= { "' + key + '" 	: 	value, "user_id" : user_id }' );
				Objdata.gui_saver_expiration_time	=	tendoo.form_expire; // Saving Gui Expire Form
				
				$.ajax({ 
					url : tendoo.dashboard_url + '/options/save_user_meta?mode=json',
					data: Objdata,
					type : 'POST',
					beforeSend: function(){
						$this.ui.loader.start();
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
$(document).ready(function(){
	new tendoo.app();
});
