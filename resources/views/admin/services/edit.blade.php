@extends('layouts.admin')

@section('title', 'Изменить сервис')

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
                <form action="{{ route('admin.services_update', ['service' => $service->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name">Имя сервиса</label>
                                <input type="text" class="form-control" name="name" placeholder="Имя сервиса"
                                    value="{{ $service->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="name">Сумма сервиса (сум)</label>
                                <input type="text" class="form-control" name="price" placeholder="Сумма сервиса"
                                    value="{{ $service->price }}">
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
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <div class="mb-3">
                                <a href="{{ route('admin.services_index') }}"
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
