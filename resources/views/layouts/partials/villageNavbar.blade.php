<li class="sidebar-title">Desa</li>

<li class="sidebar-item {{ request()->is('gallery/' . $village->slug . '*') ? 'active' : '' }} has-sub">
    <a href="#" class='sidebar-link'>
        <i class="fas fa-fw fa-map-marked" aria-hidden="true"></i>
        <span class="text-capitalize">{{ strtolower($village->name) }}</span>
    </a>
    <ul class="submenu ">
        <li class="submenu-item {{ request()->is($village->slug . '/leter-c*') ? 'active' : '' }}">
            <a href="{{ route('village.leterC.index', $village->slug) }}">Leter C</a>
        </li>
        <li class="submenu-item {{ request()->is('gallery/' . $village->slug . '/photo*') ? 'active' : '' }}">
            <a href="{{ route('village.photo.index', $village->slug) }}">Photo</a>
        </li>
        <li class="submenu-item {{ request()->is('gallery/' . $village->slug . '/video*') ? 'active' : '' }}">
            <a href="{{ route('village.video.index', $village->slug) }}">Video</a>
        </li>
    </ul>
</li>