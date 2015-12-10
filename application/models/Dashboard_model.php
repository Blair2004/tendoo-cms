<?php
/**
 *
 * Title 	:	 Dashboard model
 * Details	:	 Manage dashboard page (creating, ouput)
 *
**/

class Dashboard_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();		
		$this->events->add_action( 'dashboard_header', array( $this, '__dashboard_header' ) );
		$this->events->add_action( 'dashboard_footer', array( $this, '__dashboard_footer' ) );
		$this->events->add_filter( 'dashboard_home_output', array( $this, '__home_output' ) );
	
		$this->events->add_action( 'load_dashboard' , array( $this , '__set_admin_menu' ) );
		$this->events->add_action( 'load_dashboard' , array( $this , 'load_dashboard' ) , 1 );		
		
		$this->events->add_action( 'create_dashboard_pages' , array( $this , '__dashboard_config' ) );			
		$this->events->add_action( 'load_dashboard' , array( $this , 'before_session_starts' ) );
	}
	
	function load_dashboard()
	{
		// Enqueuing slimscroll
		$this->enqueue->js( '../plugins/SlimScroll/jquery.slimscroll.min' );
		$this->enqueue->js( 'advanced' );
		$this->enqueue->js( '../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min' ); // WYSIHTML5 @since 1.5
		$this->enqueue->css( '../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min' ); // CSS for WYSIHTML5
		
		// Bootsrap Notify
		$this->enqueue->js( '../plugins/bootstrap-notify-master/bootstrap-notify.min' );		
		$this->enqueue->js( 'tendoo.core' );	
		
	}

	/**
	 * 	Edit Tendoo.php config before session starts
	 *
	 *	@return	: void
	**/
	
	function before_session_starts()
	{
		$this->config->set_item( 'tendoo_logo_long' , '<b>Tend</b>oo' );
		$this->config->set_item( 'tendoo_logo_min' , '<img id="tendoo-logo" style="height:35px;" src="' . img_url() . 'logo_minim.png' . '" alt=logo>' );		
	}

	/**
	 * Load dashboard widgets
	**/
	
	function load_widgets()
	{
		// get global widget and cols
		global $AdminWidgets;
		global $AdminWidgetsCols;

		$SavedAdminWidgetsCols		=	$this->options->get( 'admin_widgets', User::id() );
		$FinalAdminWidgetsPosition	=	array_merge( $AdminWidgetsCols, force_array( $SavedAdminWidgetsCols ) );
		
		// looping cols
		unset( $this->gui->cols[ 4 ] );
		// var_dump( $this->gui->cols );die;
		
		for( $i = 1; $i <= count( $this->gui->cols ); $i++ ) {
			$widgets_namespace	=	$this->dashboard_widgets->col_widgets( $i );
			
			$this->gui->col_width( 1, 1 );
			$this->gui->col_width( 2, 1 );
			$this->gui->col_width( 3, 1 );
			
			foreach( $widgets_namespace as $widget_namespace ) {
				// get widget
				$widget_options	=	$this->dashboard_widgets->get( $widget_namespace, User::id() );
				// create meta
				$meta_array		=	array(
					'col_id'	=>	$i,
					'namespace'	=>	$widget_namespace,
					'type'		=>	riake( 'type', $widget_options ),
					'title'		=>	riake( 'title', $widget_options )
				);
				
				$meta_array		=	array_merge( $widget_options, $meta_array );
				$this->gui->add_meta( $meta_array );
				// create dom
				$this->gui->add_item( array(
					'type'		=>	'dom',
					'content'	=>	riake( 'content', $widget_options ) // $this->load->view( riake( 'content', $widget_options, '[empty_widget]' ), array(), true )
				), $widget_namespace, $i );
			}
		}
	}
	
	function __dashboard_footer()
	{
		$segments	= $this->uri->segment_array();
		if( riake( 2, $segments, 'index' ) == 'index' ) {
		?>
        <script>
		$(document).ready(function(){
			function __doSort(event,ui){
				ui.item.closest(".row .box").parent().find('.draggable_widgets').each(function(){
					$(this).children(function(){
						alert($(this).attr('widget_id'));
					})
				});
				var tab		=	new Array;
				var section	=	1;
				var newSet	=	{};
				$('.row .meta-row').each(function(){
					if(typeof tab[section] == 'undefined')
					{
						tab[section] = new Array;
					}
					$(this).find('div[data-meta-namespace]').each(function(){
						tab[section].push($(this).data( 'meta-namespace' ) );
					});
					// Saving Each Fields	
					_.extend(newSet,_.object([ section ],[ tab [ section ] ]));
					section++;
				});
				console.log( tab );
				tendoo.options.set( 'dashboard_widget_position', newSet, true );
			}
			var actionAllower	=	{};
			$('.row .meta-row').sortable({
				grid			:	[ 10 , 10 ],
				connectWith		: 	".row .meta-row",
				items			:	"div[data-meta-namespace]",
				placeholder		:	"widget-placeholder",
				forceHelperSize	:	false,
				// zIndex			:	tendoo.zIndex.draggable,
				forcePlaceholderSize	:	true,
				stop			:	function(event, ui){
					__doSort(event, ui);
				},
				delay			: 	150 
			});
		});
		</script>	
        <?php
		}
		?>
        <script>
		$('[data-meta-namespace]').find( '[data-widget]' ).bind( 'click', function(){
			tendoo.options.merge( 
				'meta_status['+ $(this).closest( '[data-meta-namespace]' ).data( 'meta-namespace' )+']', 
				$(this).closest( '[data-meta-namespace]' ).hasClass( 'collapsed-box' ) ? 'uncollapsed-box' : 'collapsed-box',
				true
			);
		});
		</script>
        <?php
	}
	function __dashboard_header()
	{
		// Including Highlight.js
		?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/styles/default.min.css">
<script type="text/javascript" src="http://underscorejs.org/underscore-min.js"></script>
<script>
tendoo.base_url			=	'<?php echo base_url();?>';
tendoo.dashboard_url	=	'<?php echo site_url( array( 'dashboard' ) );?>';
tendoo.current_url		=	'<?php echo current_url();?>';
tendoo.index_url		=	'<?php echo index_page();?>';
tendoo.form_expire		=	'<?php echo gmt_to_local( time() , 'UTC' ) + GUI_EXPIRE;?>';
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
// Tendoo notify
tendoo.notify			=	new function(){
	this.error			=	function( title, msg, url, dismiss ){
		$.notify({
			icon			:	'fa fa-ban',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'danger',
			allow_dismiss	:	dismiss
		})
	};
	
	// Info
	this.info			=	function( title, msg, url, dismiss ){
		$.notify({
			icon			:	'fa fa-exclamation-circle',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'info',
			allow_dismiss	:	dismiss
		})
	};
	
	// Warning
	this.warning			=	function( title, msg, url, dismiss ){
		$.notify({
			icon			:	'fa fa-times',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'warning',
			allow_dismiss	:	dismiss
		})
	};
	
	// Success
	this.success			=	function( title, msg, url, dismiss ){
		$.notify({
			icon			:	'fa fa-check',
			title			:	title,
			message			:	msg,
			url				:	url,
		},{
			type			:	'success',
			allow_dismiss	:	dismiss
		})
	};
}
// Tendoo options
tendoo.options			=	new function(){
    var $this			=	this;
    this.set				=	function( key, value, user_meta ) {
        if( typeof user_meta != 'undefined' ) {
            save_slug	=	'save_user_meta';
        } else {
            save_slug	=	'save';
        }
        var post_data			=	_.object( [ key ], [ value ] );
        tendoo.options_data	=	_.extend( tendoo.options_data, post_data );
        $.ajax( '<?php echo site_url( array( 'dashboard', 'options' ) );?>/'+save_slug, {
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
        tendoo.options_data	=	_.extend( tendoo.options_data, post_data );
        $.ajax( '<?php echo site_url( array( 'dashboard', 'options' ) );?>/' + save_slug, {
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
		<?php
	}
	function __dashboard_config()
	{
		$this->gui->register_page( 'index' , array( $this , 'index' ) );
		$this->gui->register_page( 'settings' , array( $this , 'settings' ) );
	}
	function index()
	{
		// load widget model here only
		$this->load->model( 'dashboard_widgets_model', 'dashboard_widgets' );
		
		// trigger action while loading home (for registering widgets)
		$this->events->do_action( 'load_dashboard_home' );
		$this->load_widgets();
		
		$this->gui->set_title( sprintf( __( 'Dashboard &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/index/body' );
	}
	
	function settings()
	{
		$this->gui->set_title( sprintf( __( 'Settings &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/settings/body' );
	}
	
	public function __set_admin_menu()
	{	
		$admin_menus		=	array(
			'dashboard'		=>	array(
				array(	
					'href'			=>		site_url('dashboard'),
					'icon'			=>		'fa fa-dashboard',
					'title'			=>		__( 'Dashboard' )
				),
				array(	
					'href'			=>		site_url( array( 'dashboard', 'update' ) ),
					'icon'			=>		'fa fa-dashboard',
					'title'			=>		__( 'Update Center' )
				),
				array(	
					'href'			=>		site_url( array( 'dashboard', 'about' ) ),
					'icon'			=>		'fa fa-dashboard',
					'title'			=>		__( 'About' )
				),
			),
			/** 'media'			=>	array(
				array(
					'title'			=>		__( 'Media Library' ),
					'icon'			=>		'fa fa-image',
					'href'			=>		site_url('dashboard/media')
				)
			),
			'installer'			=>	array(
				array(
					'title'			=>		__( 'Install Apps' ),
					'icon'			=>		'fa fa-flask',
					'href'			=>		site_url('dashboard/installer')
				)
			),
			**/
			'modules'			=>	array(
				array(
					'title'			=>		__( 'Modules' ),
					'icon'			=>		'fa fa-puzzle-piece',
					'href'			=>		site_url('dashboard/modules')
				)
			),
			/** 'themes'			=>	array(
				array(
					'title'			=>		__( 'Themes' ),
					'icon'			=>		'fa fa-columns',
					'href'			=>		site_url('dashboard/themes')
				),
				array(
					'href'			=>		site_url('dashboard/controllers'),
					'icon'			=>		'fa fa-bookmark',
					'title'			=>		__( 'Menus' )
				)
			),
			**/
			'settings'			=>	array(
				array(
					'title'			=>		__( 'Settings' ),
					'icon'			=>		'fa fa-cogs',
					'href'			=>		site_url('dashboard/settings')
				)
			),
		);
		
		foreach( force_array( $this->events->apply_filters( 'admin_menus' , $admin_menus ) ) as $namespace => $menus )
		{
			foreach( $menus as $menu )
			{
				Menu::add_admin_menu_core( $namespace , $menu  );
			}
		}		
	}	
}