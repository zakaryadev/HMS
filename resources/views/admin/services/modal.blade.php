<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModal" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.services_store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить нового услугу</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label>Имя услуга</label>
                                <input type="text" class="form-control" name="name" placeholder="Имя">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name">Сумма услуга (сум)</label>
                                <input type="text" class="form-control" name="price" placeholder="Сумма сервиса">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name">Выберите позицию</label>
                                <select class="form-select" name="position_id" id="position_id">
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <div class="mb-3">
                                <button type="submit"
                                    class="btn btn-primary text-white float-right add_patient">Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
