<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    {!! SEO::generate() !!}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/favicon.png">
    <link href="/cv/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/cv/animate.css">
    <link href="/css/font-awesome.min.css" rel="stylesheet"> 
    <link href="/cv/style.css" rel="stylesheet">

    <body>

        @yield('content')
        
        <script src="/js/jquery.js"></script>
        <script src="/cv/materialize.min.js"></script>
        <script src="/cv/wow.min.js"></script>
        <script src="/js/cv.js"></script>
    </body>
