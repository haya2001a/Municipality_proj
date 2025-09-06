<x-app-layout>
    @include('deleteItem')

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/tabels.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="{{ Vite::asset('resources/js/shared.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ar.js"></script>

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
                <h5 class="mb-0 fw-bold">إدارة المستخدمين</h5>
                <button type="button" class="btn btn-modern btn-sm px-3 rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus me-1"></i> إضافة مستخدم جديد
                </button>
            </div>

            <div class="card-body p-4">
                {{-- Filters --}}
                <div class="d-flex align-items-center gap-4 flex-wrap mb-4">
                    <form method="GET" action="{{ route('admin.users.index') }}" id="roleFilterForm"
                        class="d-flex align-items-center gap-2 mb-0">
                        <label for="roleFilter" class="fw-semibold mb-0">الدور:</label>
                        <select name="role" id="roleFilter" class="form-select filter-select">
                            <option value="">الكل</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name_ar }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <form method="GET" action="{{ route('admin.users.index') }}" id="nameFilterForm"
                        class="d-flex align-items-center gap-2 mb-0">
                        <label for="nameFilter" class="fw-semibold mb-0">الاسم:</label>
                       <input type="text" name="name" id="nameFilter"
                        class="form-control form-control-sm rounded-pill" 
                        placeholder="ابحث بالاسم" value="{{ request('name') }}">
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th>المستخدم</th>
                                <th>رقم الهوية</th>
                                <th>الهاتف</th>
                                <th>الجنس</th>
                                <th>البريد الإلكتروني</th>
                                <th>تاريخ الإنشاء</th>
                                <th class="text-center">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->national_id }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>{{ $user->gender ?? '-' }}</td>
                                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    <td>{{ $user->created_at->format('Y/m/d') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary editUserBtn"
                                            data-id="{{ $user->id }}" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.users.destroy', $user->id) }}"
                                            data-message="هل أنت متأكد أنك تريد حذف المستخدم {{ $user->name }}؟">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">{{ $users->links() }}</div>
            </div>
        </div>
    </div>

    {{-- edit users modal --}}
    @include('admin.editUserModal')

    {{-- add users modal --}}
    @include('admin.addUserModal')

    <script>
        $(function() {
            function loadDepartments() {
                $.get("{{ route('admin.departments') }}", function(data) {
                    var $deptSelect = $('#departmentSelect');
                    $deptSelect.html('<option value="">اختر القسم</option>');
                    $.each(data, function(i, d) {
                        $deptSelect.append('<option value="' + d.id + '">' + d.name + '</option>');
                    });
                });
            }

            function loadRoles() {
                $.get("{{ route('admin.roles') }}", function(data) {
                    var $roleSelect = $('#roleSelect');
                    $roleSelect.html('<option value="" disabled selected hidden>اختر الدور</option>');
                    $.each(data, function(i, r) {
                        $roleSelect.append('<option value="' + r.id + '">' + r.name_ar + '</option>');
                    });

                    $roleSelect.off('change').on('change', function() {
                        var selectedRole = $(this).find('option:selected').text();
                        if (selectedRole != 'موظف') {
                            $('#departmentWrapper').hide();
                            $('#departmentSelect').val('');
                        } else {
                            $('#departmentWrapper').show();
                        }
                    });
                });
            }

            $('.editUserBtn').on('click', function() {
                var userId = $(this).data('id');
                $.get('/admin/users/' + userId + '/edit', function(data) {
                    $('#editUserForm').attr('action', '/admin/users/' + userId);
                    $('#editUserForm [name="name"]').val(data.name);
                    $('#editUserForm [name="national_id"]').val(data.national_id);
                    $('#editUserForm [name="email"]').val(data.email);
                    $('#editUserForm [name="phone"]').val(data.phone);
                    $('#editUserForm [name="gender"]').val(data.gender);

                    $('#editUserModal').modal('show');
                });
            });

            @if ($errors->any())
                @if (session('form') == 'add')
                    $('#addUserModal').modal('show');
                    loadDepartments();
                    loadRoles();

                    var oldValues = @json(old());
                    $.each(oldValues, function(key, value) {
                        $('#addUserForm [name="' + key + '"]').val(value);
                    });
                @elseif (session('form') == 'edit')
                    $('#editUserModal').modal('show');
                    $('#editUserForm').attr('action', '/admin/users/{{ session('editing_user_id') }}');

                    var oldValues = @json(old());
                    $.each(oldValues, function(key, value) {
                        $('#editUserForm [name="' + key + '"]').val(value);
                    });
                @endif
            @endif

            $('#editUserModal, #addUserModal').on('hidden.bs.modal', function() {
                resetForm('editUserForm');
                resetForm('addUserForm');
            });

            $('#addUserModal').on('show.bs.modal', function() {
                loadDepartments();
                loadRoles();
            });

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var action = button.data('action');
                var message = button.data('message');

                $('#deleteForm').attr('action', action);
                $('#deleteModalMessage').text(message);
            });
        });

        $('#roleFilter').on('change', function() {
            $('#roleFilterForm').submit();
        });
    </script>
    
</x-app-layout>
