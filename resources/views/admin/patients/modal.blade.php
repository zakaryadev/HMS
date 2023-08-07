<div class="modal fade" id="addPatientsModal" tabindex="-1" aria-labelledby="addPatientsModal" aria-hidden="true">
    <div class="modal-dialog">

        <form action="{{ route('admin.patients_store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Добавить нового пациента</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="first_name">Имя</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="Имя">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="last_name">Фамилия</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Фамилия">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="sur_name">Отчество</label>
                                <input type="text" class="form-control" name="sur_name" id="sur_name"
                                    placeholder="Отчество">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="birth_date">Дата рождения</label>
                                <input type="date" class="form-control" name="date_birth" id="date_birth"
                                    placeholder="Дата рождения">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="phone_number">Телефон</label>
                                <input type="number" class="form-control" name="phone_number" id="phone_number"
                                    placeholder="991234567">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="sex">Пол</label>
                                <select class="form-select" name="sex_id">
                                    @foreach ($sexes as $sex)
                                        <option value="{{ $sex->id }}">{{ $sex->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="adress">Адрес</label>
                            <input type="text" class="form-control" name="address"
                                placeholder="Город Ташкент, улица Пример 19">
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
