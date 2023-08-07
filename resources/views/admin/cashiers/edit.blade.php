@extends('layouts.admin')

@section('title', 'Редактировать данные доктора')

@section('content')
    <div class="row">
        <div class="col">
            <div class="app-card p-3">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.cashiers_update', ['cashier' => $cashier->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Имя"
                                    value="{{ $cashier->user->first_name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Фамилия</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Фамилия"
                                    value="{{ $cashier->user->last_name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Отчество</label>
                                <input type="text" class="form-control" name="sur_name" placeholder="Отчество"
                                    value="{{ $cashier->user->sur_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Дата рождения</label>
                                <input type="date" class="form-control" name="date_birth" placeholder="Дата рождения"
                                    value="{{ $cashier->user->date_birth }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Телефон</label>
                                <input type="number" class="form-control" name="phone_number" placeholder="991234567"
                                    value="{{ $cashier->user->phone_number }}">
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
                                    value="{{ $cashier->user->login }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Пароль</label>
                                <input type="text" name="password" class="form-control" placeholder="Пароль"
                                    value="{{ $cashier->user->password }}" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Подвердить пароль</label>
                                <input type="text" name="confirm_password" class="form-control"
                                    value="{{ $cashier->user->password }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <div class="mb-3">
                                <a href="{{ route('admin.cashiers_index') }}"
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
