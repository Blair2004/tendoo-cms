@verbatim
<header class="navbar" ng-controller="headerController">
    <div class="container-fluid">
        <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">&#9776;</button>
        <a class="navbar-brand" href="#"></a>
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler layout-toggler" href="javascript:void(0)">&#9776;</a>
            </li>

            <li class="nav-item px-1" ng-repeat="menu in leftHeaderMenus">
                <a class="nav-link" href="{{ menu.href }}"><i class="{{ menu.icon }}"></i> {{ menu.text }} <span ng-show="menu.counter > 0" class="tag tag-pill tag-{{ menu.counterClass }}">{{ menu.counter }}</span></a>
            </li>
        </ul>
        <ul class="nav navbar-nav pull-right hidden-md-down">
            <li class="nav-item px-1" ng-repeat="menu in rightHeaderMenus">
                <a class="nav-link" href="{{ menu.href }}"><i class="{{ menu.icon }}"></i> {{ menu.text }} <span ng-show="menu.counter > 0" class="tag tag-pill tag-{{ menu.counterClass }}">{{ menu.counter }}</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ user.avatarLink }}" class="img-avatar" alt="{{ user.email }}">
                    <span class="hidden-md-down">{{ user.pseudo }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div ng-repeat="menu in userMenus">
                        <div class="dropdown-header text-xs-center">
                            <strong>{{ menu.text }}</strong>
                        </div>

                        <a class="dropdown-item" href="{{ link.href }}" ng-repeat="link in menu.links"><i class="{{ link.icon }}"></i> {{ link.text }} <span ng-show="link.counter > 0" class="tag tag-{{ link.counterClass }}">{{ link.counter }}</span></a>
                    </div>

                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link aside-toggle" href="#">&#9776;</a>
            </li>

        </ul>
    </div>
</header>
@endverbatim
