<div class="modal fade" id="respondModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="respondForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="respondModalTitle">الرد على الشكوى</h5>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الرد:</label>
                        <textarea name="response" id="complaintResponse" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الحالة:</label>
                        <select name="status" id="complaintStatus" class="form-select">
                            <option value="قيد الانتظار">قيد الانتظار</option>
                            <option value="مرفوض">مرفوض</option>
                            <option value="مكتمل">مكتمل</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-gradient btn-success">رد</button>
                </div>
            </div>
        </form>
    </div>
</div>
