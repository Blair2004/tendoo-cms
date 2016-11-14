<script type="text/javascript">
tendooApp.controller( 'headerController', [ '$scope', function( $scope ){
    /**
     * Header Menus
    **/

    $scope.leftHeaderMenus      =   [{
        href        :   '#',
        text        :   'Hello'
    },{
        href        :   '#',
        text        :   'World',
        counter     :   20,
        counterClass:   'danger'
    }];

    /**
     * Right Header menu
    **/

    $scope.rightHeaderMenus      =   [{
        href        :   '#',
        text        :   'Hello'
    },{
        href        :   '#',
        text        :   'World',
        counter     :   6,
        counterClass:   'info'
    }]

    /**
     * User menu
    **/

    $scope.userMenus            =   [{
        text        :   'account',
        links       :   [{
            href    :   '#',
            text    :   'Settings',
            icon    :   'fa fa-wrench',
            counter :   35,
            counterClass    :   'warning'
        }]
    }];

    /**
     * User objects
    **/

    $scope.user         =   {
        pseudo        :   'Blair',
        email       :   'carlosjohnsonluv2004@gmail.com'
    }
}])

</script>
