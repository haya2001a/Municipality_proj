<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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

            <!-- إحصائيات سريعة -->
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

            <!-- عنوان الخدمات -->
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

                    <!-- أسهم التنقل المحسنة -->
                    <div class="swiper-button-next">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="fas fa-chevron-left"></i>
                    </div>

                    <!-- النقاط -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- روابط سريعة -->
            <div class="quick-links-section mt-5">
                <div class="quick-links-grid">
                    <a href="{{ route('employee.requests.index') }}" class="quick-link"><i
                            class="fas fa-file-alt"></i><span>كل الطلبات</span></a>
                    <a href="{{ route('employee.complaints.index') }}" class="quick-link"><i
                            class="fas fa-exclamation-circle"></i><span>كل الشكاوي</span></a>
                    <a href="#" class="quick-link"><i class="fas fa-user-cog"></i><span>إدارة الموظفين</span></a>
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
            --shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
        }

        .dashboard-header {
            background: var(--primary-color);
            padding: 3rem 1rem;
            text-align: center;
            color: white;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            margin: 0 0 0.5rem;
        }

        .dashboard-header h2 {
            font-size: 1.5rem;
            font-weight: 400;
            margin: 0 0 1rem;
        }

        .dashboard-header p {
            margin: 0;
            font-size: 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .stats-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            flex: 1 1 200px;
            max-width: 250px;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .stat-card h4 {
            margin: 0.5rem 0;
            font-size: 2rem;
            color: var(--dark-color);
        }

        .stat-card p {
            margin: 0;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .stat-primary {
            border-top: 4px solid var(--primary-color);
        }

        .stat-success {
            border-top: 4px solid var(--success-color);
        }

        .stat-warning {
            border-top: 4px solid var(--warning-color);
        }

        .stat-info {
            border-top: 4px solid var(--info-color);
        }

        .section-header {
            margin: 2rem 0;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            color: #6b7280;
            margin: 0;
        }

        /* تحسين السلايدر */
        .slider-container {
            position: relative;
            margin: 2rem 0;
            padding: 0 60px;
            /* مساحة للأسهم */
        }

        .mySwiper {
            padding: 20px 0 60px;
            overflow: hidden;
        }

        .service-card {
            background: white;
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 320px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
            line-height: 1.4;
        }

        .card-description {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.5;
            flex-grow: 1;
        }

        .service-btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            background: var(--primary-color);
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .service-btn:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .quick-link {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            text-decoration: none;
            color: var(--dark-color);
            box-shadow: var(--shadow);
            transition: transform 0.2s ease;
        }

        .quick-link:hover {
            transform: translateY(-3px);
            background: var(--primary-color);
            color: white;
        }

        .quick-link i {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
        }

        .quick-link span {
            display: block;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 2rem;
            }

            .dashboard-header h2 {
                font-size: 1.2rem;
            }

            .slider-container {
                padding: 0 20px;
            }

            .service-card {
                height: auto;
                min-height: 300px;
            }
        }

        @media (max-width: 640px) {
            .slider-container {
                padding: 0;
            }
        }
    </style>

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
