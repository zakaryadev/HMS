@extends('layouts.doctor')

@section('title', 'Очередь')

@section('content')
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-sm-10 col-md-10 col-lg-12 mx-auto">
            <div class="app-card p-3 overflow-hidden shadow-sm">
                <table class="table table-responsive order_table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Отчество</th>
                            <th>Услуга</th>
                            <th>Статус</th>
                            <th>Время</th>
                            <th width="2%">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $order->patient->first_name }}</td>
                                <td>{{ $order->patient->last_name }}</td>
                                <td>{{ $order->patient->sur_name }}</td>
                                <td>{{ $order->service->name }}</td>
                                <td>{{ $order->doctor_id ? 'Услуга предоставлено' : 'Услуга не предоставлено' }}</td>
                                <td>{{ $order->updated_at->format('Y-m-d') }}</td>
                                <td class="d-flex gap-1 justify-content-center">
                                    @if ($order->doctor_id == null)
                                        <form action="{{ route('doctor.orders.update', ['order' => $order->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button onclick="return confirm('Вы уверены что хотите принять заявку?')"
                                                class="btn btn-primary text-white" type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                                                    <path
                                                        d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('doctor.orders.show', ['order' => $order->id]) }}"
                                        class="btn btn-warning text-white" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                            <path
                                                d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
