<li class="sidebar-title">Bidang</li>

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