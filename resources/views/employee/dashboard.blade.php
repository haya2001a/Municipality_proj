<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/css/employeeDashboard.css'])
    <x-slot name="header">
        <div class="dashboard-header">
            <h1>مرحباً {{ auth()->user()->name }}</h1>
            <h2>لوحة تحكم الموظف</h2>
            <p>اختر القسم أو الخدمة لمتابعتها</p>
        </div>
    </x-slot>

    <div class="dashboard-content">
        <div class="container">
            @php
                $cards = [];

                $cards[] = [
                    'title' => 'طلبات خدمات المواطنين',
                    'icon' => 'fas fa-tasks',
                    'link' => route('employee.requests.index'),
                    'color' => 'primary',
                    'description' => 'عرض وإدارة طلبات المواطنين',
                ];

                $cards[] = [
                    'title' => 'شكاوي المواطنين',
                    'icon' => 'fas fa-comments',
                    'link' => route('employee.complaints.index'),
                    'color' => 'warning',
                    'description' => 'متابعة الشكاوي والاقتراحات',
                ];

                $cards[] = [
                    'title' => 'رخص الأنشطة التجارية',
                    'icon' => 'fas fa-certificate',
                    'link' => route('employee.trades.index'),
                    'color' => 'success',
                    'description' => 'عرض وإدارة جميع رخص المواطنين',
                ];
            @endphp

            <div class="stats-section mb-5">
                <div class="stat-card stat-primary">
                    <h4>{{ \App\Models\ServiceRequest::where('department_id', auth()->user()->department_id)->count() }}
                    </h4>
                    <p>إجمالي الطلبات</p>
                </div>
                <div class="stat-card stat-success">
                    <h4>{{ \App\Models\ServiceRequest::where('department_id', auth()->user()->department_id)->where('status', 'مكتمل')->count() }}
                    </h4>
                    <p>الطلبات المكتملة</p>
                </div>
                <div class="stat-card stat-warning">
                    <h4>{{ \App\Models\ServiceRequest::where('department_id', auth()->user()->department_id)->where('status', 'بانتظار الموافقة')->count() }}
                    </h4>
                    <p>قيد المعالجة</p>
                </div>
                <div class="stat-card stat-info">
                    <h4>{{ \App\Models\Complaint::count() }}</h4>
                    <p>الشكاوي</p>
                </div>
            </div>
            <div class="section-header text-center mb-4">
                <h3 class="section-title">الأقسام والخدمات</h3>
                <p class="section-subtitle">يمكنك متابعة الطلبات والشكاوي حسب القسم</p>
            </div>

            <!-- Swiper Container -->
            <div class="slider-container">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($cards as $card)
                            <div class="swiper-slide">
                                <div class="service-card">
                                    <div class="card-icon"
                                        style="background-color: {{ $card['color'] == 'primary' ? '#3b82f6' : ($card['color'] == 'success' ? '#10b981' : ($card['color'] == 'warning' ? '#f59e0b' : '#06b6d4')) }}">
                                        <i class="{{ $card['icon'] }}"></i>
                                    </div>
                                    <h5 class="card-title">{{ $card['title'] }}</h5>
                                    <p class="card-description">{{ $card['description'] }}</p>
                                    <a href="{{ $card['link'] }}" class="service-btn">عرض</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-button-next">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="fas fa-chevron-left"></i>
                    </div>

                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                640: {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                    centeredSlides: true,
                },
                768: {
                    slidesPerView: 1.5,
                    spaceBetween: 30,
                    centeredSlides: true,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                    centeredSlides: false,
                },
            },
        });
    </script>
</x-app-layout>
