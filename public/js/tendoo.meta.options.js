"use strict";
$('[data-meta-namespace]').find( '[data-widget]' ).bind( 'click', function(){
	tendoo.options.merge(
		'meta_status['+ $(this).closest( '[data-meta-namespace]' ).data( 'meta-namespace' )+']',
		$(this).closest( '[data-meta-namespace]' ).hasClass( 'collapsed-box' ) ? 'uncollapsed-box' : 'collapsed-box',
		true
	);
});
