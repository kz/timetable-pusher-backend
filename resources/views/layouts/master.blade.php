<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
    <!-- Begin MailChimp Signup Form -->
    <link href="//cdn-images.mailchimp.com/embedcode/slim-10_7.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif;  width:500px;}
        /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
    </style>
    <!--End mc_embed_signup-->
    <script>
    window.addEventListener("load", function(){
    window.cookieconsent.initialise({
      "palette": {
        "popup": {
          "background": "#252e39"
        },
        "button": {
          "background": "#14a7d0"
        }
      },
      "position": "bottom-right",
      "content": {
        "message": "This website uses cookies to keep you logged in and to enhance your browsing experience. We do not track any personal information."
      }
    })});
    </script>

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
                <h5>Note on Pebble Server Shutdown</h5>

                <p class="grey-text text-lighten-4">Timetable Pusher aims to work for at least a year after Pebble servers are shut down by switching to the (volunteer-driven) Rebble project's servers after the end of June 2018. You can find more details <a href="http://rebble.io/2018/02/15/rebble-web-services.html">here</a>.</p>
                <div id="mc_embed_signup">
                    <form action="https://timetablepush.us18.list-manage.com/subscribe/post?u=7eb8df044a36724255d172f9d&amp;id=76fb74eb4a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div id="mc_embed_signup_scroll">
                            <label for="mce-EMAIL">Stay updated with how Timetable Pusher will handle Pebble's shutdown</label>
                            <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                            <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_7eb8df044a36724255d172f9d_76fb74eb4a" tabindex="-1" value=""></div>
                            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                        </div>
                    </form>
                </div>
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
