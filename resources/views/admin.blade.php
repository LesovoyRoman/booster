
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="public_img_path" content="{{URL::asset('/images')}}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/paper-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}">

</head>
<body>
<div id="app"></div>

<!-- Scripts -->
<script src="{{ asset('js/admin/src/main.js') }}"></script>

</body>
</html>