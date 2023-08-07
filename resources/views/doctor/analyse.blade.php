@extends('layouts.doctor')

@section('title', 'Статистика')

@section('content')
    <div class="row">
        <div class="app-card p-3">
            <table class="table table-bordered order_table">
                <thead>
                    <tr>
                        <th width="2%">№</th>
                        <th width="15%">Пациент</th>
                        <th width="15%">Врач</th>
                        <th width="10%">Услуга</th>
                        <th width="5%">Сумма</th>
                        <th width="12%">Статус платежа</th>
                        <th width="15%">Тип платежа</th>
                        <th width="15%">Время регистраций</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders)
                        @foreach ($orders as $order)
                            <tr>
                                <td scope="row">{{ $loop->index + 1 }}</td>
                                <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}</td>
                                <td>{{ $order->doctor->user->first_name . ' ' . $order->doctor->user->last_name }}</td>
                                <td>{{ $order->service->name }}</td>
                                <td>{{ $order->price }}</td>
                                <td>
                                    <span class="badge {{ badgeStatus($order) }}">
                                        {{ $order->paid_status->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $order->payment_method->name }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d.m.Y | H:i') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
