<x-app-layout>
    @include('deleteItem')

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/tabels.css') }}">
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
                        <span class="fs-5 fw-bold">إدارة المستخدمين</span>
                        <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            إضافة مستخدم جديد
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <form method="GET" action="{{ route('admin.users.index') }}" id="roleFilterForm"
                            class="d-flex align-items-center gap-2 mb-0">
                            <label for="roleFilter" class="mb-0 fw-semibold">الدور:</label>
                            <select name="role" id="roleFilter" class="form-select w-auto form-select-sm">
                                <option value="">الكل</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ request('role') == $role->name ? 'selected' : '' }}>
                                        {{ $role->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        <form method="GET" action="{{ route('admin.users.index') }}" id="nameFilterForm"
                            class="d-flex align-items-center gap-2 mb-0">
                            <label for="nameFilter" class="mb-0 fw-semibold">الاسم:</label>
                            <input type="text" name="name" id="nameFilter" class="form-control form-control-sm"
                                placeholder="ابحث بالاسم" value="{{ request('name') }}">
                        </form>
                    </div>
                </caption>

                <thead class="table-light">
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
                                <button class="table-link editUserBtn" data-id="{{ $user->id }}" title="تعديل">
                                    <span class="fa-stack">
                                        <i class="fa fa-square fa-stack-2x text-primary"></i>
                                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
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

        <div class="mt-3">{{ $users->links() }}</div>
    </div>

    {{-- edit users modal --}}
    @include('admin.editUserModal');

    {{-- add users modal --}}
    @include('admin.addUserModal');


    <script>
        $(function() {
            // fetch departments and roles list
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
                        $roleSelect.append('<option value="' + r.id + '">' + r.name_ar +
                            '</option>');
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

            // open edit modal
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

            // open the modal if any error occur
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

            // reset the from when the model is cloesd
            $('#editUserModal, #addUserModal').on('hidden.bs.modal', function() {
                resetForm('editUserForm');
                resetForm('addUserForm');
            });

            //load the departments when the modal open
            $('#addUserModal').on('show.bs.modal', function() {
                loadDepartments();
                loadRoles();
            });

            //delete modal
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
