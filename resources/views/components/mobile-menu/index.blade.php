<!-- BEGIN: Mobile Menu -->
<div @class([
    'mobile-menu group w-full fixed bg-primary/90 z-[60] border-b border-white/[0.08] -mt-5 -mx-3 sm:-mx-8 mb-6 dark:bg-darkmode-800/90 md:hidden',
    "before:content-[''] before:w-full before:h-screen before:z-10 before:fixed before:inset-x-0 before:bg-black/90 before:transition-opacity before:duration-200 before:ease-in-out",
    'before:invisible before:opacity-0',
    '[&.mobile-menu--active]:before:visible [&.mobile-menu--active]:before:opacity-100',
])>
    <div class="flex h-[70px] items-center px-3 sm:px-8">
        <a
            class="mr-auto flex"
            href=""
        >
            <lord-icon
                                        src="https://cdn.lordicon.com/ymgusxed.json"
                                        trigger="loop"
                                        delay="500"
                                        colors="primary:#ffffff,secondary:#848484"
                                        style="width:28px;height:28px">
                                    </lord-icon>
        </a>
        <a
            class="mobile-menu-toggler"
            href="#"
        >
            <x-base.lucide
                class="h-8 w-8 -rotate-90 transform text-white"
                icon="BarChart2"
            />
        </a>
    </div>
    <div @class([
        'scrollable h-screen z-20 top-0 left-0 w-[270px] -ml-[100%] bg-primary transition-all duration-300 ease-in-out dark:bg-darkmode-800',
        '[&[data-simplebar]]:fixed [&_.simplebar-scrollbar]:before:bg-black/50',
        'group-[.mobile-menu--active]:ml-0',
    ])>
        <a
            href="#"
            @class([
                'fixed top-0 right-0 mt-4 mr-4 transition-opacity duration-200 ease-in-out',
                'invisible opacity-0',
                'group-[.mobile-menu--active]:visible group-[.mobile-menu--active]:opacity-100',
            ])
        >
            <x-base.lucide
                class="mobile-menu-toggler h-8 w-8 -rotate-90 transform text-white"
                icon="XCircle"
            />
        </a>
        <ul class="py-2">
            <!-- BEGIN: First Child -->
            @foreach ($sideMenu as $menuKey => $menu)
                @if ($menu == 'divider')
                    <li class="menu__divider my-6"></li>
                @else
                    <li>
                        @if ($menu['permiso'] == 'true')
                        <a
                            class="{{ $firstLevelActiveIndex == $menuKey ? 'menu menu--active' : 'menu' }}"
                            href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}"
                        >
                            <div class="menu__icon">
                                <x-base.lucide icon="{{ $menu['icon'] }}" />
                            </div>
                            <div class="menu__title">
                                {{ $menu['title'] }}
                                @if (isset($menu['sub_menu']))
                                    <div
                                        class="menu__sub-icon {{ $firstLevelActiveIndex == $menuKey ? 'transform rotate-180' : '' }}">
                                        <x-base.lucide icon="ChevronDown" />
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endif
                        @if (isset($menu['sub_menu']))
                            <ul class="{{ $firstLevelActiveIndex == $menuKey ? 'menu__sub-open' : '' }}">
                                @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                    <li>
                                        <a
                                            class="{{ $secondLevelActiveIndex == $subMenuKey ? 'menu menu--active' : 'menu' }}"
                                            href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}"
                                        >
                                            <div class="menu__icon">
                                                <x-base.lucide icon="{{ $subMenu['icon'] }}" />
                                            </div>
                                            <div class="menu__title">
                                                {{ $subMenu['title'] }}
                                                @if (isset($subMenu['sub_menu']))
                                                    <div
                                                        class="menu__sub-icon {{ $secondLevelActiveIndex == $subMenuKey ? 'transform rotate-180' : '' }}">
                                                        <x-base.lucide icon="ChevronDown" />
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                        @if (isset($subMenu['sub_menu']))
                                            <ul
                                                class="{{ $secondLevelActiveIndex == $subMenuKey ? 'menu__sub-open' : '' }}">
                                                @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                    <li>
                                                        <a
                                                            class="{{ $thirdLevelActiveIndex == $lastSubMenuKey ? 'menu menu--active' : 'menu' }}"
                                                            href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}"
                                                        >
                                                            <div class="menu__icon">
                                                                <x-base.lucide icon="{{ $lastSubMenu['icon'] }}" />
                                                            </div>
                                                            <div class="menu__title">{{ $lastSubMenu['title'] }}</div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
            <!-- END: First Child -->
        </ul>
    </div>
</div>
<!-- END: Mobile Menu -->

@once
    @push('vendors')
        @vite('resources/js/vendor/simplebar/index.js')
    @endpush
@endonce

@once
    @push('scripts')
        @vite('resources/js/components/mobile-menu/index.js')
    @endpush
@endonce
