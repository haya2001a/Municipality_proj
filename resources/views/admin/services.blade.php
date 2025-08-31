<x-app-layout>
    @include('deleteItem')

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/services.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ Vite::asset('resources/js/shared.js') }}"></script>

    <div class="container mt-4 px-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}</div>
        @endif

        <div class="table-responsive px-5">
            <table class="table table-bordered service-list">
                <caption class="pb-3 text-start" style="caption-side: top;">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <span class="fs-5 fw-bold">إدارة الخدمات</span>
                        <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal"
                            data-bs-target="#addServiceModal">
                            إضافة خدمة جديدة
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <form method="GET" action="{{ route('admin.services.index') }}" id="statusFilterForm"
                            class="d-flex align-items-center gap-2 mb-0">
                            <label for="statusFilter" class="mb-0 fw-semibold">الحالة:</label>
                            <select name="status" id="statusFilter" class="form-select w-auto form-select-sm">
                                <option value="">الكل</option>
                                <option value="فعّالة" {{ request('status') == 'فعّالة' ? 'selected' : '' }}>فعّالة
                                </option>
                                <option value="غير فعّالة" {{ request('status') == 'غير فعّالة' ? 'selected' : '' }}>غير
                                    فعّالة</option>
                            </select>
                        </form>

                        <form method="GET" action="{{ route('admin.services.index') }}" id="departmentFilterForm"
                            class="d-flex align-items-center gap-2 mb-0">
                            <label for="departmentFilter" class="mb-0 fw-semibold">القسم:</label>
                            <select name="department" id="departmentFilter" class="form-select w-auto form-select-sm">
                                <option value="">الكل</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <form method="GET" action="{{ route('admin.services.index') }}" id="priorityFilterForm"
                            class="d-flex align-items-center gap-2 mb-0">
                            <label for="priorityFilter" class="mb-0 fw-semibold">الأولوية:</label>
                            <select name="priority" id="priorityFilter" class="form-select w-auto form-select-sm">
                                <option value="">الكل</option>
                                @foreach (['غير عاجل', 'متوسط', 'عاجل'] as $priority)
                                    <option value="{{ $priority }}"
                                        {{ request('priority') == $priority ? 'selected' : '' }}>
                                        {{ $priority }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <form method="GET" action="{{ route('admin.services.index') }}" id="nameFilterForm"
                            class="d-flex align-items-center gap-2 mb-0">
                            <label for="nameFilter" class="mb-0 fw-semibold">الخدمة:</label>
                            <input type="text" name="name" id="nameFilter" class="form-control form-control-sm"
                                placeholder="ابحث باسم الخدمة" value="{{ request('name') }}">
                        </form>


                    </div>
                </caption>

                <thead class="table-light">
                    <tr>
                        <th>الخدمة</th>
                        <th>القسم</th>
                        <th>السعر</th>
                        <th>المدة (دقيقة)</th>
                        <th>الحالة</th>
                        <th>الأولوية</th>
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
                            <td>{{ $service->priority }}</td>
                            <td class="text-center">
                                <button class="table-link editServiceBtn" data-id="{{ $service->id }}" title="تعديل">
                                    <span class="fa-stack">
                                        <i class="fa fa-square fa-stack-2x text-primary"></i>
                                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-action="{{ route('admin.services.destroy', $service->id) }}"
                                    data-message="هل أنت متأكد أنك تريد حذف الخدمة {{ $service->name }}؟">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $services->links() }}</div>
    </div>

    {{-- edit services modal --}}
    @include('admin.editServiceModal');

    {{-- add services modal --}}
    @include('admin.addServiceModal');

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

            // reset the form when the modal is closed
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

        $('#priorityFilter').on('change', function() {
            $('#priorityFilterForm').submit();
        });
    </script>
</x-app-layout>
