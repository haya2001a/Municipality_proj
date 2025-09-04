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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                required>
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

                        <div class="col-md-6">
                            <label class="form-label">مدة الإنجاز (بالأيام)</label>
                            <input type="number" name="processing_time"
                                class="form-control @error('processing_time') is-invalid @enderror" required>
                            @error('processing_time')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- الحالة والأولوية بنفس السطر وبنفس الطول -->
                        <div class="col-12 d-flex gap-3">
                            <!-- الحالة -->
                            <div class="flex-fill d-flex flex-column">
                                <label class="form-label">الحالة</label>
                                <select name="status" class="form-select h-100 @error('status') is-invalid @enderror"
                                    required>
                                    <option value="" disabled selected hidden>اختر الحالة</option>
                                    <option value="فعّالة">فعّالة</option>
                                    <option value="غير فعّالة">غير فعّالة</option>
                                </select>
                                @error('status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="flex-fill d-flex flex-column">
                                <label class="form-label">الأولوية</label>
                                <select name="priority"
                                    class="form-select h-100 @error('priority') is-invalid @enderror" required>
                                    <option value="" hidden>اختر الأولوية</option>
                                    <option value="غير عاجل">غير عاجل</option>
                                    <option value="متوسط">متوسط</option>
                                    <option value="عاجل">عاجل</option>
                                </select>
                                @error('priority')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="col-12">
                            <label class="form-label">الوثائق المطلوبة</label>
                            <textarea name="required_documents"
                                class="form-control @error('required_documents') is-invalid @enderror"
                                placeholder="اكتب الوثائق المطلوبة لكل خدمة، وافصل بينها بفاصلة أو سطر جديد"></textarea>
                            @error('required_documents')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- الوصف -->
                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea name="description"
                                class="form-control @error('description') is-invalid @enderror"></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- الملاحظات -->
                        <div class="col-12">
                            <label class="form-label">مسار الخدمة</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                placeholder="اكتب مسار الخدمة"></textarea>
                            @error('notes')
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