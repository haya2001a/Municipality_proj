<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet">
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

@vite(['resources/css/citizenServices.css'])

<div class="modal fade" id="requestServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="requestServiceForm" method="POST" action="{{ route('citizen.requests.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header border-0 d-flex justify-content-between">
                    <h5 class="modal-title fw-bold" id="modalTitle">طلب خدمة</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="service_id" id="serviceId">

                    <div class="mb-3">
                        <label class="form-label">اسم الخدمة</label>
                        <input type="text" id="serviceName" class="form-control bg-light" readonly>
                    </div>

                    <div class="flex-fill d-flex flex-column mb-3">
                        <label class="form-label">الأولوية</label>
                        <select name="priority"
                            class="form-select bg-light h-100 @error('priority') is-invalid @enderror" required>
                            <option value="" hidden>اختر الأولوية</option>
                            <option value="غير عاجل">غير عاجل</option>
                            <option value="متوسط">متوسط</option>
                            <option value="عاجل">عاجل</option>
                        </select>
                        @error('priority')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- display required document --}}
                    <div id="requiredDocsArea" class="mb-3"></div>


                    <div id="fileUploadArea" class="mb-3">
                        <input type="file" name="documents[]" id="serviceFiles" multiple>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill"
                        data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-modern px-4 rounded-pill">إرسال الطلب</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    FilePond.setOptions({
        storeAsFile: true
    });
    const inputElement = document.querySelector('#serviceFiles');
    const pond = FilePond.create(inputElement, {
        labelIdle: 'اسحب الملفات أو <span class="filepond--label-action">اختر الملفات</span>',
        labelButtonRemoveItem: 'حذف',
        credits: false,
        allowMultiple: true,
    });

    const modalEl = document.getElementById('requestServiceModal');
    const modal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.request-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const documents = JSON.parse(this.dataset.documents || '[]');

            document.getElementById('serviceId').value = id;
            document.getElementById('serviceName').value = name;

            let docsHtml = '';
            if (documents.length) {
                docsHtml +=
                    `<label class="form-label">الملفات المطلوبة:</label><ul class="list-unstyled mb-3">`;
                documents.forEach(doc => {
                    docsHtml +=
                        `<li class="mb-1"><i class="bi bi-check-circle-fill me-2" style="color:#1e3c72;"></i>${doc}</li>`;
                });
                docsHtml += `</ul>`;
                document.getElementById('fileUploadArea').style.display = 'block';
            } else {
                docsHtml = `<p class="text-muted">لا توجد ملفات مطلوبة</p>`;
                document.getElementById('fileUploadArea').style.display = 'none';
            }

            document.getElementById('requiredDocsArea').innerHTML = docsHtml;

            pond.removeFiles();
            modal.show();
        });
    });
</script>
