@extends('layouts.admin')

@section('title', 'Изменить позицию')

@section('content')
    <div class="row">
        <div class="col">
            <div class="app-card p-3">
                <form action="{{ route('admin.positions_update', ['position' => $position->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name">Имя позиции</label>
                                <input type="text" class="form-control" name="name" placeholder="Имя позиции"
                                    value="{{ $position->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <div class="mb-3">
                                <a href="{{ route('admin.positions_index') }}"
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
