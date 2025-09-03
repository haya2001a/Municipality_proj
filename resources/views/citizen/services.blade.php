<x-app-layout>
@vite(['resources/css/citizenServices.css'])

    <x-slot name="header">
        <div class="text-center py-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                 {{ __('خدمات قسم: ' . $department->name) }}
            </h2>
            <p class="text-gray-600">اختر الخدمة التي تريد تقديم طلب لها</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <div class="relative max-w-md mx-auto">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       id="serviceSearch" 
                       class="block w-full pr-10 pl-4 py-3 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right"
                       placeholder=" ابحث عن خدمة..."
                       dir="rtl">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="servicesList">
            @foreach ($department->services as $service)
                <div class="service-card group">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 h-full flex flex-col">
                        
                        <div class="p-6 flex-grow">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $service->name }}</h3>
                            </div>

                            <p class="text-gray-600 text-sm mb-6 leading-relaxed">{{ $service->description }}</p>


                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">💰 السعر:</span>
                                    <span class="px-2 py-1  text-gray-500 text-xs font-medium rounded-full">{{ $service->price }} شيكل</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">⏳ مدة المعالجة:</span>
                                    <span class="px-2 py-1  text-gray-500 text-xs font-medium rounded-full">{{ $service->processing_time }} يوم</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">⭐ الأولوية:</span>
                                    <span class="px-2 py-1  text-gray-500 text-xs font-medium rounded-full">{{ $service->priority }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">📌 الحالة:</span>
                                    <span class="px-2 py-1  text-gray-500 text-xs font-medium rounded-full">{{ $service->status }}</span>
                                </div>
                            </div>

                            
                            @if($service->notes)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                    <div class="flex items-start">
                                        <p class="text-sm text-blue-800 leading-relaxed">{{ $service->notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <div class="p-6 pt-0">
                            <button class="request-btn w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    data-id="{{ $service->id }}"
                                    data-name="{{ $service->name }}"
                                    data-documents="{{ $service->required_documents }}">
                                <span class="flex items-center justify-center .btn-modern">
                                    طلب الخدمة
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

   
        <div id="noResults" class="hidden text-center py-12">
            <h3 class="text-xl font-medium text-gray-900 mb-2">لم يتم العثور على خدمات</h3>
            <p class="text-gray-500">جرب البحث بكلمات أخرى</p>
        </div>

    </div>

    @include('citizen.addRequestModal')

    <style>
        /* تحسينات بسيطة للانيميشن */
        .service-card {
            transition: transform 0.2s ease;
        }
        
        .service-card:hover {
            transform: translateY(-2px);
        }
        
        .request-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* تحسين شريط البحث */
        #serviceSearch:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>

    <script>
        // تحسين وظيفة البحث
        document.getElementById('serviceSearch').addEventListener('keyup', function() {
            const value = this.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.service-card');
            const noResults = document.getElementById('noResults');
            let visibleCards = 0;

            cards.forEach(card => {
                const isVisible = card.innerText.toLowerCase().includes(value);
                card.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCards++;
            });

            // عرض رسالة عدم وجود نتائج
            if (visibleCards === 0 && value !== '') {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        });

        // إضافة تأثير تحميل بسيط للأزرار
        document.querySelectorAll('.request-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="flex items-center justify-center"><span class="animate-spin ml-2">⏳</span>جاري المعالجة...</span>';
                this.disabled = true;
                
                // استعادة النص الأصلي بعد ثانيتين (يمكن تعديل هذا حسب الحاجة)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            });
        });
    </script>
</x-app-layout>