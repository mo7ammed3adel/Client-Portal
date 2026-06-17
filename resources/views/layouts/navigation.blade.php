<nav x-data="{ open: false }" class="relative z-50 border-b border-slate-200 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <x-brand-mark class="h-9 w-9" />
                    <span class="font-black text-slate-950 dark:text-white">طلبة <span class="text-xs font-bold text-slate-400">· الإدارة</span></span>
                </a>

                @auth
                    <div class="hidden items-center gap-2 sm:flex">
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            لوحة التحكم
                        </x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            الطلبات
                        </x-nav-link>
                        <x-nav-link :href="route('admin.couriers.index')" :active="request()->routeIs('admin.couriers.*')">
                            المناديب
                        </x-nav-link>
                        <x-nav-link :href="route('admin.contacts.index')" :active="request()->routeIs('admin.contacts.*')">
                            رسائل التواصل
                        </x-nav-link>
                        <x-nav-link :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.*')">
                            الإعدادات
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <a href="{{ route('home') }}" target="_blank" class="text-sm font-semibold text-slate-500 hover:text-brand-600">عرض الموقع ↗</a>
                @auth
                    <span class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold uppercase text-slate-500 dark:border-slate-800 dark:text-slate-400">
                        مدير
                    </span>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900">
                                {{ Auth::user()->name }}
                                <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">الملف الشخصي</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    تسجيل الخروج
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-900 sm:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200 dark:border-slate-800 sm:hidden">
        @auth
            <div class="space-y-1 px-4 py-3">
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">لوحة التحكم</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">الطلبات</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.couriers.index')" :active="request()->routeIs('admin.couriers.*')">المناديب</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.contacts.index')" :active="request()->routeIs('admin.contacts.*')">رسائل التواصل</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.*')">الإعدادات</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('home')">عرض الموقع</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">الملف الشخصي</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">تسجيل الخروج</x-responsive-nav-link>
                </form>
            </div>
        @endauth
    </div>
</nav>
