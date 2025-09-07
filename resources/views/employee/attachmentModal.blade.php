<div class="modal fade" id="attachmentsModal" tabindex="-1" aria-labelledby="attachmentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg border-0">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title fw-bold" id="attachmentsModalLabel">ملفات الطلب</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="attachmentsContainer" class="d-flex flex-column gap-3"></div>
        <div id="noAttachmentsMessage" class="text-center text-muted mt-4 d-none">
          لا يوجد ملفات لهذا الطلب
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .attachment-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    background: #f8f9fa;
    border: 1px solid #e0e0e0;
    transition: background 0.2s, transform 0.2s;
    cursor: pointer;
  }

  .attachment-item:hover {
    background: #e9f0ff;
    transform: translateY(-2px);
  }

  .attachment-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
  }

  .attachment-item i {
    font-size: 32px;
    color: #0d6efd;
    min-width: 80px;
    text-align: center;
  }

  .attachment-name {
    flex: 1;
    font-size: 14px;
    color: #495057;
    word-break: break-word;
    white-space: pre-line;
  }

  .attachment-divider {
    height: 1px;
    background: #dee2e6;
    margin: 0;
  }
</style>