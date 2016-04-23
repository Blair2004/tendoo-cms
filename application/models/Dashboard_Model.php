<?php
/**
 *
 * Title 	:	 Dashboard model
 * Details	:	 Manage dashboard page (creating, ouput)
 *
**/

class Dashboard_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();		
		$this->events->add_action( 'dashboard_header', array( $this, '__dashboard_header' ) );
		$this->events->add_action( 'dashboard_footer', array( $this, '__dashboard_footer' ) );
		$this->events->add_action( 'load_dashboard' , array( $this , '__set_admin_menu' ) );
		$this->events->add_action( 'load_dashboard' , array( $this , 'load_dashboard' ) , 1 );				
		$this->events->add_action( 'create_dashboard_pages' , array( $this , '__dashboard_config' ) );			
		$this->events->add_action( 'load_dashboard' , array( $this , 'before_session_starts' ) );
		// $this->events->add_filter( 'dashboard_home_output', array( $this, '__home_output' ) );
	}
	
	/**
	 * Load Dashboard
	 * Enqueue File to assest helper
	 * 
	 * @return void
	**/
	
	function load_dashboard()
	{
		// Enqueuing slimscroll
		$this->enqueue->js( '../plugins/slimScroll/jquery.slimscroll.min' );
		$this->enqueue->js( 'advanced' );
		$this->enqueue->js( '../plugins/heartcode/heartcode-canvasloader-min' );
		$this->enqueue->js( '../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min' ); // WYSIHTML5 @since 1.5
		$this->enqueue->css( '../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min' ); // CSS for WYSIHTML5
		
		// Highlight
		$this->enqueue->css( 'highlight-min' );
		
		// Bootsrap Notify
		$this->enqueue->js( '../plugins/bootstrap-notify-master/bootstrap-notify.min' );		
		$this->enqueue->js( 'tendoo.core' );	
		
		// Bootbox
		$this->enqueue->js( '../plugins/bootbox/bootbox.min' );
		
		// Underscore
		$this->enqueue->js( '../plugins/underscore/underscore-min' );
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
	 * @return void
	**/
	
	function load_widgets()
	{
		if( ! Modules::is_active( 'aauth' ) ) : return false; endif;
		// get global widget and cols
		global $AdminWidgets;
		global $AdminWidgetsCols;

		$SavedAdminWidgetsCols		=	$this->options->get( 'admin_widgets', User::id() );
		$FinalAdminWidgetsPosition	=	array_merge( $AdminWidgetsCols, force_array( $SavedAdminWidgetsCols ) );
		
		// looping cols
		unset( $this->Gui->cols[ 4 ] );
		// var_dump( $this->Gui->cols );die;
		
		for( $i = 1; $i <= count( $this->Gui->cols ); $i++ ) {
			$widgets_namespace	=	$this->dashboard_widgets->col_widgets( $i );
			
			$this->Gui->col_width( 1, 1 );
			$this->Gui->col_width( 2, 1 );
			$this->Gui->col_width( 3, 1 );
			
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
				$this->Gui->add_meta( $meta_array );
				// create dom
				$this->Gui->add_item( array(
					'type'		=>	'dom',
					'content'	=>	riake( 'content', $widget_options ) // $this->load->view( riake( 'content', $widget_options, '[empty_widget]' ), array(), true )
				), $widget_namespace, $i );
			}
		}
	}
	
	/**
	 * Load Dashboard Footer
	 * 
	 * @return void
	**/
	
	function __dashboard_footer()
	{
		$segments	= $this->uri->segment_array();
		if( riake( 2, $segments, 'index' ) == 'index' ) {
		?>
<script type="text/javascript">

"use strict";

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
<script type="text/javascript">

"use strict";

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
	
	/**
	 * Dashboard Header
	 * 
	 * @return void
	**/
	
	function __dashboard_header()
	{
		?>
<script type="text/javascript">

"use strict";

tendoo.base_url			=	'<?php echo base_url();?>';
tendoo.site_url			=	'<?php echo site_url();?>/';
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
    user_id						:	tendoo.user.id,
    gui_json					:	true
}

// Tendoo options
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
		
		// console.log( post_data );
        tendoo.options_data		=	_.extend( tendoo.options_data, post_data );
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
tendoo.loader			=	new function(){
	this.int			=	0;
	this.show			=	function(){

		this.int++;

		if( this.int == 1 ) {
			var cl = new CanvasLoader('tendoo-spinner');
			cl.setColor('#ffffff'); // default is '#000000'
			cl.setDiameter(35); // default is 40
			cl.setDensity(56); // default is 40
			cl.setSpeed(3); // default is 2
			cl.show(); // Hidden by default
			$('#tendoo-spinner').fadeIn(500);
		}
	}
	this.hide			=	function(){

		this.int--;
		
		if( this.int == 0 ){
			$('#tendoo-spinner').fadeOut(500, function(){
				$(this).html('').show();
			})
		}
	}
}
/**
 * Tendoo Tools
 * @since 3.0.5
**/

tendoo.tools				=	new Object();
tendoo.tools.remove_tags	=	function( string ){
	return string.replace(/(<([^>]+)>)/ig,"");
};
$(document).ready(function(){
	$( document ).ajaxComplete(function() {
	  tendoo.loader.hide();
	});
	$( document ).ajaxError(function() {
	  tendoo.loader.hide();
	});
	$( document ).ajaxSend(function() {
	  tendoo.loader.show();
	});
});
</script>
		<?php
	}
	
	/**
	 * Dashboard Config
	 * 
	 * @return void
	**/
	
	function __dashboard_config()
	{
		$this->Gui->register_page( 'index' , array( $this , 'index' ) );
		$this->Gui->register_page( 'settings' , array( $this , 'settings' ) );
	}
	
	/**
	 * Dashboard Home Load
	 * 
	 * @return void
	**/
	
	function index()
	{
		// load widget model here only
		$this->load->model( 'Dashboard_Widgets_Model', 'dashboard_widgets' );
		
		// trigger action while loading home (for registering widgets)
		$this->events->do_action( 'load_dashboard_home' );
		$this->load_widgets();
		
		$this->Gui->set_title( sprintf( __( 'Dashboard &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/index/body' );
	}
	
	/**
	 * Load Tendoo Setting Page
	 * 
	 * @return void
	**/
	
	function settings()
	{
		// ! User::can( 'manage_options' ) ? redirect( array( 'dashboard', 'access-denied' ) ): null ;
		
		$this->Gui->set_title( sprintf( __( 'Settings &mdash; %s' ) , get( 'core_signature' ) ) );
		$this->load->view( 'dashboard/settings/body' );
	}
	
	/**
	 * Load Dashboard Menu
	 * 
	 * @return void
	**/
	
	public function __set_admin_menu()
	{		
		$admin_menus[ 'dashboard' ][] 	=	array(	
			'href'			=>		site_url('dashboard'),
			'icon'			=>		'fa fa-dashboard',
			'title'			=>		__( 'Dashboard' )
		);
		
		if( User::can( 'manage_options' ) ):
		
		$admin_menus[ 'dashboard' ][] 	=	array(	
			'href'			=>		site_url( array( 'dashboard', 'update' ) ),
			'icon'			=>		'fa fa-dashboard',
			'title'			=>		__( 'Update Center' ),
			'notices_nbr'	=>		$this->events->apply_filters( 'update_center_notice_nbr', 0 )
		);
		
		$admin_menus[ 'dashboard' ][] 	= 	array(	
			'href'			=>		site_url( array( 'dashboard', 'about' ) ),
			'icon'			=>		'fa fa-dashboard',
			'title'			=>		__( 'About' ),
		);
		
		endif;
		
		if( User::can( 'manage_modules' ) ):
		
		$admin_menus[ 'modules' ][]		=	array(
			'title'			=>		__( 'Modules' ),
			'icon'			=>		'fa fa-puzzle-piece',
			'href'			=>		site_url('dashboard/modules')
		);
		
		endif;
		
		if( User::can( 'manage_options' ) ):
		
		$admin_menus[ 'settings' ][]	=	array(
			'title'			=>		__( 'Settings' ),
			'icon'			=>		'fa fa-cogs',
			'href'			=>		site_url('dashboard/settings')
		);
		
		endif;
		
		foreach( force_array( $this->events->apply_filters( 'admin_menus' , $admin_menus ) ) as $namespace => $menus )
		{
			foreach( $menus as $menu )
			{
				Menu::add_admin_menu_core( $namespace , $menu  );
			}
		}		
	}	
}