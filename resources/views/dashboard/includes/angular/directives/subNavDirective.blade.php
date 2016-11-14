@verbatim
<script type="text/javascript">
tendooApp.directive( 'subNav', function(){
    return {
        template    :
'<ul class="nav-dropdown-items">' +
    '<li class="nav-item" ng-repeat="( _key, _submenu ) in submenus.subMenus">'+
    	'<a class="nav-link" href="{{ _submenu.href }}">' +
    		'<i class="{{ _submenu.icon }}"></i> <span class="nav-text">{{ _submenu.text }}</span>'+
    	'</a>' +
    '</li>' +
'</ul>',
        scope   :   {
            submenus     :   '=object',
            limit       :   '@'
        },
        replace     :   true
    }
});
</script>
@endverbatim
