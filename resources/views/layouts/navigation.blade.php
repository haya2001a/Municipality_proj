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
                @php $user = Auth::user(); @endphp

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">

                    <!-- Notifications Dropdown -->
                    @if ($user->hasRole('citizen'))
                        <div div x-data="notifications()" class="relative">
                            <button
                                @click="openNotifications = !openNotifications; if(openNotifications) markAllAsRead()"
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white hover:text-gray-700 rounded-full focus:outline-none transition duration-200">
                                <!-- Bell Icon -->
                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-white hover:text-gray-900 hover:bg-gray-50 rounded-lg transition duration-200 ease-in-out">
                            <span>الأقسام</span>
                            <svg class="mr-2 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-64 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">

                            <!-- لوحة التحكم -->
                            <div class="py-2">
                                @if ($user->hasRole('admin'))
                                    <div>
                                        <div
                                            class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-b border-gray-100">
                                            لوحة الإدارة
                                        </div>
                                        <a href="/admin/dashboard"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z">
                                                </path>
                                            </svg>
                                            لوحة التحكم الرئيسية
                                        </a>
                                        <a href="/admin/users"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                </path>
                                            </svg>
                                            إدارة المستخدمين
                                        </a>
                                        <a href="/admin/services"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            إدارة الخدمات
                                        </a>
                                        <a href="/admin/requests"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            إدارة الطلبات
                                        </a>
                                    </div>
                                @endif

                                @if ($user->hasRole('employee'))
                                    <div>
                                        <div
                                            class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-b border-gray-100">
                                            لوحة الموظف
                                        </div>
                                        <a href="/employee/dashboard"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z">
                                                </path>
                                            </svg>
                                            لوحة التحكم
                                        </a>
                                        <a href="/employee/requests"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                            طلبات خدمات المواطنين
                                        </a>
                                        <a href="/employee/complaints"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                </path>
                                            </svg>
                                            شكاوي المواطنين
                                        </a>
                                        <a href="/employee/trades"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                                </path>
                                            </svg>
                                            رخص الأنشطة التجارية
                                        </a>
                                    </div>
                                @endif

                                @if ($user->hasRole('citizen'))
                                    <div>
                                        <div
                                            class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-b border-gray-100">
                                            خدماتي
                                        </div>
                                        <a href="/citizen/dashboard"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z">
                                                </path>
                                            </svg>
                                            لوحة التحكم
                                        </a>
                                        <a href="/citizen/requests"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            طلباتي
                                        </a>
                                        <a href="/citizen/complaints"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition duration-150">
                                            <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                            الشكاوي
                                        </a>
                                        <div
                                            class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide border-t border-b border-gray-100 mt-2">
                                            أقسام الخدمات
                                        </div>
                                        @php
                                            $departments = App\Models\Department::select('id', 'name', 'description')
                                                ->orderBy('name')
                                                ->get();
                                        @endphp


                                        @foreach ($departments as $department)
                                            <a href="/citizen/getDepartmentServices/{{ $department->id }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition duration-150">
                                                <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                                {{ $department->name }}
                                            </a>
                                        @endforeach

                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="mr-1">
                            <svg class="fill-current h-4 w-4 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute left-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-2">
                            <a href="/profile"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition duration-150">
                                <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                الملف الشخصي
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-150">
                                    <svg class="ml-3 h-4 w-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    تسجيل الخروج
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="-ms-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150">
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

    <!-- Mobile Menu -->
    <div x-show="open" x-cloak class="sm:hidden border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-50">
            @if ($user->hasRole('admin'))
                <div>
                    <div
                        class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wide border-b border-gray-200 bg-blue-50 mb-2">
                        لوحة الإدارة
                    </div>
                    <a href="/admin/dashboard"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-blue-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                        لوحة التحكم الرئيسية
                    </a>
                    <a href="/admin/users"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-blue-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                        إدارة المستخدمين
                    </a>
                    <a href="/admin/services"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-blue-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        إدارة الخدمات
                    </a>
                    <a href="/admin/requests"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-blue-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        إدارة الطلبات
                    </a>
                </div>
            @endif

            @if ($user->hasRole('employee'))
                <div>
                    <div
                        class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wide border-b border-gray-200 bg-green-50 mb-2">
                        لوحة الموظف
                    </div>
                    <a href="/employee/dashboard"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-green-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                        لوحة التحكم
                    </a>
                    <a href="/employee/requests"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-green-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        طلبات خدمات المواطنين
                    </a>
                    <a href="/employee/complaints"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-green-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        شكاوي المواطنين
                    </a>
                    <a href="/employee/trades"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-green-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                        رخص الأنشطة التجارية
                    </a>
                </div>
            @endif

            @if ($user->hasRole('citizen'))
                <div>
                    <div
                        class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wide border-b border-gray-200 bg-purple-50 mb-2">
                        خدماتي
                    </div>
                    <a href="/citizen/dashboard"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-purple-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                        لوحة التحكم
                    </a>
                    <a href="/citizen/requests"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-purple-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        خدماتي
                    </a>
                    <a href="/citizen/complaints"
                        class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-purple-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        الشكاوي
                    </a>
                    @foreach ($departments as $department)
                        <a href="/citizen/getDepartmentServices/{{ $department->id }}"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-purple-50 rounded-md">
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            {{ $department->name }}
                        </a>
                    @endforeach

                </div>
            @endif

            <div class="border-t border-gray-200 mt-4 pt-4">
                <div
                    class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wide border-b border-gray-200 bg-gray-100 mb-2">
                    الحساب الشخصي
                </div>
                <a href="/profile"
                    class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md">
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    الملف الشخصي
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-3 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md">
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>

</nav>
<div id="notifications-data"
    data-notifications="{{ json_encode(
        auth()->user()->notifications->map(
                fn($n) => [
                    'id' => $n->id,
                    'message' => $n->data['message'] ?? 'بدون رسالة',
                    'read' => $n->read_at !== null,
                ],
            )->toArray(),
    ) }}"
    data-unread-count="{{ auth()->user()->unreadNotifications->count() }}" data-user-id="{{ auth()->id() }}"
    style="display: none;">
</div>

<script>
    function notifications() {
        const data = document.getElementById('notifications-data');
        return {
            notifications: JSON.parse(data.dataset.notifications || '[]'),
            unreadCount: parseInt(data.dataset.unreadCount || '0'),
            openNotifications: false,
            init() {
                const userId = data.dataset.userId;
                Echo.private(`App.Models.User.${userId}`)
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
                        axios.post(`/notifications/${notification.id}/read`)
                            .catch(error => {
                                console.error('خطأ في تحديث الإشعار:', error);
                                notification.read = false;
                            });
                    }
                });
            }
        }
    }
</script>
