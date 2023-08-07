<div class="modal fade" id="addCashierModal" tabindex="-1" aria-labelledby="addCashierModal" aria-hidden="true">
    <div class="modal-dialog">

        <form action="{{ route('admin.cashiers_store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить нового кассира</h1>
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
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name">Логин</label>
                                <input type="text" class="form-control" name="login" placeholder="Логин">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name">Пароль</label>
                                <input type="text" name="password" class="form-control" placeholder="Пароль" />
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
