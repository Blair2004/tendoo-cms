<?php
/**
 * 	File Name : header.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since	:	1.4
**/

global $Options;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- Add Scale for mobile devices, @since 3.0.7 -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo Html::get_title();?></title>
<!-- End Add Scale for mobile devices -->
<?php
// Load Rest Keys
$this->load->config('rest');
$key        =    $this->config->item('rest_key_name');
$value      =    @$Options[ 'rest_key' ];
?>
<script type="text/javascript">
var tendoo	=	new Object;

tendoo.rest             =   {
    key     :   '<?php echo $key;?>',
    value   :   '<?php echo $value;?>'
}
tendoo.base_url			=	'<?php echo base_url();?>';
tendoo.site_url			=	'<?php echo site_url();?>/';
tendoo.dashboard_url	=	'<?php echo site_url(array( 'dashboard' ));?>';
tendoo.current_url		=	'<?php echo current_url();?>';
tendoo.index_url		=	'<?php echo index_page();?>';
tendoo.form_expire		=	'<?php echo gmt_to_local(time(), 'UTC') + GUI_EXPIRE;?>';
tendoo.user				=	{
    id      :   '<?php echo $this->events->apply_filters('tendoo_object_user_id', 'false' );?>'
}
tendoo.csrf_field_name	=	'<?php echo $this->security->get_csrf_token_name();?>';
tendoo.csrf_field_value	=	'<?php echo $this->security->get_csrf_hash();?>';
tendoo.csrf_data		=	{
	'<?php echo $this->security->get_csrf_token_name();?>'	:	'<?php echo $this->security->get_csrf_hash();?>'
};
tendoo.options			=	new function(){
    var $this			=	this;
	var save_slug;
    this.set				=	function( key, value, user_meta ) {
        if( typeof user_meta != 'undefined' ) {
            save_slug			=	'save_user_meta';
        } else {
            save_slug			=	'save';
        }
		value					=	( typeof value == 'object' ) ? JSON.stringify( value ) : value
		var post_data			=	_.object( [ key ], [ value ] );
		// Add CSRF Secure for POST Ajax
		tendoo.options_data		=	_.extend( tendoo.options_data, tendoo.csrf_data );
        tendoo.options_data		=	_.extend( tendoo.options_data, post_data );

        $.ajax( '<?php echo site_url(array( 'dashboard', 'options' ));?>/'+save_slug, {
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
    this.merge				=	function( key, value, user_meta ) {
        if( typeof user_meta != 'undefined' ) {
            save_slug	=	'merge_user_meta';
        } else {
            save_slug	=	'merge';
        }
        var post_data			=	_.object( [ key ], [ value ] );
		tendoo.options_data		=	_.extend( tendoo.options_data, tendoo.csrf_data );
        tendoo.options_data	=	_.extend( tendoo.options_data, post_data );
        $.ajax( '<?php echo site_url(array( 'dashboard', 'options' ));
        ?>/' + save_slug, {
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
        var post_data		=	_.object( [ 'option_key' ], [ key ] );
		tendoo.options_data		=	_.extend( tendoo.options_data, tendoo.csrf_data );
        tendoo.options_data	=	_.extend( tendoo.options_data, post_data );
        $.ajax( '<?php echo site_url(array( 'dashboard', 'options', 'get' ));
        ?>', {
            data			:	tendoo.options_data,
            type			:	'POST',
            beforeSend 	:	function(){
                // $this.beforeSend();
            },
            success 		: function( data ){
                if( _.isFunction( callback ) ) {
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
<?php $this->events->do_action('dashboard_header');?>
</head>
