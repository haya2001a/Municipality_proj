<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="addServiceForm" method="POST" action="{{ route('admin.services.store') }}">
            @csrf
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header border-0 d-flex justify-content-between">
                    <h5 class="modal-title fw-bold">إضافة خدمة جديدة</h5>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">اسم الخدمة</label>
                            <input type="text" name="name"
                                class="form-control bg-light @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">القسم</label>
                            <select name="department_id"
                                class="form-select bg-light @error('department_id') is-invalid @enderror" required>
                                <option value="" disabled selected hidden>اختر القسم</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">السعر</label>
                            <input type="number" step="0.01" name="price"
                                class="form-control bg-light @error('price') is-invalid @enderror" required>
                            @error('price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">مدة الإنجاز (بالأيام)</label>
                            <input type="number" name="processing_time"
                                class="form-control bg-light @error('processing_time') is-invalid @enderror" required>
                            @error('processing_time')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex gap-3">
                            <div class="flex-fill d-flex flex-column">
                                <label class="form-label">الحالة</label>
                                <select name="status"
                                    class="form-select bg-light h-100 @error('status') is-invalid @enderror" required>
                                    <option value="" disabled selected hidden>اختر الحالة</option>
                                    <option value="فعّالة">فعّالة</option>
                                    <option value="غير فعّالة">غير فعّالة</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">الوثائق المطلوبة</label>
                            <textarea name="required_documents" class="form-control bg-light @error('required_documents') is-invalid @enderror"
                                placeholder="اكتب الوثائق المطلوبة لكل خدمة"></textarea>
                            @error('required_documents')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea name="description" class="form-control bg-light @error('description') is-invalid @enderror"></textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">مسار الخدمة</label>
                            <textarea name="notes" class="form-control bg-light @error('notes') is-invalid @enderror"
                                placeholder="اكتب مسار الخدمة"></textarea>
                            @error('notes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill"
                        data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-modern px-4 rounded-pill">إضافة</button>
                </div>
            </div>
        </form>
    </div>
</div>

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
