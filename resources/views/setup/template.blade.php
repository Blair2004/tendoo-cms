<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>@yield( 'document_title' )</title>
        {!! Html::style('bower_components/font-awesome/css/font-awesome.min.css') !!}
        {!! Html::style('css/simple-line-icons.css') !!}
        {!! Html::style('css/style.css') !!}
    </head>
    <body>
        @yield( 'document_content' )
    </body>
</html>
