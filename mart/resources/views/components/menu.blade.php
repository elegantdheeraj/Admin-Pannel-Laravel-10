@php
    $menus = \App\Models\Role::getMenus();
    $role_permission = \App\Models\Role::rolePermissions();
    //dd($menus);
@endphp
<ul class="menu-inner py-1">
    <!-- Dashboard -->
    @foreach ($menus as $level1)
        @if($level1['is_visible'] && (in_array($level1['slag'], $role_permission)))
            @if(!isset($level1['child']))
                <li class="menu-item {{ session()->get('active_menu') == $level1['slag'] ? 'active' : '' }}">
                    <a href="{{ url($level1['slag']) }}" class="menu-link">
                        <i class="menu-icon tf-icons bx {{$level1['icon']}}"></i>
                        <div data-i18n="{{ $level1['name'] }}">{{ $level1['name'] }}</div>
                    </a>
                </li>
            @else
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx {{$level1['icon']}}"></i>
                        <div data-i18n="{{ $level1['name'] }}">{{ $level1['name'] }}</div>
                    </a>
                    <ul class="menu-sub">
                        @foreach ($level1['child'] as $level2)
                            @if($level2['is_visible'] && (in_array($level2['slag'], $role_permission)))
                                @if(!isset($level2['child']))
                                    <li class="menu-item {{ session()->get('active_menu') == $level2['slag'] ? 'active' : '' }}">
                                        <a href="{{ url($level2['slag']) }}" class="menu-link">
                                            <div data-i18n="{{ $level2['name'] }}">{{ $level2['name'] }}</div>
                                        </a>
                                    </li>
                                @else
                                    <li class="menu-item">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <div class="text-truncate" data-i18n="{{ $level2['name']}}">{{ $level2['name']}}</div>
                                        </a>
                                        <ul class="menu-sub">
                                            @foreach ($level2['child'] as $level3)
                                                @if($level3['is_visible'] && (in_array($level3['slag'], $role_permission)))
                                                    <li class="menu-item {{ session()->get('active_menu') == $level3['slag'] ? 'active' : '' }}">
                                                        <a href="{{ url($level3['slag']) }}" class="menu-link">
                                                            <div class="text-truncate" data-i18n="Role">{{ $level3['name'] }}</div>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
        @endif
    @endforeach
</ul>
