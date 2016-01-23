<script>
tendoo.menu		=	new function(){
	this.store	=	function( menu ){
		this.menus	=	menu;
	}
	this.get	=	function(){
		return this.menus;
	}
	
	this.create	=	function( items ){
		name	=	$(items).val();
		if( name == '' ) {
			bootbox.alert( '<?php _e( 'You must provide a name for this menu.' );?>' );
			return;
		}
		tendoo.options.get( 'tendoo_menus', function( menus ){
			menus		=	menus == '[]' ? '{}' : menus; //Convert Array to Object;
			menus		=	JSON.parse( menus );
			
			// first menu
			if( typeof menus == 'undefined' || menus == null ) {
				menus	=	new Object();
			}
			
			// if menu doesn't exists
			if( ! _.contains( _.keys( menus ), 'menu_' + CryptoJS.SHA1( name ) ) ){
				
				var menu_id		=	'menu_' + CryptoJS.SHA1( name );
								
				menus			=	_.extend( menus, _.object( [ menu_id ], [{
					menu_name	:	name,
					menu_items	:	[],
					menu_id		: 	menu_id
				}]) );
				
				console.log( _.object( [CryptoJS.SHA1( name )], [{ foo : 'bar' }] ) );
				
				tendoo.options.set( 'tendoo_menus', menus );
				tendoo.menu.store( menus );
				tendoo.menu.generate();			
				
			} else {
				bootbox.alert( '<?php _e( 'This menu already exists, please choose another name' );?>' );
			}
			
			$(items).val('');
		});		
	}
	this.generate	=	function()
	{
		$('#menu_list').html('');
		_.each( this.menus, function( value, key ){
			$('#menu_list').append( '<option value="' + value.menu_id + '">' + value.menu_name + '</option>' );
		});
	}
	this.load	=	function( menus ){
		if( typeof menus === 'undefined' ){
			tendoo.options.get( 'tendoo_menus', function( data ){
				tendoo.menu.store( JSON.parse( data ) );
				tendoo.menu.generate();
			});
		}
	}
	this.delete_menu	=	function( menu_id ){
		tendoo.options.get( 'tendoo_menus', function( data ){
			if( menu_id == $( '#nestable' ).data( 'menu' ) ){
				$( '#nestable' ).data( 'menu', void(0) );
				$( '.content-header h1 small' ).html( '' );
			}
			tendoo.menu.store( JSON.parse( data ) );
			tendoo.menu.store( _.omit( tendoo.menu.get(), menu_id ) );		
			tendoo.options.set( 'tendoo_menus', tendoo.menu.get() );
			console.log( tendoo.menu.get() );
			tendoo.menu.generate();						 
		});
	}
	this.add_link		=	function( label, url ) {
		var check_item	=	( label	== '' || url == '' ) ? bootbox.alert( '<?php _e( 'Must provide "Label" and "Url"' );?>' ) : true ;
		if( typeof $( '#nestable' ).data( 'menu' ) != 'undefined' ) {
			if( check_item === true ) {
			var current_item	=	_.propertyOf( this.menus )( $( '#nestable' ).data( 'menu' ) );
				current_item.menu_items.push({
					id			:	isNaN( current_item.menu_items.length ) ? 0 : current_item.menu_items.length + 1,
					url			:	url,
					label		:	tendoo.tools.remove_tags( label )
				});
				this.output_menu();
				this.update_menu_items( $( '#nestable' ) );
				return;
			}
			return;
		}
		bootbox.alert( '<?php _e( 'You should load a menu first' );?>' );
	};
	this.output_menu	=	function()
	{
		var current_item	=	_.propertyOf( this.menus )( $( '#nestable' ).data( 'menu' ) );
		var menu_items		=	_.propertyOf( current_item )( 'menu_items' );		
		var output 			= 	"<ol class='dd-list dd3-list'>";
		function buildItem( menu_item ) {
			var html = "<li class='dd-item' data-id='" + menu_item.id + "' data-url='" + menu_item.url + "' data-label='" + menu_item.label + "'>";
			html += "<div class='dd-handle'>" + menu_item.label + "</div>";
	
			if (menu_item.children) {
	
				html += "<ol class='dd-list'>";
				$.each(menu_item.children, function (index, subitem) {
					html += buildItem(subitem);
				});
				html += "</ol>";
	
			}
	
			html += "</li>";
	
			return html;
		}
		console.log( menu_items );
		$.each( menu_items, function (index, menu_item) {
			
			output += buildItem(menu_item);
	
		});
		
		output		+=	"</ol>";
		
		$('#nestable' ).html( output );
	}
	this.load_menu		=	function( val )
	{
		$( '#nestable' ).data( 'menu', val );
		var current_item	=	_.propertyOf( this.menus )( $( '#nestable' ).data( 'menu' ) );
		console.log( current_item );
		$( '.content-header h1 small' ).html( '<?php _e( 'Loaded : ' );?>' + current_item.menu_name );
		this.output_menu();
	}
	this.update_menu_items	=	function( e ){
		var list   = e.length ? e : $(e.target);
		var current_item			=	_.propertyOf( tendoo.menu.get() )( $( '#nestable' ).data( 'menu' ) );
		// console.log( tendoo.menu.get() );
			current_item.menu_items	=	list.nestable('serialize');
		tendoo.options.set( 'tendoo_menus', JSON.stringify( tendoo.menu.get() ) );			
	}
}

$(document).ready(function(e) {
	
    $( '#create_menu' ).bind( 'click', function(){
		tendoo.menu.create( $( '#menu_name' ) );
		return false;
	});
	
	$( '#delete_menu' ).bind( 'click', function(){
		tendoo.menu.delete_menu( $( '#menu_list' ).val() );
		return false;
	});
	
	// Link Creation
	$( '.create_link' ).bind( 'click', function(){
		tendoo.menu.add_link( $( '[name="link_label"]' ).val(), $( '[name="link_url"]' ).val() );
		return false;
	});
	
	// Load Menu
	$( '.load_menu' ).bind( 'click', function(){
		tendoo.menu.load_menu( $( '#menu_list' ).val() );
		return false;
	});
	
	tendoo.menu.load();
    
	// activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
		contentCallback : function( element ) {
			return element.menu_name;
		},
		//listClass : 'list-group',
		//itemClass : 'list-group-item',
		placeClass	:	'list-group-item bg-warning'
    })
    .on('change', tendoo.menu.update_menu_items );

	
    // output initial serialised data
    // updateOutput($('#nestable').data('output', $('#nestable-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    $('#nestable3').nestable();

});
</script>