<div class="modal fade" id="assignRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="assignRequestForm" method="POST">
             @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignRequestModalLabel">إسناد الطلب لموظف</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="assigned_to">اختر الموظف</label>
                        <select name="assigned_to" id="assigned_to" class="form-select" required>
                            
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إسناد</button>
                </div>
            </div>
        </form>
    </div>
</div>