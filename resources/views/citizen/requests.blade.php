<x-app-layout>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/tabels.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
                <h5 class="mb-0 fw-bold">الطلبات الخاصة بي</h5>
            </div>

            <div class="card-body p-4">
                {{-- Filters --}}
                <form method="GET" action="{{ route('citizen.requests.index') }}" id="filtersForm"
                    class="d-flex flex-wrap align-items-center gap-3 mb-4">

                    <div class="filter-group">
                        <label for="serviceFilter" class="fw-semibold mb-0">الخدمة:</label>
                        <select name="service" id="serviceFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="statusFilter" class="fw-semibold mb-0">الحالة:</label>
                        <select name="status" id="statusFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach (['بانتظار الموافقة', 'مرفوض', 'مكتمل', 'مدفوع'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="priorityFilter" class="fw-semibold mb-0">الأولوية:</label>
                        <select name="priority" id="priorityFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach (['غير عاجل', 'متوسط', 'عاجل'] as $priority)
                                <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>
                                    {{ $priority }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <script>
                    $('#serviceFilter, #statusFilter, #priorityFilter').on('change keyup', function () {
                        $('#filtersForm').submit();
                    });
                </script>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>الخدمة</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>السعر</th>
                                <th>تاريخ الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->service->name }}</td>
                                    <td class="status-column">
                                        <span class="badge" data-status="{{ $request->status }}">
                                            {{ $request->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $request->priority }}
                                        </span>
                                    </td>


                                    <td>{{ $request->price ?? '-' }}</td>
                                    <td>{{ $request->created_at->format('Y/m/d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>