<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/lineicons.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/fullcalendar.css')}}" />
    <link rel="stylesheet" href="{{asset('css/fullcalendar.css')}}" />
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />

</head>

<body>
    <div id="preloader">
        <div class="spinner"></div>
    </div>

    @include('layouts.sidebar')
    <div class="overlay"></div>

    <main class="main-wrapper">
        @include('layouts.header')

        <section class="section">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </section>

        @include('layouts.footer')
    </main>

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/Chart.min.js')}}"></script>
    <script src="{{asset('js/dynamic-pie-chart.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.js')}}"></script>
    <script src="{{asset('js/jvectormap.min.js')}}"></script>
    <script src="{{asset('js/world-merc.js')}}"></script>
    <script src="{{asset('js/polyfill.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

    @isset($script)
    {{ $script }}
    @endisset
</body>

</html>