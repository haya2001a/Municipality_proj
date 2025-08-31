<x-app-layout>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/users.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="{{ Vite::asset('resources/js/shared.js') }}"></script>

    <div class="container mt-4 px-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}</div>
        @endif

        <div class="table-responsive px-5">
            <table class="table table-bordered user-list">
                <caption class="pb-3 text-start" style="caption-side: top;">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <span class="fs-5 fw-bold">إدارة الطلبات</span>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <form method="GET" action="{{ route('admin.requests.index') }}" id="filtersForm"
                            class="d-flex align-items-center gap-3 flex-wrap mb-0">
                            <!-- User Filter -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="userFilter" class="mb-0 fw-semibold">اسم المستخدم:</label>
                                <input type="text" name="user" id="userFilter"
                                    class="form-control form-control-sm" placeholder="ابحث بالاسم"
                                    value="{{ request('user') }}">
                            </div>

                            <!-- Service Filter -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="serviceFilter" class="mb-0 fw-semibold">الخدمة:</label>
                                <select name="service" id="serviceFilter" class="form-select w-auto form-select-sm">
                                    <option value="">الكل</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ request('service') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="d-flex align-items-center gap-2">
                                <label for="statusFilter" class="mb-0 fw-semibold">الحالة:</label>
                                <select name="status" id="statusFilter" class="form-select w-auto form-select-sm">
                                    <option value="">الكل</option>
                                    @foreach (['بانتظار الموافقة', 'مرفوض', 'مكتمل', 'مدفوع'] as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Priority Filter -->
                            <div class="d-flex align-items-center gap-2">
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
                            </div>
                        </form>

                        <script>
                            // submit form automatically when any filter changes
                            $('#userFilter, #serviceFilter, #statusFilter, #priorityFilter').on('change keyup', function() {
                                $('#filtersForm').submit();
                            });
                        </script>


                    </div>
                </caption>

                <thead class="table-light">
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
                                <button class="btn btn-sm btn-primary assignRequestBtn" data-id="{{ $request->id }}"
                                    title="إسناد الطلب">
                                    <i class="fas fa-user-check"></i> إسناد
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $requests->links() }}</div>
    </div>

    {{-- assign requests modal --}}
    @include('admin.assignRequestModal');

    <script>
        $(function() {
            // filters submit
            $('#userFilter').on('change keyup', function() {
                $('#userFilterForm').submit();
            });

            $('#serviceFilter, #statusFilter').on('change', function() {
                $(this).closest('form').submit();
            });

            // Assign request button
            $('.assignRequestBtn').on('click', function() {
                var requestId = $(this).data('id');

                // fetch employee list
                $.get('/admin/requests/' + requestId + '/employees', function(data) {
                    var $select = $('#assigned_to');
                    $select.empty();

                    if (data.length > 0) {
                        $.each(data, function(i, employee) {
                            $select.append('<option value="' + employee.id + '">' + employee
                                .name + '</option>');
                        });
                    } else {
                        $select.append('<option value="">لا يوجد موظفين في هذه الدائرة</option>');
                    }

                    $('#assignRequestForm').attr('action', '/admin/requests/' + requestId +
                        '/assign');

                    $('#assignRequestModal').modal('show');
                });
            });
        });
    </script>

</x-app-layout>
