@verbatim
<script type="text/javascript">
tendooApp.directive( 'nav', function(){
    return {
        template    :
'<form ng-hide="true">'+
	'<div class="form-group p-h mb-0">'+
		'<input type="text" class="form-control" aria-describedby="search" placeholder="Search...">'+
	'</div>'+
'</form>' +
'<ul class="nav">' +
    '<li class="nav-item {{ menu.subMenus.length > 0 ? \'nav-dropdown\' : \'\' }}" ng-repeat="(key, menu) in menus">'+
    	'<a class="nav-link {{ menu.subMenus.length > 0 ? \'nav-dropdown-toggle\' : \'\' }}" href="{{ menu.href }}">'+
    		'<i class="{{ menu.icon }}"></i> <span class="nav-text">{{ menu.text }}</span>'+
    	'</a>'+
        '<sub-nav object="menus[ key ]"></sub-nav>' +
    '</li>'+
'</ul>',
        scope   :   {
            menus       :   '=object'
        }
    }
});
</script>
@endverbatim
