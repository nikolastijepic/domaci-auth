<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/bootstrap-app.css', 'resources/js/bootstrap-app.js'])
    <title>@yield('pageTitle')</title>
</head>
<body>
@include('admin-navigation')

@yield('pageContent')
</body>
</html>
