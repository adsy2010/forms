<!doctype html>
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cover.css') }}" rel="stylesheet">
</head>
<body>
<div id="compatibleBrowsers" style="display:none;">
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
        <header class="masthead mb-auto">
            <div class="inner">
                <h3 class="masthead-brand">Mountbatten Services</h3>
            </div>
        </header>

        <main role="main" class="inner cover">
            <h1 class="cover-heading">Incompatible browser detected!</h1>
            <p class="lead">For your own online safety, we do not allow access to this service with certain internet browsers.
                We have tested this system with the following internet browsers on a number of platforms including iOS, Android, Windows and Mac:
            </p>
            <p class="lead">
                <a href="https://www.google.co.uk/chrome/" class="btn btn-lg btn-primary"><img style="width:50px;" src="/files/images/site/chrome.png">  Chrome</a>
                <a href="https://www.opera.com/download" class="btn btn-lg btn-primary"><img style="width:50px;" src="/files/images/site/opera.png">  Opera</a>
                <a href="https://www.mozilla.org/en-GB/firefox/new/" class="btn btn-lg btn-primary"><img style="width:50px;" src="/files/images/site/firefox.png">  Firefox</a>
                <a href="https://www.apple.com/uk/safari/" class="btn btn-lg btn-primary"><img style="width:50px;" src="/files/images/site/safari.png">  Safari</a>
            </p>
            <div>
                <hr>
                <h3>Why don't we support this browser?</h3><br/>
                <p class="lead">One of the crucial technologies revolving around access to data cannot be accessed by this browser,
                    so we recommend using one of the internet browsers above.</p>
            </div>
            <div>
                <hr>
                <h3></h3><br/>
                <p class="lead"></p>
            </div>

        </main>

        <footer class="mastfoot mt-auto">
            <div class="inner">
                <p></p>
            </div>
        </footer>
    </div>
</div>
@auth
    <script>
        window.location = "/v2#/user";
    </script>
@else
    <script>

            let isAsync = true;

            try {
                eval('async () => {}');
            } catch (e) {
                if (e instanceof SyntaxError)
                    isAsync = false;
                else
                    throw e; // throws CSP error
            }
            if(isAsync === false){
                console.log("not compatible");
                document.getElementById('compatibleBrowsers').style.display = ""
            }else{
                window.location = "https://saml.mountbatten.hants.sch.uk/login/forms";
            }
            //
    </script>
@endauth
</body>
</html>