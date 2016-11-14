<script type="text/javascript">
tendooApp.controller( 'sidebarController', [ '$scope', function( $scope ){
    $scope.dashboardMenus        =   [{
        text        :   'demo',
        href        :   '#',
        icon        :   'fa fa-star'
    },{
        text        :   'demo 1',
        href        :   '#',
        icon        :   'fa fa-star',
        subMenus    :   [{
            text        :   'sub demo',
            href        :   '#',
            icon        :   'fa fa-star'
        },{
            text        :   'sub demo 2',
            href        :   '#',
            icon        :   'fa fa-star'
        }]
    },{
        text        :   'demo 1',
        href        :   '#',
        icon        :   'fa fa-star',
        subMenus    :   [{
            text        :   'sub demo',
            href        :   '#',
            icon        :   'fa fa-star'
        },{
            text        :   'sub demo 2',
            href        :   '#',
            icon        :   'fa fa-star'
        }]
    }];

    $scope.levelLimit           =   2;

    /**
    *
    * Show Submenus
    *
    * @param object menu object
    * @param int level
    * @return string
    */

    $scope.showSubMenus     =   function( menu, limit ) {
        return '';
        var string          =   '';
        if( limit < $scope.levelLimit ) {
            if( angular.isDefined( menu.subMenus ) ) {
                if( menu.subMenus.length > 0 ) {
                    string  +=  '<ul class="nav-dropdown-items">';
                    _.each( menu.subMenus, function( value, key ){
                        string  +=  '<li class="nav-item">';
                            string  +=  '<a class="nav-link" href="' + value.href +'">' + value.text + '</a>';
                        string  +=  '</li>';
                    })
                    string  +=  '</ul>';
                }
            }
        }
        return string;
    }

}]);
</script>
