<div id="footer-bar" class="footer-bar-6" style="transform: translateX(0px);">
    @php
        $menu = [
            'events.list' => [
                'icon' => 'fa fa-search',
                'title' => 'Search',
            ],
            'events.me' => [
                'icon' => 'fa fa-calendar',
                'title' => 'My events',
            ],
            'dashboard' => [
                'icon' => 'fa fa-home',
                'title' => 'Home',
                'circle' => true,
            ],
            'settings' => [
                'icon' => 'fa fa-cog',
                'title' => 'Settings',
            ],
        ];
    @endphp
    @foreach($menu as $route => $item)
        <a href="{{ route($route) }}" class="{{ ((!empty($item['circle'])) ? 'circle-nav' : '').((request()->routeIs($route)) ? ' active-nav' : '') }}">
            <i class="{{ $item['icon'] }}"></i>
            <span>{{ $item['title'] }}</span>
            @if(!empty($item['circle']))
                <strong><u></u></strong>
            @endif
            @if(request()->routeIs($route))
                <em></em>
            @endif
        </a>
    @endforeach
    <a href="#" data-menu="menu-main">
        <i class="fa fa-bars"></i>
        <span>Menu</span>
    </a>
</div>
