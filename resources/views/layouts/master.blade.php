<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    @yield('extra-css')

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Timetable Pusher</title>
</head>

<body>

<nav class="grey darken-3" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="/" class="brand-logo">Timetable Pusher
            <small>for Pebble</small>
        </a>
        <ul class="right hide-on-med-and-down">
            @include('layouts.navigation')
        </ul>

        <ul id="nav-mobile" class="side-nav">
            @include('layouts.navigation')
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>

<main class="section main">

    @yield('content')

</main>
<footer class="page-footer grey darken-3">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5>About Timetable Pusher</h5>

                <p class="grey-text text-lighten-4">Timetable Pusher is a Pebble app which pushes your whole weekly
                    timetable schedule to your Pebble watch.</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright grey darken-4">
        <div class="container">
            Made by <a class="orange-text text-lighten-3" href="http://iamkelv.in/">Kelvin Zhang</a>. Questions?
            Reach out to me via <a class="orange-text text-lighten-3" href="mailto:timetablepusher@iamkelv.in">email</a>.
        </div>
    </div>
</footer>


<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
<script src="/js/init.js"></script>
@yield('extra-js')
</body>
</html>