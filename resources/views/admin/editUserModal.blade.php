<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title flex-grow-1">عرض / تعديل المستخدم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">الاسم</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم الهوية</label>
                            <input type="text" name="national_id"
                                class="form-control @error('national_id') is-invalid @enderror" required>
                            @error('national_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الهاتف</label>
                            <input type="text" name="phone"
                                class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الجنس</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                <option value="ذكر">ذكر</option>
                                <option value="أنثى">أنثى</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </form>
    </div>
</div>
