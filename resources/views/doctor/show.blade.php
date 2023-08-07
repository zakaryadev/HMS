@extends('layouts.doctor')

@section('title', 'Пациент')

@section('content')
    <div class="app-card p-3 shadow-sm">
        <div class="row-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>
                            ФИО
                        </td>
                        <td>
                            {{ $order->patient->first_name . ' ' . $order->patient->last_name . ' ' . $order->patient->sur_name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Дата рождения
                        </td>
                        <td>
                            {{ $order->patient->date_birth }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Имя Услуга
                        </td>
                        <td>
                            {{ $order->service->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Дата записи
                        </td>
                        <td>
                            {{ $order->updated_at->format('Y-m-d | H:i') }}
                        </td>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <form action="{{ route('doctor.orders.update', ['order' => $order->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="" class="form-label">Назначения</label>
                    <textarea class="form-control" style="height: 8rem;" name="destination" placeholder="Назначения">{{ $order->destination }}</textarea>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <a href="{{ route('doctor.orders') }}" class="btn btn-secondary me-2">Отмена</a>
                    <button type="submit" class="btn btn-primary text-white">Отправить</button>
                </div>
            </form>
        </div>
    </div>
@endsection
