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
                <h5 class="mb-0 fw-bold">الشكاوي الخاصة بي</h5>
                <button type="button"
                    class="btn btn-gradient btn-sm px-4 py-2 rounded-pill d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#addComplaintModal">
                    <i class="fas fa-plus"></i> إضافة شكوى جديدة
                </button>
            </div>

            <div class="card-body p-4">
                {{-- Filters --}}
                <form method="GET" action="{{ route('citizen.complaints.index') }}" id="filtersForm"
                    class="d-flex flex-wrap align-items-center gap-3 mb-4">

                    {{-- فلتر الحالة --}}
                    <div class="filter-group">
                        <label for="statusFilter" class="fw-semibold mb-0">الحالة:</label>
                        <select name="status" id="statusFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach (['قيد الانتظار', 'مرفوض', 'مكتمل'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- فلتر القسم --}}
                    <div class="filter-group">
                        <label for="departmentFilter" class="fw-semibold mb-0">القسم:</label>
                        <select name="department_id" id="departmentFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </form>

                <script>
                    $('#statusFilter, #departmentFilter').on('change keyup', function () {
                        $('#filtersForm').submit();
                    });
                </script>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>عنوان الشكوى</th>
                                <th>الوصف</th>
                                <th>القسم</th>
                                <th>الحالة</th>
                                <th>تاريخ الإغلاق</th>
                                <th>تاريخ التقديم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $complaint)
                                <tr class="align-middle">
                                    <td class="fw-semibold">{{ $complaint->title }}</td>
                                    <td>{{ Str::limit($complaint->description, 50) }}</td>
                                    <td>{{ $complaint->department->name}}</td>
                                    <td class="status-column">
                                        <span class="badge" data-status="{{ $complaint->status }}">
                                            {{ $complaint->status }}
                                        </span>
                                    </td>
                                    <td>{{ $complaint->closed_at ? $complaint->closed_at->format('Y/m/d') : '-' }}</td>
                                    <td>{{ $complaint->created_at->format('Y/m/d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">{{ $complaints->links() }}</div>
            </div>
        </div>
    </div>

    {{-- Add Complaint Modal --}}
    @include('citizen.addComplaintModal')

    <script>
        $(function () {
            $('#openAddComplaintModal').click(function () {
                $('#addComplaintModal').modal('show');
            });
        });
    </script>

</x-app-layout>
