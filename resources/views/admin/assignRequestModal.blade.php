<div class="modal fade" id="assignRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="assignRequestForm" method="POST">
            @csrf
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header border-0 d-flex justify-content-between">
                    <h5 class="modal-title fw-bold">إسناد الطلب لموظف</h5>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="assigned_to" class="form-label">اختر الموظف</label>
                            <select name="assigned_to" id="assigned_to" class="form-select bg-light" required>
                                <option value="" disabled hidden>اختر الموظف</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill"
                        data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-modern px-4 rounded-pill">إسناد</button>
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
