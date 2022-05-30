<li class="sidebar-title">Bidang-bidang</li>

@foreach ($fields as $field)
    <li class="sidebar-item {{ request()->is('gallery/' . $field->slug . '*') ? 'active' : '' }} has-sub">
        <a href="#" class='sidebar-link'>
            <i class="fas fa-fw fa-users" aria-hidden="true"></i>
            <span>{{ $field->name }}</span>
        </a>
        <ul class="submenu ">
            <li class="submenu-item {{ request()->is('gallery/' . $field->slug . '/photo*') ? 'active' : '' }}">
                <a href="{{ route('photo.index', $field->slug) }}">Photo</a>
            </li>
            <li class="submenu-item {{ request()->is('gallery/' . $field->slug . '/video*') ? 'active' : '' }}">
                <a href="{{ route('video.index', $field->slug) }}">Video</a>
            </li>
        </ul>
    </li>
@endforeach

<li class="sidebar-title">Desa-desa</li>

@foreach ($villages as $village)
    <li class="sidebar-item {{ request()->is('gallery/' . $village->slug . '*') ? 'active' : '' }} has-sub">
        <a href="#" class='sidebar-link'>
            <i class="fas fa-fw fa-map-marked" aria-hidden="true"></i>
            <span class="text-capitalize">{{ strtolower($village->name) }}</span>
        </a>
        <ul class="submenu ">
            <li class="submenu-item {{ request()->is($village->slug . '/leter-c*') ? 'active' : '' }}">
                <a href="{{ route('leterC.index', $village->slug) }}">Leter C</a>
            </li>
            <li class="submenu-item {{ request()->is('gallery/' . $village->slug . '/photo*') ? 'active' : '' }}">
                <a href="{{ route('photo.index', $village->slug) }}">Photo</a>
            </li>
            <li class="submenu-item {{ request()->is('gallery/' . $village->slug . '/video*') ? 'active' : '' }}">
                <a href="{{ route('video.index', $village->slug) }}">Video</a>
            </li>
        </ul>
    </li>
@endforeach