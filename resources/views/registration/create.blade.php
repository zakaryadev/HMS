@extends('layouts.registration')

@section('title', 'Добавить нового пациента')

@section('content')
    <div class="row">
        <div class="col">
            <div class="app-card p-3">
                <form action="{{ route('registration.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Имя">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Фамилия</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Фамилия">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Отчество</label>
                                <input type="text" class="form-control" name="sur_name" placeholder="Отчество">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Дата рождения</label>
                                <input type="date" class="form-control" name="birth_date" placeholder="Дата рождения">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Телефон</label>
                                <input type="number" class="form-control" name="phone_number" placeholder="991234567">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Пол</label>
                                <select class="form-select" name="sex" id="sex">
                                    <option value="мужской">Мужской</option>
                                    <option value="женской">Женской</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary text-white float-right">Добавить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
