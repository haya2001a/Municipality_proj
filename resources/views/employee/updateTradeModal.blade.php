<div class="modal fade" id="tradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="tradeForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-content rounded-4 shadow-lg border-0">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold" id="tradeModalTitle">تعديل الرخصة</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tradeStatus" class="form-label fw-semibold">الحالة:</label>
                            <select name="status" id="tradeStatus" class="form-select">
                                <option value="سارية">سارية</option>
                                <option value="منتهية">منتهية</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="paidFees" class="form-label fw-semibold">المدفوع(بالدينار):</label>
                            <input type="number" step="0.01" min="0" name="paid_fees" id="paidFees"
                                class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-gradient">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>