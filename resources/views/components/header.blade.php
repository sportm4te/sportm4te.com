<div class="header header-fixed header-logo-center header-auto-show">
    <a href="{{ url()->previous() }}" class="header-title">@yield('title')</a>
    <a href="#" data-back-button="" class="header-icon header-icon-1"><i class="fas fa-chevron-left"></i></a>
    @if(!auth()->guest())
        <a href="#" data-menu="menu-main" class="header-icon header-icon-4"><i class="fas fa-bars"></i></a>
        <a href="#" data-toggle-theme="" class="header-icon header-icon-3 show-on-theme-dark"><i class="fas fa-sun"></i></a>
        <a href="#" data-toggle-theme="" class="header-icon header-icon-3 show-on-theme-light"><i class="fas fa-moon"></i></a>
    @endif
</div>
