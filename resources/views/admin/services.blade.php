<x-app-layout>
    @include('deleteItem')

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/services.css') }}">
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
                <h5 class="mb-0 fw-bold">إدارة الخدمات</h5>
                <button type="button" class="btn btn-modern btn-sm px-3 rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addServiceModal">
                    <i class="fas fa-plus me-1"></i> إضافة خدمة جديدة
                </button>
            </div>

            <div class="card-body p-4">
                {{-- Filters --}}
                <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
                    <form method="GET" action="{{ route('admin.services.index') }}" id="statusFilterForm"
                        class="d-flex align-items-center gap-2 mb-0">
                        <label for="statusFilter" class="fw-semibold mb-0">الحالة:</label>
                        <select name="status" id="statusFilter" class="form-select form-select-sm rounded-pill">
                            <option value="">الكل</option>
                            <option value="فعّالة" {{ request('status') == 'فعّالة' ? 'selected' : '' }}>فعّالة
                            </option>
                            <option value="غير فعّالة" {{ request('status') == 'غير فعّالة' ? 'selected' : '' }}>غير
                                فعّالة</option>
                        </select>
                    </form>

                    <form method="GET" action="{{ route('admin.services.index') }}" id="departmentFilterForm"
                        class="d-flex align-items-center gap-2 mb-0">
                        <label for="departmentFilter" class="fw-semibold mb-0">القسم:</label>
                        <select name="department" id="departmentFilter" class="form-select form-select-sm rounded-pill">
                            <option value="">الكل</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('department') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <form method="GET" action="{{ route('admin.services.index') }}" id="nameFilterForm"
                        class="d-flex align-items-center gap-2 mb-0">
                        <label for="nameFilter" class="fw-semibold mb-0">الخدمة:</label>
                        <input type="text" name="name" id="nameFilter"
                            class="form-control form-control-sm rounded-pill" placeholder="ابحث باسم الخدمة"
                            value="{{ request('name') }}">
                    </form>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>الخدمة</th>
                                <th>القسم</th>
                                <th>السعر</th>
                                <th>المدة (دقيقة)</th>
                                <th>الحالة</th>
                                <th class="text-center">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->department->name ?? '-' }}</td>
                                    <td>{{ number_format($service->price, 2) }}</td>
                                    <td>
                                        @if ($service->processing_time_min && $service->processing_time_max)
                                            {{ $service->processing_time_min }} - {{ $service->processing_time_max }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $service->status }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary editServiceBtn"
                                            data-id="{{ $service->id }}" title="تعديل">
                                            <i class="fas fa-edit me-1"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.services.destroy', $service->id) }}"
                                            data-message="هل أنت متأكد أنك تريد حذف الخدمة {{ $service->name }}؟">
                                            <i class="fas fa-trash-alt me-1"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">{{ $services->links() }}</div>
            </div>
        </div>
    </div>

    {{-- edit services modal --}}
    @include('admin.editServiceModal')

    {{-- add services modal --}}
    @include('admin.addServiceModal')

    <script>
        $(function() {
            // open edit modal
            $('.editServiceBtn').on('click', function() {
                var serviceId = $(this).data('id');

                $.get('/admin/services/' + serviceId + '/edit', function(data) {
                    $('#editServiceForm').attr('action', '/admin/services/' + serviceId);
                    $('#editServiceForm [name="name"]').val(data.name);
                    $('#editServiceForm [name="price"]').val(data.price);
                    $('#editServiceForm [name="processing_time_min"]').val(data
                    .processing_time_min);
                    $('#editServiceForm [name="processing_time_max"]').val(data
                    .processing_time_max);
                    $('#editServiceForm [name="status"]').val(data.status);
                    $('#editServiceForm [name="department_id"]').val(data.department_id);

                    $('#editServiceModal').modal('show');
                });
            });

            // reset the form when modal closed
            $('#editServiceModal, #addServiceModal').on('hidden.bs.modal', function() {
                resetForm('editServiceForm');
                resetForm('addServiceForm');
            });

            // delete modal
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var action = button.data('action');
                var message = button.data('message');

                $('#deleteForm').attr('action', action);
                $('#deleteModalMessage').text(message);
            });
        });

        $('#statusFilter').on('change', function() {
            $('#statusFilterForm').submit();
        });
        $('#departmentFilter').on('change', function() {
            $('#departmentFilterForm').submit();
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

        .form-select.rounded-pill,
        .form-control.rounded-pill {
            border-radius: 50px !important;
        }
    </style>
</x-app-layout>
