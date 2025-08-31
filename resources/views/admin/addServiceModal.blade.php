<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="addServiceForm" method="POST" action="{{ route('admin.services.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title flex-grow-1">إضافة خدمة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- اسم الخدمة -->
                        <div class="col-md-6">
                            <label class="form-label">اسم الخدمة</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- القسم -->
                        <div class="col-md-6">
                            <label class="form-label">القسم</label>
                            <select name="department_id"
                                class="form-select @error('department_id') is-invalid @enderror" required>
                                <option value="" disabled selected hidden>اختر القسم</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- السعر -->
                        <div class="col-md-6">
                            <label class="form-label">السعر</label>
                            <input type="number" step="0.01" name="price"
                                class="form-control @error('price') is-invalid @enderror" required>
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- المدة الدنيا -->
                        <div class="col-md-6">
                            <label class="form-label">المدة الدنيا (بالأيام)</label>
                            <input type="number" name="processing_time_min"
                                class="form-control @error('processing_time_min') is-invalid @enderror" required>
                            @error('processing_time_min')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- المدة القصوى -->
                        <div class="col-md-6">
                            <label class="form-label">المدة القصوى (بالأيام)</label>
                            <input type="number" name="processing_time_max"
                                class="form-control @error('processing_time_max') is-invalid @enderror" required>
                            @error('processing_time_max')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الحالة -->
                        <div class="col-md-6">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="" disabled selected hidden>اختر الحالة</option>
                                <option value="فعّالة">فعّالة</option>
                                <option value="غير فعّالة">غير فعّالة</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <div class="form-group mb-3" class="col-md-6">
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
                        </div>
                        <!-- الوصف -->
                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إضافة</button>
                </div>
            </div>
        </form>
    </div>
</div>
