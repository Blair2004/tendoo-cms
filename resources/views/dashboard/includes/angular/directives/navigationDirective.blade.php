<script type="text/javascript">
"use strict";

tendooApp.directive('a', function() {
    var directive = {
        restrict: 'E',
        link: link
    }
    return directive;

    function link(scope, element, attrs) {
        $( element ).bind( 'click', function(){

            // SideMenu
            if( $( this ).hasClass( 'nav-link' ) ) {
                $( this ).closest( 'li' ).toggleClass( 'open' );
            }

            // Layout Toggler
            if( $( this ).hasClass( 'layout-toggler' ) ) {

                var sideBarStatus   =   $( 'div.sidebar' ).hasClass( 'sidebar-small' ) ? true : false;

                if( ! sideBarStatus ) {
                    $( 'div.sidebar' ).width( 50 );
                    $( 'footer.footer' ).css('left', 50);
                    $( 'div > a.navbar-brand' ).width(18);
                    $( 'div > a.navbar-brand' ).addClass( 'navbar-brand-small' );
                    $( '.nav-link' ).find( '.nav-text' ).hide();
                    $( 'div.sidebar' ).addClass( 'sidebar-small' );
                    $( 'body.navbar-fixed .main' ).css( 'padding-left', 50 );
                } else {
                    $( 'div.sidebar' ).width( 220 );
                    $( 'footer.footer' ).css('left', 220);
                    $( 'div > a.navbar-brand' ).width(220-32);
                    $( 'div > a.navbar-brand' ).removeClass( 'navbar-brand-small' );
                    $( '.nav-link' ).find( '.nav-text' ).show();
                    $( 'div.sidebar' ).removeClass( 'sidebar-small' );
                    $( 'body.navbar-fixed .main' ).css( 'padding-left', 220 );
                }
            }

            // DropDown
            if( $( this ).hasClass( 'dropdown-toggle' ) ){
                $( this ).closest( '.dropdown' ).toggleClass( 'open' );
            }
        })
    }
})

/**
 * Directive for nav element
**/

tendooApp.directive( 'nav', function(){
    var directive = {
        restrict: 'E',
        link: link
    }
    return directive;

    function link(scope, element, attrs) {
        $( element ).mouseenter( function(){
            var sideBarStatus   =   $( 'div.sidebar' ).hasClass( 'sidebar-small' ) ? true : false;

            if( $( 'body' ).hasClass( 'mobile-open' ) && window.innerWidth < 991 ) {
                return false;
            }

            if( $( 'div.sidebar' ).hasClass( 'sidebar-small' ) && sideBarStatus ){
                $( 'div.sidebar' ).addClass( 'wait-closing' );
                $( '.navbar-toggler' ).trigger( 'click' );
            }
        });

        $( element ).mouseleave( function(){
            if( $( 'div.sidebar' ).hasClass( 'wait-closing' ) ){
                $( '.navbar-toggler' ).trigger( 'click' );
                $( 'div.sidebar' ).removeClass( 'wait-closing' );
            }
        });
    }
});

/**
 * Mobile Toggler
**/

tendooApp.directive( 'button', function(){
    var directive = {
        restrict: 'E',
        link: link
    }
    return directive;

    function link(scope, element, attrs) {
        if( $( element ).hasClass( 'mobile-toggler' ) ) {
            $( element ).bind( 'click', function(){
                $( 'body' ).toggleClass( 'mobile-open' );
            })
        }
    }
});

</script>
