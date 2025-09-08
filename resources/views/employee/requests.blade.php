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
                <form method="GET" action="{{ route('employee.requests.index') }}" id="filtersForm"
                    class="d-flex flex-wrap align-items-center gap-3 mb-4">

                    <div class="filter-group">
                        <label for="serviceFilter" class="fw-semibold mb-0">الخدمة:</label>
                        <select name="service" id="serviceFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ request('service') == $service->id ? 'selected' : '' }}>
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
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
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
                                <option value="{{ $priority }}"
                                    {{ request('priority') == $priority ? 'selected' : '' }}>
                                    {{ $priority }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <script>
                    $('#serviceFilter, #statusFilter, #priorityFilter').on('change keyup', function() {
                        $('#filtersForm').submit();
                    });
                </script>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>الخدمة</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>السعر</th>
                                <th>تاريخ الطلب</th>
                                <th>العمليات</th>
                                <th>الإجراءات</th>>
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

                                    <td class="status-column">
                                        <form method="POST"
                                            action="{{ route('employee.requests.updateStatus', $request->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="status-select status-{{ $request->status }}"
                                                onchange="this.form.submit()">
                                                @foreach (['بانتظار الموافقة', 'مرفوض', 'مكتمل', 'مدفوع'] as $status)
                                                    <option value="{{ $status }}"
                                                        {{ $request->status == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- زر فتح المودال -->
                                        <button class="btn btn-sm btn-primary view-attachments-btn"
                                            data-attachments="{{ json_encode($request->attachments) }}">
                                            عرض الملفات
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
    <style>
        .status-select {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 14px;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .status-select:hover {
            border-color: #007bff;
        }

        .status-select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
        }

        .status-pending {
            color: #856404;
            background: #fff3cd;
        }

        .status-rejected {
            color: #721c24;
            background: #f8d7da;
        }

        .status-completed {
            color: #155724;
            background: #d4edda;
        }

        .status-paid {
            color: #004085;
            background: #cce7ff;
        }
    </style>

    @include('employee.attachmentModal')
    <script>

        function showAttachments(files) {
            const container = document.getElementById('attachmentsContainer');
            const noMsg = document.getElementById('noAttachmentsMessage');
            container.innerHTML = '';

            if (!files || files.length === 0) {
                noMsg.classList.remove('d-none');
                return;
            } else {
                noMsg.classList.add('d-none');
            }

            files.forEach(file => {
                const ext = file.file_type.split('/')[1];

                if (file.file_type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = `/storage/service_requests/${file.request_id}/${file.file_name}`;
                    img.alt = file.original_name || file.file_name;
                    img.addEventListener('click', () => window.open(img.src, '_blank'));
                    container.appendChild(img);
                } else {
                    const a = document.createElement('a');
                    a.href = `/storage/service_requests/${file.request_id}/${file.file_name}`;
                    a.target = '_blank';
                    a.className = 'file-link';
                    a.innerHTML = `<i class="fas fa-file-alt"></i> ${file.original_name || file.file_name}`;
                    container.appendChild(a);
                }
            });
        }

        document.querySelectorAll('.view-attachments-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const files = JSON.parse(this.dataset.attachments);
                showAttachments(files);
                new bootstrap.Modal(document.getElementById('attachmentsModal')).show();
            });
        });
    </script>
    <script>
        function showAttachments(files) {
            const container = document.getElementById('attachmentsContainer');
            const noMsg = document.getElementById('noAttachmentsMessage');
            container.innerHTML = '';

            if (!files || files.length === 0) {
                noMsg.classList.remove('d-none');
                return;
            } else {
                noMsg.classList.add('d-none');
            }

            files.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'attachment-item';

                if (file.file_type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = `/storage/service_requests/${file.request_id}/${file.file_name}`;
                    img.alt = file.original_name || file.file_name;
                    img.title = file.original_name || file.file_name;
                    img.addEventListener('click', () => window.open(img.src, '_blank'));
                    item.appendChild(img);
                } else {
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-file-alt';
                    item.appendChild(icon);
                }

                const name = document.createElement('div');
                name.className = 'attachment-name';
                name.textContent = file.original_name || file.file_name;
                item.appendChild(name);

                item.addEventListener('click', () => {
                    window.open(`/storage/service_requests/${file.request_id}/${file.file_name}`, '_blank');
                });

                container.appendChild(item);

                if (index < files.length - 1) {
                    const divider = document.createElement('hr');
                    divider.className = 'attachment-divider';
                    container.appendChild(divider);
                }
            });
        }

        document.querySelectorAll('.view-attachments-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const files = JSON.parse(this.dataset.attachments);
                showAttachments(files);
                new bootstrap.Modal(document.getElementById('attachmentsModal')).show();
            });
        });
    </script>
</x-app-layout>
