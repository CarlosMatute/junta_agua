<!-- BEGIN: Top Bar -->
<div class="relative z-[51] flex h-[67px] items-center border-b border-slate-200">
    <!-- BEGIN: Breadcrumb -->
    <x-base.breadcrumb class="-intro-x mr-auto hidden sm:flex">
<!--        <x-base.breadcrumb.link :index="0">Application</x-base.breadcrumb.link>
        <x-base.breadcrumb.link
            :index="1"
            :active="true"
        >
            Dashboard
        </x-base.breadcrumb.link>-->
    </x-base.breadcrumb>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Search -->
<!--    <div class="search intro-x relative mr-3 sm:mr-6">
        <div class="relative hidden sm:block">
            <x-base.form-input
                class="w-56 rounded-full border-transparent bg-slate-300/50 pr-8 shadow-none transition-[width] duration-300 ease-in-out focus:w-72 focus:border-transparent dark:bg-darkmode-400/70"
                type="text"
                placeholder="Search..."
            />
            <x-base.lucide
                class="absolute inset-y-0 right-0 my-auto mr-3 h-5 w-5 text-slate-600 dark:text-slate-500"
                icon="Search"
            />
        </div>
        <a
            class="relative text-slate-600 sm:hidden"
            href=""
        >
            <x-base.lucide
                class="h-5 w-5 dark:text-slate-500"
                icon="Search"
            />
        </a>
        <x-base.transition
            class="search-result absolute right-0 z-10 mt-[3px] hidden"
            selector=".show"
            enter="transition-all ease-linear duration-150"
            enterFrom="mt-5 invisible opacity-0 translate-y-1"
            enterTo="mt-[3px] visible opacity-100 translate-y-0"
            leave="transition-all ease-linear duration-150"
            leaveFrom="mt-[3px] visible opacity-100 translate-y-0"
            leaveTo="mt-5 invisible opacity-0 translate-y-1"
        >
            <div class="box w-[450px] p-5">
                <div class="mb-2 font-medium">Pages</div>
                <div class="mb-5">
                    <a
                        class="flex items-center"
                        href=""
                    >
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-success/20 text-success dark:bg-success/10">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="Inbox"
                            />
                        </div>
                        <div class="ml-3">Mail Settings</div>
                    </a>
                    <a
                        class="mt-2 flex items-center"
                        href=""
                    >
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-pending/10 text-pending">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="Users"
                            />
                        </div>
                        <div class="ml-3">Users & Permissions</div>
                    </a>
                    <a
                        class="mt-2 flex items-center"
                        href=""
                    >
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary/80 dark:bg-primary/20">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="CreditCard"
                            />
                        </div>
                        <div class="ml-3">Transactions Report</div>
                    </a>
                </div>
                <div class="mb-2 font-medium">Users</div>
                <div class="mb-5">
                    @foreach (array_slice($fakers, 0, 4) as $faker)
                        <a
                            class="mt-2 flex items-center"
                            href=""
                        >
                            <div class="image-fit h-8 w-8">
                                <img
                                    class="rounded-full"
                                    src="{{ Vite::asset($faker['photos'][0]) }}"
                                    alt="Midone Tailwind HTML Admin Template"
                                />
                            </div>
                            <div class="ml-3">{{ $faker['users'][0]['name'] }}</div>
                            <div class="ml-auto w-48 truncate text-right text-xs text-slate-500">
                                {{ $faker['users'][0]['email'] }}
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mb-2 font-medium">Products</div>
                @foreach (array_slice($fakers, 0, 4) as $faker)
                    <a
                        class="mt-2 flex items-center"
                        href=""
                    >
                        <div class="image-fit h-8 w-8">
                            <img
                                class="rounded-full"
                                src="{{ Vite::asset($faker['images'][0]) }}"
                                alt="Midone Tailwind HTML Admin Template"
                            />
                        </div>
                        <div class="ml-3">{{ $faker['products'][0]['name'] }}</div>
                        <div class="ml-auto w-48 truncate text-right text-xs text-slate-500">
                            {{ $faker['products'][0]['category'] }}
                        </div>
                    </a>
                @endforeach
            </div>
        </x-base.transition>
    </div>-->
    <!-- END: Search  -->
    <!-- BEGIN: Notifications -->
<!--    <x-base.popover class="intro-x mr-auto sm:mr-6">
        <x-base.popover.button
            class="relative block text-slate-600 outline-none before:absolute before:top-[-2px] before:right-0 before:h-[8px] before:w-[8px] before:rounded-full before:bg-danger before:content-['']"
        >
            <x-base.lucide
                class="h-5 w-5 dark:text-slate-500"
                icon="Bell"
            />
        </x-base.popover.button>
        <x-base.popover.panel class="mt-2 w-[280px] p-5 sm:w-[350px]">
            <div class="mb-5 font-medium">Notifications</div>
            @foreach (array_slice($fakers, 0, 5) as $fakerKey => $faker)
                <div @class([
                    'cursor-pointer relative flex items-center',
                    'mt-5' => $fakerKey,
                ])>
                    <div class="image-fit relative mr-1 h-12 w-12 flex-none">
                        <img
                            class="rounded-full"
                            src="{{ Vite::asset($faker['photos'][0]) }}"
                            alt="Midone Tailwind HTML Admin Template"
                        />
                        <div
                            class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-success dark:border-darkmode-600">
                        </div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a
                                class="mr-5 truncate font-medium"
                                href=""
                            >
                                {{ $faker['users'][0]['name'] }}
                            </a>
                            <div class="ml-auto whitespace-nowrap text-xs text-slate-400">
                                {{ $faker['times'][0] }}
                            </div>
                        </div>
                        <div class="mt-0.5 w-full truncate text-slate-500">
                            {{ $faker['news'][0]['short_content'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </x-base.popover.panel>
    </x-base.popover>-->
    <!-- END: Notifications  -->
    <!-- BEGIN: Account Menu -->
    <x-base.menu>
        <x-base.menu.button class="image-fit zoom-in intro-x block h-8 w-8 overflow-hidden rounded-full shadow-lg">
            <img
                src="{{ Vite::asset($faker['photos'][0]) }}"
                alt="Midone Tailwind HTML Admin Template"
            />
        </x-base.menu.button>
        <x-base.menu.items class="mt-px w-56 bg-primary text-white">
            <x-base.menu.header class="font-normal">
<!--                <div class="font-medium">{{ $fakers[0]['users'][0]['name'] }}</div>
                <div class="mt-0.5 text-xs text-white/70 dark:text-slate-500">
                    {{ $fakers[0]['jobs'][0] }}
                </div>-->

                    {{Auth::user()->name}}
            </x-base.menu.header>
            <x-base.menu.divider class="bg-white/[0.08]" />
<!--            <x-base.menu.item class="hover:bg-white/5">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="User"
                /> Profile
            </x-base.menu.item>
            <x-base.menu.item class="hover:bg-white/5">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="Edit"
                /> Add Account
            </x-base.menu.item>
            <x-base.menu.item class="hover:bg-white/5">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="Lock"
                /> Reset Password
            </x-base.menu.item>
            <x-base.menu.item class="hover:bg-white/5">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="HelpCircle"
                /> Help
            </x-base.menu.item>-->
            <!--<x-base.menu.divider class="bg-white/[0.08]" />-->
            <x-base.menu.item class="hover:bg-white/5" href="{{url('logout')}}">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="ToggleRight"
                /> Cerrar Sesión
            </x-base.menu.item>
        </x-base.menu.items>
    </x-base.menu>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->

@once
    @push('scripts')
        @vite('resources/js/components/top-bar/index.js')
    @endpush
@endonce
