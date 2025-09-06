<x-app-layout>
    @include('deleteItem')

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/tabels.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ Vite::asset('resources/js/shared.js') }}"></script>

    <div class="container mt-5 px-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded shadow-sm d-flex align-items-center"
                role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">إدارة الطلبات</h5>
            </div>

            <div class="card-body p-4">
           
<div class="mb-4">
    <form method="GET" action="{{ route('admin.requests.index') }}" id="filtersForm"
        class="d-flex flex-wrap align-items-center gap-3 mb-0">

        <!-- User Filter -->
        <div class="d-flex align-items-center gap-2">
            <label for="userFilter" class="fw-semibold mb-0">اسم المستخدم:</label>
            <input type="text" name="user" id="userFilter"
                class="form-control form-control-sm rounded-pill"
                placeholder="ابحث بالاسم" value="{{ request('user') }}">
        </div>

        <div class="d-flex align-items-center gap-2">
            <label for="serviceFilter" class="fw-semibold mb-0">الخدمة:</label>
            <select name="service" id="serviceFilter" class="form-select form-select-sm rounded-pill">
                <option value="">الكل</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex align-items-center gap-2">
            <label for="statusFilter" class="fw-semibold mb-0">الحالة:</label>
            <select name="status" id="statusFilter" class="form-select form-select-sm rounded-pill">
                <option value="">الكل</option>
                @foreach (['بانتظار الموافقة', 'مرفوض', 'مكتمل', 'مدفوع'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex align-items-center gap-2">
            <label for="priorityFilter" class="fw-semibold mb-0">الأولوية:</label>
            <select name="priority" id="priorityFilter" class="form-select form-select-sm rounded-pill">
                <option value="">الكل</option>
                @foreach (['غير عاجل', 'متوسط', 'عاجل'] as $priority)
                    <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                        {{ $priority }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>المستخدم</th>
                                <th>الخدمة</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>السعر</th>
                                <th>تاريخ الإنشاء</th>
                                <th class="text-center">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->service->name }}</td>
                                    <td>{{ $request->status }}</td>
                                    <td>{{ $request->priority }}</td>
                                    <td>{{ $request->price ?? '-' }}</td>
                                    <td>{{ $request->created_at->format('Y/m/d') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-modern assignRequestBtn"
                                            data-id="{{ $request->id }}" title="إسناد الطلب">
                                            <i class="fas fa-user-check me-1"></i> إسناد
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>

    @include('admin.assignRequestModal');

    <script>
        $(function() {
            // submit filters automatically
            $('#userFilter, #serviceFilter, #statusFilter, #priorityFilter').on('change keyup', function() {
                $('#filtersForm').submit();
            });

            // assign request
            $('.assignRequestBtn').on('click', function() {
                var requestId = $(this).data('id');
                $.get('/admin/requests/' + requestId + '/employees', function(data) {
                    var $select = $('#assigned_to');
                    $select.empty();
                    if (data.length > 0) {
                        $.each(data, function(i, employee) {
                            $select.append('<option value="' + employee.id + '">' + employee.name + '</option>');
                        });
                    } else {
                        $select.append('<option value="">لا يوجد موظفين في هذه الدائرة</option>');
                    }
                    $('#assignRequestForm').attr('action', '/admin/requests/' + requestId + '/assign');
                    $('#assignRequestModal').modal('show');
                });
            });
        });
    </script>

    <style>
        .btn-modern {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: #fff;
            border: none;
        }
        .btn-modern:hover {
            opacity: 0.9;
        }
        .form-select.rounded-pill, .form-control.rounded-pill {
            border-radius: 50px !important;
        }
    </style>
</x-app-layout>
