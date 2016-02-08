<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    {!! SEO::generate() !!}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/favicon.png">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/cv/style.min.css" rel="stylesheet">
    <link href="/cv/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

    <body>

        @yield('content')
        
        <script src="/js/jquery.js"></script>
        <script src="/js/jquery.uploadPreview.min.js"></script>
        <script src="/cv/star-rating.min.js" type="text/javascript"></script>
        <script src="/cv/cv.js"></script>

    </body>
