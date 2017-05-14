<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Styles -->
    {{ Html::style('js/lib/bootstrap/dist/css/bootstrap.css') }}
    {{ Html::style('js/lib/datepicker/css/datepicker.css') }}
    {{ Html::style('css/style.css') }}

    @stack('styles')

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token()
        ]) !!};
    </script>
</head>
<body>
<div id="wrapper">
    <!-- Header -->
    @include('header')

    <div id="app" ng-app="App" class="container">
        <div class="messages">
            @include('errors')
        </div>
        @yield('content')
    </div>

    <!-- Footer -->
    @include('footer')

<!-- Scripts -->
    {{ Html::script('js/lib/jquery/dist/jquery.min.js') }}
    {{ Html::script('js/lib/angular/angular.min.js') }}
    {{ Html::script('js/lib/bootstrap/dist/js/bootstrap.min.js') }}
    {{ Html::script('js/lib/angular-bootstrap/ui-bootstrap.min.js') }}
    {{ Html::script('js/lib/datepicker/js/bootstrap-datepicker.js') }}
    {{ Html::script('js/app/app.js') }}

    {{ Html::script('js/scripts.js') }}

    @stack('scripts')
</div>
</body>
</html>