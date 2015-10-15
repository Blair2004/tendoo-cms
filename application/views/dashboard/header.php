<?php
/**
 * 	File Name : header.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since	:	1.4
**/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script>
var 	tendoo					=	new Object;
		tendoo.base_url		=	'<?php echo base_url();?>';
		tendoo.dashboard_url	=	'<?php echo site_url( array( 'dashboard' ) );?>';
		tendoo.current_url	=	'<?php echo current_url();?>';
		tendoo.index_url		=	'<?php echo index_page();?>';
		tendoo.form_expire	=	'<?php echo gmt_to_local( time() , 'UTC' ) + GUI_EXPIRE;?>';
		tendoo.user				=	{
			id			:		<?php echo $this->events->apply_filters( 'tendoo_object_user_id' , 'false' );?>
		}
		// Date Object
		tendoo.date				=	new Date();
		tendoo.now				=	function(){
			this.add_zero		=	function( i ){
				if (i < 10) {
					i = "0" + i;
				}
				return i;
			}
			var d = this.add_zero( tendoo.date.getDate() ),
				 m = this.add_zero( tendoo.date.getMonth() ),
				 y = this.add_zero( tendoo.date.getFullYear() ),
				 s = this.add_zero( tendoo.date.getSeconds() ),
				 h = this.add_zero( tendoo.date.getHours() ),
				 i = this.add_zero( tendoo.date.getMinutes() );
			return y + '-' + m + '-' + d + 'T' + h + ':' + i + ':' + s;
		};
		// Gui Options
		tendoo.options_data	=	{
			gui_saver_expiration_time	:	tendoo.form_expire,
			gui_saver_option_namespace	:	null,
			gui_saver_use_namespace		:	false,
			user_id							:	tendoo.user.id,
			gui_json							:	true
		}
		tendoo.options			=	new function(){
			var $this			=	this;
			this.set				=	function( key, value ) {
				var post_data			=	_.object( [ key ], [ value ] );
				tendoo.options_data	=	_.extend( tendoo.options_data, post_data );
				$.ajax( '<?php echo site_url( array( 'dashboard', 'options', 'save' ) );?>', {
					data			:	tendoo.options_data,
					type			:	'POST',
					beforeSend 	:	function(){
						if( _.isFunction( $this.beforeSend ) ) {
							$this.beforeSend();
						}
					},
					success		: function( data ) {
						if( _.isFunction( $this.success ) ) {
							$this.success( data );
						}
					}
				});
			};
			this.merge				=	function( key, value ) {
				var post_data			=	_.object( [ key ], [ value ] );
				tendoo.options_data	=	_.extend( tendoo.options_data, post_data );
				$.ajax( '<?php echo site_url( array( 'dashboard', 'options', 'merge' ) );?>', {
					data			:	tendoo.options_data,
					type			:	'POST',
					beforeSend 	:	function(){
						if( _.isFunction( $this.beforeSend ) ) {
							$this.beforeSend();
						}
					},
					success		: function( data ) {
						if( _.isFunction( $this.success ) ) {
							$this.success( data );
						}
					}
				});
			};
			this.get				=	function( key, callback ) {
				var post_data			=	_.object( [ 'option_key' ], [ key ] );
				tendoo.options_data	=	_.extend( tendoo.options_data, post_data );
				$.ajax( '<?php echo site_url( array( 'dashboard', 'options', 'get' ) );?>', {
					data			:	tendoo.options_data,
					type			:	'POST',
					beforeSend 	:	function(){
						// $this.beforeSend();
					},
					success 		: function( data ){
						if( _.isFunction( data ) ) {
							callback( data );
						}
					}
				});
			}
			this.beforeSend		=	function( callback ) {
				this.beforeSend	=	callback;
				return this;
			};
			this.success			=	function( callback ) {
				this.success		=	callback
				return this;
			}
		}
</script>

<?php Enqueue::loadcss();?>
<?php Enqueue::loadjs();?>
<?php $this->events->do_action( 'dashboard_header' );?>

<title><?php echo Html::get_title();?></title>
</head>