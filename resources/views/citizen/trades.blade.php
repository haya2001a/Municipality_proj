<x-app-layout>
@vite(['resources/css/citizenTrades.css'])

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="license-card mb-4">
                    <div class="card-header-custom">
                        <h4 class="fw-bold mb-0 text-white d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            تفاصيل الرخصة
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="info-item highlight-item">
                                    <div class="info-icon">
                                        <i class="fas fa-store text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">اسم النشاط</label>
                                        <div class="info-value primary-text">{{ $trade->trade_name }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-store text-primary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">حالة الرخصة</label>
                                        <div class="info-value primary-text">{{ $trade->status }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- التواريخ -->
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-plus text-success"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">تاريخ فتح الرخصة</label>
                                        <div class="info-value">{{ $trade->opened_since }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-check text-info"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">تاريخ الإصدار</label>
                                        <div class="info-value">{{ $trade->issue_date }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-times text-warning"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">تاريخ الانتهاء</label>
                                        <div class="info-value">{{ $trade->expiry_date }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-calendar-day text-secondary"></i>
                                    </div>
                                    <div class="info-content">
                                        <label class="info-label">آخر دفعة</label>
                                        <div class="info-value">{{ $trade->last_payment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة المعلومات المالية -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="financial-card fees-card">
                            <div class="financial-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="financial-content">
                                <h6 class="financial-label">إجمالي الرسوم</h6>
                                <div class="financial-value">{{ number_format($trade->fees, 2) }}</div>
                                <small class="currency">دينار أردني</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="financial-card paid-card">
                            <div class="financial-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="financial-content">
                                <h6 class="financial-label">المبلغ المدفوع</h6>
                                <div class="financial-value">{{ number_format($trade->paid_fees, 2) }}</div>
                                <small class="currency">دينار أردني</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="financial-card remaining-card">
                            <div class="financial-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="financial-content">
                                <h6 class="financial-label">المتبقي</h6>
                                <div class="financial-value">{{ number_format($trade->fees - $trade->paid_fees, 2) }}
                                </div>
                                <small class="currency">دينار أردني</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.license-card, .financial-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add('fade-in');
            }, index * 200);
        });

        const financialCards = document.querySelectorAll('.financial-card');
        financialCards.forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-3px)';
                }, 150);
            });
        });
    });
</script>
