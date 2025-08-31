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
                        <span class="fs-5 fw-bold">الطلبات الخاصة بي</span>
                        <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal"
                            data-bs-target="#addRequestModal">
                            طلب خدمة جديدة
                        </button>
                    </div>


                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <form method="GET" action="{{ route('citizen.requests.index') }}" id="filtersForm"
                            class="d-flex align-items-center gap-3 flex-wrap mb-0">
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
                            $('#serviceFilter, #statusFilter, #priorityFilter').on('change keyup', function() {
                                $('#filtersForm').submit();
                            });
                        </script>
                    </div>
                </caption>

                <thead class="table-light">
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
                            <td>{{ $request->status }}</td>
                            <td>{{ $request->priority }}</td>
                            <td>{{ $request->price ?? '-' }}</td>
                            <td>{{ $request->created_at->format('Y/m/d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $requests->links() }}</div>
    </div>

    {{-- assign requests modal --}}
    @include('citizen.addRequestModal');

    <script>
        $(function() {
            // filters submit
            $('#serviceFilter, #statusFilter').on('change', function() {
                $(this).closest('form').submit();
            });

            $(document).ready(function() {
                // فتح المودال عند الضغط على الزر
                $('#openAddRequestModal').click(function() {
                    $('#addRequestModal').modal('show');
                });
            });
        });
    </script>

</x-app-layout>
