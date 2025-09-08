<div class="modal fade" id="editServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <form id="editServiceForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">تعديل الخدمة</h5>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">اسم الخدمة</label>
                            <input type="text" name="name" id="editServiceName" class="form-control" required>
                        </div>

                        <div class="col-6">
                            <label for="priority">الأولوية</label>
                            <select name="priority" id="priority" class="form-select" required>
                                <option value="" selected hidden>اختر الأولوية</option>
                                <option value="غير عاجل">غير عاجل</option>
                                <option value="متوسط">متوسط</option>
                                <option value="عاجل">عاجل</option>
                            </select>
                            @error('priority')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label fw-semibold">السعر</label>
                            <input type="number" name="price" id="editServicePrice" class="form-control"
                                step="0.01" min="0">
                        </div>

                        <div class="col-3">
                            <label class="form-label fw-semibold">مدة البداية</label>
                            <input type="number" name="processing_time_min" id="editProcessingTimeMin"
                                class="form-control" min="0">
                        </div>

                        <div class="col-3">
                            <label class="form-label fw-semibold">مدة النهاية</label>
                            <input type="number" name="processing_time_max" id="editProcessingTimeMax"
                                class="form-control" min="0">
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-semibold">القسم</label>
                            <select name="department_id" id="editDepartment" class="form-select" required>
                                <option value="">اختر القسم</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-semibold">الحالة</label>
                            <select name="status" id="editStatus" class="form-select" required>
                                <option value="فعّالة">فعّالة</option>
                                <option value="غير فعّالة">غير فعّالة</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </div>
        </form>
    </div>
</div>
