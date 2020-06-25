<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/forms.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.3/tinymce.min.js"></script>
    <script src="https://kit.fontawesome.com/f0d1aca40f.js" crossorigin="anonymous"></script>
    <script>

        tinymce.init({
            selector: 'textarea',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
        });</script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg heading-style fixed-top">


        <!-- Branding Image -->
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="https://outlook.com/mountbatten.hants.sch.uk">
                        <img class="" src="/files/images/site/outlookweb.png" width="32" height="32" alt="...">
                        Email
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                        <img class="" src="/files/images/site/sims.png" width="32" height="32" alt="...">
                        SIMS
                        <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="https://student.sims.co.uk/">
                                <img class="" src="/files/images/site/simsstudent.png" width="32" height="32" alt="...">
                                Student
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="https://www.sims-parent.co.uk/">
                                <img class="" src="/files/images/site/simsparent.png" width="32" height="32" alt="...">
                                Parent
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                        <img class="" src="/files/images/site/google.png" width="32" height="32" alt="...">
                        Google
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="https://mail.google.com/a/themountbattenschool.org">
                                <img class="" src="/files/images/site/gmail.png" width="32" height="32" alt="...">
                                Gmail
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="https://drive.google.com/a/themountbattenschool.org">
                                <img class="" src="/files/images/site/drive.png" width="32" height="32" alt="...">
                                Drive
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="https://docs.google.com/a/themountbattenschool.org">
                                <img class="" src="/files/images/site/docs.png" width="32" height="32" alt="...">
                                Docs
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="https://sheets.google.com/a/themountbattenschool.org">
                                <img class="" src="/files/images/site/sheets.png" width="32" height="32" alt="...">
                                Sheets
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="https://slides.google.com/a/themountbattenschool.org">
                                <img class="" src="/files/images/site/slides.png" width="32" height="32" alt="...">
                                Slides
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="https://classroom.google.com/a/themountbattenschool.org">
                                <img class="" src="/files/images/site/classroom.png" width="32" height="32" alt="...">
                                Classroom
                            </a>
                        </li>
                    </ul>



            </ul>

            <ul class="navbar-nav ml-auto">

                @auth
                    <li class="nav-item dropdown hidden-md-down">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            {{ Auth::user()->uid }} <img style="max-height: 32px; width: auto;" class="rounded-circle"
                                                                                                         src="{{ file_exists(storage_path("app/public/images/staff/".strtoupper(Auth::user()->uid).".jpg")) ? "/files/images/staff/".Auth::user()->uid.".jpg" : '/images/staff/placeholder.png' }}"
                                                                                                         alt="...">


                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        @auth
                            @if(Auth::user()->hasRole("Domain Admins"))
                                <router-link :to="{ name: 'Admin Dashboard' }" class="dropdown-item"><strong><span class="fa fa-dashboard"></span> Admin Panel</strong></router-link>
                            @endif
                        @endauth
                        <router-link :to="{ name: 'User Dashboard' }" class="dropdown-item"><strong><span class="fa fa-home"></span> My Dashboard</strong></router-link>
                        <router-link :to="{ name: 'Messages'}" class="dropdown-item"><strong><span class="fa fa-file-text"></span> Messages Panel</strong></router-link>
                        <a class="dropdown-item"><div class="dropdown-divider"></div></a>
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="dropdown-item">

                            <strong>Logout</strong>
                        </a>
                    </div>
                </li>
                @endauth
                @guest
                    <li class="nav-item">Guest</li>
                @endguest

            </ul>
        </div>
    </nav>
<div style="margin-top: 80px;">
    @yield('content')
</div>
    @yield('modals')
</div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/forms.js') }}"></script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
</body>
</html>
