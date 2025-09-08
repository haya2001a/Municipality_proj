<x-app-layout>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/tabels.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="{{ Vite::asset('resources/js/shared.js') }}"></script>

    <div class="container mt-5 px-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">الرخص التجارية</h5>
            </div>

            <div class="card-body p-4">
                {{-- Filters --}}
                <form method="GET" action="{{ route('employee.trades.index') }}" id="filtersForm"
                    class="d-flex flex-wrap align-items-center gap-3 mb-4">

                    <div class="filter-group">
                        <label for="userFilter" class="fw-semibold mb-0">المستخدم:</label>
                        <input type="text" name="user_name" id="userFilter" class="form-control filter-input"
                            value="{{ request('user_name') }}" placeholder="بحث بالاسم">
                    </div>

                    <div class="filter-group">
                        <label for="statusFilter" class="fw-semibold mb-0">الحالة:</label>
                        <select name="status" id="statusFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach (['سارية', 'منتهية'] as $status)
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <script>
                    $('#statusFilter, #userFilter').on('change keyup', function() {
                        $('#filtersForm').submit();
                    });
                </script>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>اسم المستخدم</th>
                                <th>اسم الرخصة</th>
                                <th>منذ</th>
                                <th>تاريخ الإصدار</th>
                                <th>تاريخ الانتهاء</th>
                                <th>آخر دفعة</th>
                                <th>الحالة</th>
                                <th>الرسوم</th>
                                <th>المدفوع</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trades as $trade)
                                <tr class="align-middle">
                                    <td>{{ $trade->user->name }}</td>
                                    <td class="fw-semibold">{{ $trade->trade_name }}</td>
                                    <td>{{ $trade->opened_since->format('Y/m/d') }}</td>
                                    <td>{{ $trade->issue_date->format('Y/m/d') }}</td>
                                    <td>{{ $trade->expiry_date ? $trade->expiry_date->format('Y/m/d') : '-' }}</td>
                                    <td>{{ $trade->last_payment->format('Y/m/d') }}</td>


                                    <td class="status-column">
                                        <span class="badge" data-status="{{ $trade->status }}">
                                            {{ $trade->status }}
                                        </span>

                                    </td>
                                    <td>{{ number_format($trade->fees, 2) }} د.أ</td>
                                    <td>{{ number_format($trade->paid_fees, 2) }} د.أ</td>
                                    <td>
                                        <button class="btn btn-sm btn-gradient" data-bs-toggle="modal"
                                            data-bs-target="#tradeModal" data-id="{{ $trade->id }}"
                                            data-status="{{ $trade->status }}" data-paid="{{ $trade->paid_fees }}">
                                            <i class="fas fa-edit"></i> تعديل
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">{{ $trades->links() }}</div>
            </div>
        </div>
    </div>

 
@include('employee.updateTradeModal')

</x-app-layout>

<script>
    $('#tradeModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var status = button.data('status');
        var paid = button.data('paid');

        var form = $('#tradeForm');
        form.attr('action', '/employee/trades/' + id);

        $('#tradeStatus').val(status);;
    });
</script>
