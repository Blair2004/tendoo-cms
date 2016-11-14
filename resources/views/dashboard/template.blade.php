<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>@yield( 'document_title' )</title>
        <!-- Style Section -->
        {!! Html::style('bower_components/font-awesome/css/font-awesome.min.css') !!}
        {!! Html::style('css/simple-line-icons.css') !!}
        {!! Html::style('css/style.css') !!}
        <!-- Script Section -->
        {!! Html::script('bower_components/underscore/underscore-min.js') !!}
        {!! Html::script('bower_components/jquery/dist/jquery.min.js') !!}
        {!! Html::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
        <!-- {!! Html::script('js/app.js') !!}-->
        {!! Html::script('bower_components/angular/angular.min.js') !!}
        <!-- Angular Inition -->
        @include('dashboard/includes/angular/module/tendooAppModule')
        <!-- Directives-->
        @include('dashboard/includes/angular/directives/navigationDirective')
        @include('dashboard/includes/angular/directives/navDirective')
        @include('dashboard/includes/angular/directives/subNavDirective')
    </head>
    <body ng-app="tendooApp" class="navbar-fixed sidebar-nav fixed-nav">
        <!-- Header : Tendoo APP Dasboard Header -->
        @include('dashboard/includes/header')
        <!-- Sidebar : Tendoo APP Dasboard Sidebar -->
        @include('dashboard/includes/sidebar')
        <!-- Content : Tendoo APP Dasboard Content -->
        @include('dashboard/includes/content')
        <!-- Aside : Tendoo APP Dasboard Aside -->
        @include('dashboard/includes/aside')
        <!-- Footer : Tendoo APP Dasboard Footer -->
        @include('dashboard/includes/footer')
        <!-- Load Controller -->
        @include('dashboard/includes/angular/controllers/headerController' )
        <!-- Javascript Footer -->
        @include('dashboard/includes/angular/controllers/asideController' )
        @include('dashboard/includes/angular/controllers/sidebarController' )        @include('dashboard/includes/angular/controllers/footerController' )
        @include('dashboard/includes/angular/controllers/contentController' )
    </body>
</html>
