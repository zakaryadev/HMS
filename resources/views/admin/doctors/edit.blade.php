@extends('layouts.admin')

@section('title', 'Редактировать данные доктора')

@section('content')
    <div class="row">
        <div class="col">
            <div class="app-card p-3">
                <form action="{{ route('admin.doctors_update', ['doctor' => $doctor->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Имя"
                                    value="{{ $doctor->user->first_name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Фамилия</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Фамилия"
                                    value="{{ $doctor->user->last_name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Отчество</label>
                                <input type="text" class="form-control" name="sur_name" placeholder="Отчество"
                                    value="{{ $doctor->user->sur_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Дата рождения</label>
                                <input type="date" class="form-control" name="date_birth" placeholder="Дата рождения"
                                    value="{{ $doctor->user->date_birth }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Телефон</label>
                                <input type="number" class="form-control" name="phone_number" placeholder="991234567"
                                    value="{{ $doctor->user->phone_number }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Пол</label>
                                <select class="form-select" name="sex_id" id="sex_id">
                                    @foreach ($sexes as $sex)
                                        <option value="{{ $sex->id }}">{{ $sex->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Логин</label>
                                <input type="text" class="form-control" name="login" placeholder="Логин"
                                    value="{{ $doctor->user->login }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label for="name">Пароль</label>
                                <input type="text" name="password" class="form-control" placeholder="Пароль"
                                    value="{{ $doctor->user->password }}" />
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <label for="name">Подвердить пароль</label>
                                <input type="text" name="confirm_password" class="form-control"
                                    value="{{ $doctor->user->password }}" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Позиция</label>
                                <select class="form-select" name="position_id" id="position_id">
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name">Процент</label>
                                <input type="number" name="doctors_percent" class="form-control" placeholder="50%"
                                    value="{{ $doctor->doctors_percent }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <div class="mb-3">
                                <a href="{{ route('admin.doctors_index') }}"
                                    class="btn btn-secondary text-white float-right">Отмена</a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary text-white float-right">Обновить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
