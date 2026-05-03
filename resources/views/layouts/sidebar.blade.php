{{-- @php
    $menus = \App\Helpers\MenuHelper::getAdminMenu();
@endphp

<ul>
    @foreach($menus as $menu)
        <li>
            <a href="{{ route($menu['route']) }}">
                {{ $menu['name'] }}
            </a>
        </li>
    @endforeach
</ul> --}}