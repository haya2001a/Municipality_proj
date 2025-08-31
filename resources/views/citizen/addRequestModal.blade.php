<div class="modal fade" id="addRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addRequestForm" method="POST" action="{{ route('citizen.requests.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة طلب خدمة</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="service_id">اختر الخدمة</label>
                        <select name="service_id" id="service_id" class="form-select" required>
                            <option value="" disabled selected>اختر الخدمة</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }} - {{ $service->price }} شيكل</option>
                            @endforeach
                        </select>
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
