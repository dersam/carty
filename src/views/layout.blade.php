<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Demo shopping cart">
    <meta name="author" content="Sam Schmidt">

    <title>{{$title}}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    {{ HTML::style('packages/dersam/carty/css/carty.css'); }}
</head>

<body>
@yield('content')
<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
{{HTML::script('packages/dersam/carty/js/carty.js')}}
{{HTML::script('packages/dersam/carty/js/handlebars-v2.0.0.js')}}
{{HTML::script('packages/dersam/carty/js/jquery.noty.packaged.min.js')}}
</body>
</html>