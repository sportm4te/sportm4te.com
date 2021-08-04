<!DOCTYPE HTML>
<html lang="en" class="@yield('html-class')">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover"/>
    <title>SportM4te</title>
    <link rel="stylesheet" type="text/css" href="/styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/fonts/css/fontawesome-all.min.css">
    <link rel="manifest" href="_manifest.json">
    <link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" class="page-highlight" type="text/css" href="{{ url('/styles/highlights/highlight_sportm4te.css') }}">
    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
</head>
<body class="theme-light">
<div id="preloader">
    <div class="spinner-border color-highlight" role="status"></div>
</div>
<div id="page">
    @if(!auth()->guest())
        @hasSection('header')
            @yield('header')
        @else
            @include('components.header')
            @include('components.footer')
        @endif
        <div class="page-title page-title-fixed" style="opacity: 1;">
            @yield('title_html')
            @if(request()->routeIs('events.detail'))
                <a href="#" class="page-title-icon shadow-xl bg-theme color-theme" data-menu="menu-share"><i class="fa fa-share-alt"></i></a>
            @endif
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-light" data-toggle-theme=""><i class="fa fa-moon"></i></a>
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-dark" data-toggle-theme=""><i class="fa fa-lightbulb color-yellow-dark"></i></a>
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme" data-menu="menu-main"><i class="fa fa-bars"></i></a>
        </div>
        <div class="page-title-clear"></div>
        <div class="page-content">
    @else
                @hasSection('title_html')
                    @include('components.header')
                    <div class="page-title page-title-fixed" style="opacity: 1;">
                        @yield('title_html')
                    </div>
                    <div class="page-title-clear"></div>
                @endif
                <div class="page-content pb-0">
    @endif
                    @yield('content')
                </div>

                @if(!auth()->guest())
                    <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-width="280" data-menu-active="nav-homepages" style="display: block; width: 280px;">
                        <div class="list-menu mt-3">
                            <img src="/images/logo.svg" style="height: 60px" class="logo-dark">
                            <img src="/images/logo-dark.svg" style="height: 60px" class="logo-light">
                        </div>
                        <div class="mt-4"></div>
                        <div class="list-group list-custom-small list-menu">
                            <a id="nav-welcome" href="{{ route('dashboard') }}" class="show-offline">
                                <i class="fa fa-home gradient-blue color-white"></i> <span>Dashboard</span>
                                <i class="fa fa-angle-right"></i> </a>
                            <a id="nav-welcome" href="{{ auth()->user()->link() }}" class="show-offline">
                                <i class="fa fa-user gradient-orange color-white"></i> <span>My Profile</span>
                                <i class="fa fa-angle-right"></i> </a>
                            <a id="nav-welcome" href="{{ route('users.list') }}" class="show-offline">
                                <i class="fa fa-users gradient-magenta color-white"></i> <span>Search Users</span>
                                <i class="fa fa-angle-right"></i> </a>
                            <a id="nav-homepages" href="{{ route('settings') }}" class="show-offline">
                                <i class="fa fa-cog gradient-yellow color-white"></i> <span>Settings</span>
                                <i class="fa fa-angle-right"></i> </a>
                            <a id="nav-homepages" href="{{ route('sport-choose') }}" class="show-offline">
                                <i class="fa fa-list-ol gradient-mint color-white"></i> <span>Sport Preferences</span>
                                <i class="fa fa-angle-right"></i> </a>
                            <a id="nav-pages" href="{{ route('events.make') }}" class="show-offline">
                                <i class="fa fa-plus gradient-brown color-white"></i> <span>Create Event</span>
                                <i class="fa fa-angle-right"></i> </a>
                        </div>
                        <div class="list-group list-custom-small list-menu">
                            <a href="#" data-toggle-theme="" data-trigger-switch="switch-dark-mode">
                                <i class="fa fa-moon gradient-dark color-white"></i> <span>Dark Mode</span>
                                <div class="custom-control small-switch ios-switch">
                                    <input data-toggle-theme="" type="checkbox" class="ios-input" id="toggle-dark-menu">
                                    <label class="custom-control-label" for="toggle-dark-menu"></label>
                                </div>
                            </a>
                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out-alt gradient-red color-white"></i> <span>Sign Out</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <a href="{{ route('about') }}">
                                <i class="fa fa-info-circle gradient-green color-white"></i> <span>About</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                        @if(auth()->user()->friends()->isNotEmpty())
                            <h6 class="menu-divider mt-4">FRIENDS</h6>
                            <div class="list-group list-custom-small list-menu">
                                @foreach(auth()->user()->friends() as $friend)
                                    <a href="{{ $friend->link() }}"> <img src="{{ $friend->image() }}">
                                        <span>{{ $friend->formatName() }}</span> <i class="fa fa-angle-right"></i> </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-height="370">
                        <div class="menu-title">
                            <p class="color-highlight">Tap a link to</p>
                            <h1>Share</h1>
                            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
                        </div>
                        <div class="divider divider-margins mt-3 mb-0"></div>
                        <div class="content mt-0">
                            <div class="list-group list-custom-small list-icon-0">
                                <a href="" class="external-link shareToFacebook">
                                    <i class="fab fa-facebook-f font-12 bg-facebook color-white shadow-l rounded-s"></i>
                                    <span>Facebook</span> <i class="fa fa-angle-right pr-1"></i> </a>
                                <a href="" class="external-link shareToTwitter">
                                    <i class="fab fa-twitter font-12 bg-twitter color-white shadow-l rounded-s"></i>
                                    <span>Twitter</span> <i class="fa fa-angle-right pr-1"></i> </a>
                                <a href="" class="external-link shareToLinkedIn">
                                    <i class="fab fa-linkedin-in font-12 bg-linkedin color-white shadow-l rounded-s"></i>
                                    <span>LinkedIn</span> <i class="fa fa-angle-right pr-1"></i> </a>
                                <a href="" class="external-link shareToWhatsApp">
                                    <i class="fab fa-whatsapp font-12 bg-whatsapp color-white shadow-l rounded-s"></i>
                                    <span>WhatsApp</span> <i class="fa fa-angle-right pr-1"></i> </a>
                                <a href="" class="external-link shareToMail border-0">
                                    <i class="fa fa-envelope font-12 bg-mail color-white shadow-l rounded-s"></i>
                                    <span>Email</span> <i class="fa fa-angle-right pr-1"></i> </a>
                            </div>
                        </div>
                    </div>
                @endif
        </div>

        @yield('after:content')
        <div id="success" class="menu menu-box-modal rounded-m" data-menu-hide="2500" data-menu-width="220" data-menu-height="160">
            <h1 class="text-center fa-5x mt-2 pt-3 pb-2"><i class="fa fa-check-circle color-green-dark"></i></h1>
            <h2 class="text-center">Updated!</h2>
        </div>
        <div id="error" class="menu menu-box-modal rounded-m" data-menu-hide="2500" data-menu-width="220" data-menu-height="165">
            <h1 class="text-center fa-5x mt-2 pt-3 pb-2"><i class="fa fa-exclamation-triangle color-red-dark"></i></h1>
            <h2 class="text-center">Something went wrong!</h2>
        </div>

        <div id="basic-snackbar" class="snackbar-toast color-white bg-red-dark" data-bs-delay="3000" data-bs-autohide="true">
        </div>

        <script type="text/javascript" src="/scripts/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/custom.js?v=2"></script>
        <script>
            sportM4te.init('{{ getToken() }}');
        </script>
        @yield('after:scripts')
</html>
</body>
