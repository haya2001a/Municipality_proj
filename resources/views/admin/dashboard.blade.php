<x-app-layout>
    <x-slot name="header">
        
    </x-slot>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الإدارة</title>
    <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/adminDashboard.css'])

</head>

<body>
    <div class="dashboard-header">
        <h1>مرحباً {{ auth()->user()->name }}</h1>
        <h2>لوحة التحكم الإدارية</h2>
        <p>إدارة النظام والخدمات والمستخدمين</p>
    </div>

    <div class="dashboard-content">
        <div class="container">
            <!-- إحصائيات سريعة -->
            <div class="stats-section mb-5">
                <div class="stat-card stat-primary">
                    <h4>{{ \App\Models\User::count() }}</h4>
                    <p>إجمالي المستخدمين</p>
                </div>
                <div class="stat-card stat-success">
                    <h4>{{ \App\Models\ServiceRequest::where('status', 'بانتظار الموافقة')->count() }}</h4>
                    <p>الطلبات المعلقة</p>
                </div>
               
                <div class="stat-card stat-info">
                    <h4>{{ \App\Models\Service::where('status', 'فعّالة')->count() }}</h4>
                    <p>الخدمات النشطة</p>
                </div>
            </div>

            <!-- عنوان الخدمات -->
            <div class="section-header text-center mb-4">
                <h3 class="section-title">أدوات الإدارة</h3>
                <p class="section-subtitle">اختر القسم أو الأداة التي تريد إدارتها</p>
            </div>

            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="{{ route('admin.users.index') }}" class="service-card block no-underline"
                            style="text-decoration: none; color: inherit;">
                            <div class="card-icon" style="background-color: #3b82f6">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title">إدارة المستخدمين</h5>
                            <p class="card-description">إضافة وتعديل وحذف المستخدمين والموظفين</p>
                            <span class="service-btn">إدارة المستخدمين</span>
                        </a>

                    </div>

                    <div class="swiper-slide">
                        <a href="{{ route('admin.services.index') }}" class="service-card block no-underline"
                            style="text-decoration: none; color: inherit;">
                            <div class="card-icon" style="background-color: #10b981">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <h5 class="card-title">إدارة الخدمات</h5>
                            <p class="card-description">إضافة وتحديث الخدمات المتاحة للمواطنين</p>
                            <span class="service-btn">إدارة الخدمات</span>
                        </a>

                    </div>

                    <div class="swiper-slide">
                        <a href="{{ route('admin.requests.index') }}" class="service-card block no-underline"
                            style="text-decoration: none; color: inherit;">
                            <div class="card-icon" style="background-color: #f59e0b">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5 class="card-title">إدارة الطلبات</h5>
                            <p class="card-description">متابعة ومعالجة طلبات المواطنين</p>
                            <span class="service-btn">إدارة الطلبات</span>
                        </a>

                    </div>

                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

           

        <!-- الرسوم البيانية -->
                <div class="advanced-stats mt-5">
                    <div class="row">
                        <!-- الطلبات الشهرية -->
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h6 class="chart-title">إحصائيات الطلبات الشهرية</h6>
                                <canvas id="monthlyRequestsChart"></canvas>
                            </div>
                        </div>
                        <!-- توزيع الخدمات -->
                        <div class="col-md-6">
                            <div class="chart-card">
                                <h6 class="chart-title">توزيع الخدمات الأكثر طلباً</h6>
                                <canvas id="serviceDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script>
           var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: false,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {        // من 0px - موبايل
                slidesPerView: 1
            },
            768: {      // من 768px - تابلت
                slidesPerView: 2
            },
            1024: {     // من 1024px وأعلى - ديسكتوب
                slidesPerView: 3
            }
        }
    });
       const monthlyRequests = @json($monthlyRequests);
            const serviceDistribution = @json($serviceDistribution);

            // ---- الطلبات الشهرية ----
            const ctx1 = document.getElementById('monthlyRequestsChart').getContext('2d');
            const months = ['يناير','فبراير','مارس','أبريل','مايو','يونيو',
                            'يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'];
            const monthlyRequestsData = Array(12).fill(0);
            for (const [month, count] of Object.entries(monthlyRequests)) {
                monthlyRequestsData[month - 1] = count;
            }
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'عدد الطلبات',
                        data: monthlyRequestsData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });

            // ---- توزيع الخدمات ----
            const ctx2 = document.getElementById('serviceDistributionChart').getContext('2d');
            const serviceLabels = serviceDistribution.map(item => item.name);
            const serviceCounts = serviceDistribution.map(item => item.count);

            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: serviceLabels,
                    datasets: [{
                        data: serviceCounts,
                        backgroundColor: [
                            '#3b82f6','#10b981','#f59e0b','#ef4444',
                            '#8b5cf6','#ec4899','#14b8a6','#f97316'
                        ]
                    }]
                },
                options: { responsive: true }
            });
    </script>
</body>

</html>
    
</x-app-layout>
