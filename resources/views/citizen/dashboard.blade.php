<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/css/citizenDashboard.css'])

    <x-slot name="header">
        <div class="dashboard-header">
            <h1>مرحباً {{ auth()->user()->name }}</h1>
            <h2>لوحة التحكم الرئيسية</h2>
            <p>اختر الخدمة التي تريد الوصول إليها</p>
        </div>
    </x-slot>

    <div class="dashboard-content">
        <div class="container">
            @php
                $cards = [];
                $cards[] = [
                    'title' => 'خدماتي',
                    'icon' => 'fas fa-cogs',
                    'link' => route('citizen.requests.index'),
                    'color' => 'primary',
                    'description' => 'إدارة طلباتك وخدماتك الشخصية'
                ];
                $cards[] = [
                    'title' => 'الشكاوي',
                    'icon' => 'fas fa-exclamation-triangle',
                    'link' => route('citizen.complaints.index'),
                    'color' => 'warning',
                    'description' => 'تقديم ومتابعة الشكاوي والاقتراحات'
                ];

                foreach ($departments as $department) {
                    $cards[] = [
                        'title' => $department->name,
                        'icon' => 'fas fa-building',
                        'link' => route('citizen.getDepartmentServices', $department->id),
                        'color' => 'info',
                        'description' => 'استعراض خدمات ' . $department->name
                    ];
                }

                $trade = \App\Models\Trade::where('user_id', auth()->id())->first();
                if($trade) {
                    $cards[] = [
                        'title' => 'رخصة النشاط التجاري',
                        'icon' => 'fas fa-certificate',
                        'link' => route('citizen.trades.show', $trade->id),
                        'color' => 'success',
                        'description' => 'عرض تفاصيل ومعلومات رخصتك التجارية'
                    ];
                }
            @endphp

            <!-- إحصائيات سريعة -->
            <div class="stats-section mb-5">
                <div class="stat-card stat-primary">
                    <h4>{{ auth()->user()->requests()->count() }}</h4>
                    <p>إجمالي الطلبات</p>
                </div>
                <div class="stat-card stat-success">
                    <h4>{{ auth()->user()->requests()->where('status', 'مكتمل')->count() }}</h4>
                    <p>الطلبات المكتملة</p>
                </div>
                <div class="stat-card stat-warning">
                    <h4>{{ auth()->user()->requests()->where('status', 'بانتظار الموافقة')->count() }}</h4>
                    <p>قيد المعالجة</p>
                </div>
                <div class="stat-card stat-info">
                    <h4>{{ auth()->user()->complaints()->count() }}</h4>
                    <p>الشكاوي</p>
                </div>
            </div>

            <!-- عنوان الخدمات -->
            <div class="section-header text-center mb-4">
                <h3 class="section-title">الخدمات المتاحة</h3>
                <p class="section-subtitle">اختر الخدمة أو القسم الذي تريد الوصول إليه</p>
            </div>

            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($cards as $card)
                        <div class="swiper-slide">
                            <div class="service-card">
                                <div class="card-icon" style="background-color: {{ $card['color'] == 'primary' ? '#3b82f6' : ($card['color'] == 'success' ? '#10b981' : ($card['color'] == 'warning' ? '#f59e0b' : '#06b6d4')) }}">
                                    <i class="{{ $card['icon'] }}"></i>
                                </div>
                                <h5 class="card-title">{{ $card['title'] }}</h5>
                                <p class="card-description">{{ $card['description'] }}</p>
                                <a href="{{ $card['link'] }}" class="service-btn">عرض الخدمة</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <!-- روابط سريعة -->
            <div class="quick-links-section mt-5">
                <div class="quick-links-grid">
                    <a href="#" class="quick-link"><i class="fas fa-file-alt"></i><span>طلب جديد</span></a>
                    <a href="#" class="quick-link"><i class="fas fa-history"></i><span>السجل</span></a>
                    <a href="#" class="quick-link"><i class="fas fa-user-edit"></i><span>الملف الشخصي</span></a>
                    <a href="#" class="quick-link"><i class="fas fa-question-circle"></i><span>المساعدة</span></a>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        body { font-family: 'Segoe UI', sans-serif; background:#f4f6f8; margin:0; }

        .dashboard-header { background: var(--primary-color); padding:3rem 1rem; text-align:center; color:white; }
        .dashboard-header h1 { font-size:2.5rem; margin:0 0 0.5rem; }
        .dashboard-header h2 { font-size:1.5rem; font-weight:400; margin:0 0 1rem; }
        .dashboard-header p { margin:0; font-size:1rem; }

        .stats-section { display:flex; flex-wrap:wrap; gap:1rem; justify-content:center; margin-bottom:2rem; }
        .stat-card { background:white; border-radius:15px; padding:1.5rem; flex:1 1 200px; max-width:250px; text-align:center; box-shadow:var(--shadow); }
        .stat-card h4 { margin:0.5rem 0; font-size:2rem; color:var(--dark-color); }
        .stat-card p { margin:0; color:#6b7280; font-size:0.9rem; }
        .stat-primary { border-top:4px solid var(--primary-color); }
        .stat-success { border-top:4px solid var(--success-color); }
        .stat-warning { border-top:4px solid var(--warning-color); }
        .stat-info { border-top:4px solid var(--info-color); }

        .service-card { background:white; border-radius:15px; padding:1.5rem; text-align:center; box-shadow:var(--shadow); transition: transform 0.2s ease; }
        .service-card:hover { transform:translateY(-5px); }
        .card-icon { width:60px; height:60px; margin:0 auto 1rem; display:flex; align-items:center; justify-content:center; font-size:1.5rem; color:white; border-radius:50%; }
        .card-title { font-size:1.2rem; font-weight:600; margin-bottom:0.5rem; color:var(--dark-color); }
        .card-description { font-size:0.9rem; color:#6b7280; margin-bottom:1rem; }
        .service-btn { display:inline-block; padding:0.5rem 1.5rem; background:var(--primary-color); color:white; border-radius:25px; text-decoration:none; font-size:0.9rem; }
        .service-btn:hover { background:#2563eb; }

        .quick-links-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(120px,1fr)); gap:1rem; margin-top:2rem; }
        .quick-link { background:white; border-radius:10px; padding:1rem; text-align:center; text-decoration:none; color:var(--dark-color); box-shadow:var(--shadow); transition: transform 0.2s ease; }
        .quick-link:hover { transform:translateY(-3px); background:var(--primary-color); color:white; }
        .quick-link i { font-size:1.2rem; margin-bottom:0.3rem; }
        .quick-link span { display:block; font-size:0.85rem; }

        @media (max-width:768px) {
            .dashboard-header h1 { font-size:2rem; }
            .dashboard-header h2 { font-size:1.2rem; }
        }
    </style>

    <script>
        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 30 },
            },
        });
    </script>
</x-app-layout>
