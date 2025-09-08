<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" dir="rtl" lang="ar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="شعار التطبيق"
                            class="block h-9 w-auto fill-current">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    @php $user = Auth::user(); @endphp

                    @if ($user->hasRole('admin'))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">{{ __('لوحة التحكم') }}</x-nav-link>
                    @elseif ($user->hasRole('employee'))
                        <x-nav-link :href="route('employee.dashboard')" :active="request()->routeIs('employee.dashboard')">{{ __('لوحة التحكم') }}</x-nav-link>
                    @else
                        <x-nav-link :href="route('citizen.dashboard')" :active="request()->routeIs('citizen.dashboard')">{{ __('لوحة التحكم') }}</x-nav-link>
                    @endif

                    <!-- Notifications Dropdown -->
                    @if ($user->hasRole('citizen'))
  <div x-data="notifications()" class="relative">
                        <button @click="openNotifications = !openNotifications; if(openNotifications) markAllAsRead()"
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700 rounded-full focus:outline-none transition duration-200">
                            <!-- Bell Icon -->
                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>

                            <!-- Badge -->
                            <span x-show="unreadCount > 0" x-text="unreadCount"
                                class="absolute top-0 right-0 -translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5"></span>
                        </button>

                        <div x-show="openNotifications" x-cloak @click.away="openNotifications = false"
                            class="absolute mt-2 w-80 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 right-0 transition ease-out duration-200">

                            <!-- Header -->
                            <div class="px-4 py-2 border-b border-gray-200 text-gray-800 font-semibold text-sm">
                                الإشعارات
                            </div>

                            <!-- Notifications -->
                            <div class="max-h-96 overflow-y-auto divide-y divide-gray-200">
                                <template x-for="notification in notifications" :key="notification.id">
                                    <div
                                        class="px-4 py-3 hover:bg-gray-50 cursor-pointer transition flex justify-between items-center">
                                        <p class="text-sm text-gray-700" x-text="notification.message"></p>
                                        <span x-show="!notification.read"
                                            class="bg-blue-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">جديد</span>
                                    </div>
                                </template>
                                <template x-if="notifications.length === 0">
                                    <div class="px-4 py-3 text-sm text-gray-500">لا توجد إشعارات جديدة</div>
                                </template>
                            </div>

                            <!-- Footer -->
                            <div class="px-4 py-2 border-t border-gray-200 text-center">
                                <a href="{{ route('notifications.all') }}"
                                    class="text-blue-600 hover:underline text-sm font-medium">عرض كل الإشعارات</a>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="mr-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('الملف الشخصي') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('تسجيل الخروج') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger for mobile -->
            <div class="-ms-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Alpine + Echo -->
  <script>
    function notifications() {
        return {
            notifications: @json(auth()->user()->notifications->map(fn($n) => [
                'id' => $n->id,
                'message' => $n->data['message'] ?? 'بدون رسالة',
                'read' => $n->read_at !== null
            ])->toArray()),
            unreadCount: {{ auth()->user()->unreadNotifications->count() }},
            openNotifications: false,

            init() {
                Echo.private(`App.Models.User.{{ auth()->id() }}`)
                    .notification((notification) => {
                        this.notifications.unshift({
                            id: notification.id,
                            message: notification.data.message ?? 'بدون رسالة',
                            read: false
                        });
                        this.unreadCount++;
                    });
            },

            markAllAsRead() {
                this.unreadCount = 0;
                this.notifications.forEach(notification => {
                    if (!notification.read) {
                        notification.read = true;
                        axios.post(`/notifications/${notification.id}/read`);
                    }
                });
            }
        }
    }
</script>
</nav>
