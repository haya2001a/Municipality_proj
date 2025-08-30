<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>تأكيد الحذف</h5>
            </div>
            <div class="modal-body text-center">
                <p class="mb-0" id="deleteModalMessage">هل أنت متأكد أنك تريد حذف هذا العنصر؟</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">متأكد</button>
                </form>
            </div>
        </div>
    </div>
</div>
