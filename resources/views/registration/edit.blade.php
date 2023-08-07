@extends('layouts.registration')

@section('title', 'Редактировать данные пациента')

@section('content')
    <div class="row">
        <div class="col">
            <div class="app-card p-3">
                <form action="{{ route('registration.update', ['registration' => $patient->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Имя</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Имя"
                                    value="{{ $patient->first_name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Фамилия</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Фамилия"
                                    value="{{ $patient->last_name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Отчество</label>
                                <input type="text" class="form-control" name="sur_name" placeholder="Отчество"
                                    value="{{ $patient->sur_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Дата рождения</label>
                                <input type="date" class="form-control" name="date_birth" placeholder="Дата рождения"
                                    value="{{ $patient->date_birth }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="name">Телефон</label>
                                <input type="number" class="form-control" name="phone_number" placeholder="991234567"
                                    value="{{ $patient->phone_number }}">
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
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name">Адрес</label>
                                <input type="text" class="form-control" name="address" value="{{ $patient->address }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <div class="mb-3">
                                <a href="{{ route('registration.index') }}"
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
