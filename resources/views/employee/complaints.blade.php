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
                <h5 class="mb-0 fw-bold">الشكاوي</h5>
            </div>

            <div class="card-body p-4">
                {{-- Filters --}}
                <form method="GET" action="{{ route('employee.complaints.index') }}" id="filtersForm"
                    class="d-flex flex-wrap align-items-center gap-3 mb-4">

                    <div class="filter-group">
                        <label for="statusFilter" class="fw-semibold mb-0">الحالة:</label>
                        <select name="status" id="statusFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach (['قيد الانتظار', 'مرفوض', 'مكتمل'] as $status)
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <script>
                    $('#statusFilter, #departmentFilter').on('change keyup', function() {
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
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $complaint)
                                <tr class="align-middle">
                                    <td class="fw-semibold">{{ $complaint->title }}</td>
                                    <td>{{ Str::limit($complaint->description, 50) }}</td>
                                    <td>{{ $complaint->department->name }}</td>
                                    <td class="status-column">
                                        <span class="badge" data-status="{{ $complaint->status }}">
                                            {{ $complaint->status }}
                                        </span>
                                    </td>
                                    <td>{{ $complaint->closed_at ? $complaint->closed_at->format('Y/m/d') : '-' }}</td>
                                    <td>{{ $complaint->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-gradient" data-bs-toggle="modal"
                                            data-bs-target="#respondModal" data-id="{{ $complaint->id }}"
                                            data-title="{{ $complaint->title }}"
                                            data-response="{{ $complaint->response }}"
                                            data-status="{{ $complaint->status }}">
                                            <i class="fas fa-reply"></i> رد
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">{{ $complaints->links() }}</div>
            </div>
        </div>
    </div>
    @include('employee.complaintsResponeModal')
</x-app-layout>

<script>
    const respondModal = document.getElementById('respondModal');
    respondModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const response = button.getAttribute('data-response') || '';
        const status = button.getAttribute('data-status');

        const form = document.getElementById('respondForm');
        form.action = `/employee/complaints/${id}`;

        document.getElementById('respondModalTitle').textContent = 'الرد على الشكوى: ' + title;
        document.getElementById('complaintResponse').value = response;
        document.getElementById('complaintStatus').value = status;
    });
</script>
