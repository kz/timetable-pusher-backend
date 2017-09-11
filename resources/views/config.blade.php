<!DOCTYPE html>
<html>
<head>
    <title>Timetable Pusher Configuration</title>
    <link rel='stylesheet' type='text/css' href='/config/css/slate.min.css'>
    <script src='/config/js/slate.min.js'></script>
    <style>
        .title {
            padding: 15px 10px;
            text-transform: uppercase;
            font-family: 'PT Sans', sans-serif;
            font-size: 1.2em;
            font-weight: 500;
            color: #888888;
            text-align: center;
        }
    </style>
</head>

<body>
<h1 class='title'>Timetable Pusher Configuration</h1>

<div class='item-container'>
    <div class='item-container-content'>
        <div class='item'>
            Create your timetable(s) by signing up at <a href="https://timetablepush.me/">timetablepush.me</a> (desktop
            recommended) and paste your API token from the website below.
        </div>
    </div>
</div>

<div class="item-container">
    <div class="item-container-header">API Key</div>
    <div class="item-container-content">
        <label class="item">
            <div class="item-input-wrapper">
                <input type="text" class="item-input" name="apiKey" id="apiKey" placeholder="API Key">
            </div>
        </label>
    </div>
</div>

<div class='item-container'>
    <div class='button-container'>
        <input id='submit_button' type='button' class='item-button' value='Save API Key'>
    </div>
</div>
</body>
<script type="text/javascript">
    function getConfigData() {
        var apiKey = document.getElementById('apiKey');

        var options = {
            'apiKey': apiKey.value
        };

        // Save for next launch
        localStorage['apiKey'] = options['apiKey'];

        return options;
    }

    function getQueryParam(variable, defaultValue) {
        var query = location.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            if (pair[0] === variable) {
                return decodeURIComponent(pair[1]);
            }
        }
        return defaultValue || false;
    }

    var submitButton = document.getElementById('submit_button');
    submitButton.addEventListener('click', function () {
        console.log('Submit');

        // Set the return URL depending on the runtime environment
        var return_to = getQueryParam('return_to', 'pebblejs://close#');
        document.location = return_to + encodeURIComponent(JSON.stringify(getConfigData()));
    });

    (function () {
        var apiKey = document.getElementById('apiKey');

        // Load any previously saved configuration, if available
        if (localStorage['apiKey']) {
            apiKey.value = localStorage['apiKey'];
        }
    })();
</script>
</html>