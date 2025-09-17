<x-app-layout>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/css/dashboard.css'])
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
                    'title' => 'طلباتي',
                    'icon' => 'fas fa-cogs',
                    'link' => route('citizen.requests.index'),
                    'color' => 'primary',
                    'description' => 'إدارة طلباتك وخدماتك الشخصية',
                ];
                $cards[] = [
                    'title' => 'الشكاوي',
                    'icon' => 'fas fa-exclamation-triangle',
                    'link' => route('citizen.complaints.index'),
                    'color' => 'warning',
                    'description' => 'تقديم ومتابعة الشكاوي والاقتراحات',
                ];

                foreach ($departments as $department) {
                    $cards[] = [
                        'title' => $department->name,
                        'icon' => 'fas fa-building',
                        'link' => route('citizen.getDepartmentServices', $department->id),
                        'color' => 'info',
                        'description' => 'استعراض خدمات ' . $department->name,
                    ];
                }

                $trade = \App\Models\Trade::where('user_id', auth()->id())->first();
                if ($trade) {
                    $cards[] = [
                        'title' => 'رخصة النشاط التجاري',
                        'icon' => 'fas fa-certificate',
                        'link' => route('citizen.trades.show', $trade->id),
                        'color' => 'success',
                        'description' => 'عرض تفاصيل ومعلومات رخصتك التجارية',
                    ];
                }
            @endphp

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
                <div class="stat-card stat-warning">
                    <h4>{{ auth()->user()->requests()->where('status', 'مكتمل')->orWhere('status', 'مدفوع')->sum('price') }}
                    </h4>
                    <p>المبلغ المطلوب</p>
                </div>
                <div class="stat-card stat-success">
                    <h4>{{ auth()->user()->requests()->where('status', 'مكتمل')->sum('price') }}</h4>
                    <p>
                    <p>المبلغ المدفوع</p>
                </div>
            </div>

            <div class="section-header text-center mb-4">
                <h3 class="section-title">الخدمات المتاحة</h3>
                <p class="section-subtitle">اختر الخدمة أو القسم الذي تريد الوصول إليه</p>
            </div>

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
                                <a href="{{ $card['link'] }}" class="service-btn">عرض الخدمة</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div id="gemini-chatbot"
                style="position:fixed; bottom:20px; right:20px; z-index:9999; font-family:sans-serif;">
                <div id="chat-header"
                    style="background: var(--primary-color); color: white;border-radius: 50%; 
                width: 60px; height: 60px; display: flex; align-items: center; 
                justify-content: center; font-size: 1.5rem; cursor: pointer;
                box-shadow: var(--shadow);">
                    💬
                </div>
                <div id="chat-body"
                    style="display:none; margin-top:10px; width:350px; max-width:90%; background:white; 
                border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.2); 
                flex-direction:column; overflow:hidden; max-height:400px;">

                    <div id="messages" style="flex:1; overflow-y:auto; margin:10px;"></div>

                    <div style="display:flex; gap:5px; padding:10px;">
                        <input type="text" id="chat-input" placeholder="اكتب رسالتك..."
                            style="flex:1; padding:8px; border-radius:10px; border:1px solid #ccc;">
                        <button id="chat-send"
                            style="padding:8px 12px; border:none; background:#3b82f6; 
                           color:white; border-radius:10px; cursor:pointer;">
                            إرسال
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const chatHeader = document.getElementById('chat-header');
        const chatBody = document.getElementById('chat-body');
        const messagesContainer = document.getElementById('messages');
        const chatInput = document.getElementById('chat-input');
        const chatSend = document.getElementById('chat-send');

        chatHeader.addEventListener('click', () => {
            chatBody.style.display = chatBody.style.display === 'flex' ? 'none' : 'flex';
        });

        chatSend.addEventListener('click', () => {
            sendMessage(chatInput.value);
        });

        chatInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendMessage(chatInput.value);
        });

        function addMessage(text, fromUser = true) {
            const msg = document.createElement('div');
            msg.style.marginBottom = '8px';
            msg.style.textAlign = fromUser ? 'right' : 'left';
            msg.innerHTML =
                `<span style="display:inline-block; padding:8px 12px; border-radius:15px; background:${fromUser ? '#3b82f6' : '#e5e7eb'}; color:${fromUser ? 'white' : 'black'};">${text}</span>`;
            messagesContainer.appendChild(msg);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        async function sendMessage(text) {
            if (!text) return;
            addMessage(text, true);
            chatInput.value = '';

            try {
                const response = await fetch('/citizen/gemini-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: text
                    })
                });
                const data = await response.json();
                addMessage(data.reply, false);
            } catch (err) {
                addMessage('حدث خطأ أثناء التواصل مع البوت.', false);
            }
        }

        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30
                },
            },
        });
    </script>

</x-app-layout>
