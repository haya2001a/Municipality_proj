<x-app-layout>
    <div class="container mt-5 px-4">
        <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">الإشعارات</h2>

            <div class="bg-white shadow rounded-xl divide-y divide-gray-200 overflow-hidden">
                @forelse ($notifications as $notification)
                    <div
                        class="px-4 py-4 hover:bg-gray-50 transition flex items-start justify-between space-x-4 rtl:space-x-reverse">

                        <!-- Icon حسب نوع الإشعار -->
                        <div class="flex-shrink-0">
                            <span
                                class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </span>
                        </div>

                        <!-- محتوى الإشعار -->
                        <div class="flex-1 min-w-0">
                            <p class="text-gray-800 font-medium">{{ $notification->data['message'] ?? 'بدون رسالة' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>

                        <!-- علامة جديد -->
                        @if (!$notification->read())
                            <div class="flex-shrink-0 self-center">
                                <span
                                    class="bg-blue-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">جديد</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-4 py-6 text-center text-gray-500 text-sm">
                        لا توجد إشعارات
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
