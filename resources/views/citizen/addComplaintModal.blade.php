<div class="modal fade" id="addComplaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addComplaintForm" method="POST" action="{{ route('citizen.complaints.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة شكوى جديدة</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="title">عنوان الشكوى</label>
                        <input type="text" name="title" id="title" class="form-control" required
                            placeholder="أدخل عنوان الشكوى">
                    </div>
                    <div class="form-group mb-3">
                        <label for="department_id">القسم</label>
                        <select name="department_id" id="department_id" class="form-select" required>
                            <option value="" hidden >اختر القسم</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">الوصف</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required
                            placeholder="أدخل تفاصيل الشكوى"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إرسال</button>
                </div>
            </div>
        </form>
    </div>
</div>