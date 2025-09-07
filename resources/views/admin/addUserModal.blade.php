<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="addUserForm" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header border-0 d-flex justify-content-between">
                    <h5 class="modal-title fw-bold">إضافة مستخدم جديد</h5>
                  
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">الاسم</label>
                            <input type="text" name="name"
                                class="form-control bg-light @error('name') is-invalid @enderror" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">رقم الهوية</label>
                            <input type="text" name="national_id"
                                class="form-control bg-light @error('national_id') is-invalid @enderror" required>
                            @error('national_id') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email"
                                class="form-control bg-light @error('email') is-invalid @enderror" required>
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الهاتف</label>
                            <input type="text" name="phone"
                                class="form-control bg-light @error('phone') is-invalid @enderror">
                            @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الجنس</label>
                            <select name="gender" class="form-select bg-light @error('gender') is-invalid @enderror">
                                <option value="" disabled selected hidden>اختر الجنس</option>
                                <option value="ذكر">ذكر</option>
                                <option value="أنثى">أنثى</option>
                            </select>
                            @error('gender') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">الدور</label>
                            <select name="role_id" class="form-select bg-light @error('role_id') is-invalid @enderror" required id="roleSelect">
                            </select>
                            @error('role_id') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6" id="departmentWrapper" style="display:none;">
                            <label class="form-label">القسم</label>
                            <select name="department_id"
                                class="form-select bg-light @error('department_id') is-invalid @enderror" id="departmentSelect">
                                <option value="">اختر القسم</option>
                            </select>
                            @error('department_id') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">هل لديه رخصة تجارية؟</label>
                            <select name="has_license" id="hasTradeLicense" class="form-select bg-light">
                                <option value="0" selected>لا</option>
                                <option value="1">نعم</option>
                            </select>
                        </div>

                        <div id="tradeSection" style="display:none; width:100%;">
                            <hr>
                            <h6 class="mb-3 fw-bold">بيانات الرخصة</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">اسم المهنة</label>
                                    <input type="text" name="trade_name" class="form-control bg-light">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">تاريخ فتح المحل</label>
                                    <input type="date" name="opened_since" class="form-control bg-light datepicker">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">تاريخ إصدار الرخصة</label>
                                    <input type="date" name="issue_date" class="form-control bg-light datepicker">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">تاريخ آخر دفعة</label>
                                    <input type="date" name="last_payment" class="form-control bg-light datepicker">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">الحالة</label>
                                    <select name="license_status" class="form-select bg-light">
                                        <option value="" hidden>اختر الحالة</option>
                                        <option value="سارية">سارية</option>
                                        <option value="منتهية">منتهية</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">ملاحظات</label>
                            <textarea name="notes" rows="3" class="form-control bg-light @error('notes') is-invalid @enderror"></textarea>
                            @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-modern px-4 rounded-pill">إضافة</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
        locale: "ar",
    });

    $(document).ready(function() {
        $('#hasTradeLicense').on('change', function() {
            if ($(this).val() === '1') {
                $('#tradeSection').slideDown();
            } else {
                $('#tradeSection').slideUp();
            }
        });
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

    .form-control.bg-light, 
    .form-select.bg-light {
        border-radius: 0.5rem;
    }
</style>
