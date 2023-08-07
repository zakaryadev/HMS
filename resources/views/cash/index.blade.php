@extends('layouts.cash')

@section('title', 'Касса')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-12 mx-auto">
            <div class="app-card p-3 overflow-hidden shadow-sm">
                <table class="table table-responsive order_table">
                    <thead>
                        <tr>
                            <th width="2%">№</th>
                            <th width="15%">Имя Фамилия</th>
                            <th width="10%">Услуга</th>
                            <th width="5%">Сумма</th>
                            <th width="12%">Статус платежа</th>
                            {{-- <th width="10%">Время обновления</th> --}}
                            <th width="20%">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td scope="row">{{ $loop->index + 1 }}</td>
                                <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}</td>
                                <td>{{ $order->service->name }}</td>
                                <td>{{ $order->price }}</td>
                                <td>
                                    <span class="badge {{ badgeStatus($order) }}">
                                        {{ $order->paid_status->name }}
                                    </span>
                                </td>
                                {{-- <td>{{ $order->updated_at->format('d.m.Y | H:i') }}</td> --}}
                                <td class="d-flex gap-1">
                                    {{-- <button type="button" class="btn btn-primary position-relative text-white">
                                            {{ $order->payment_method->name }}
                                        </button> --}}
                                    @if ($order->paid_status_id != 1 && $order->paid_status_id != 4)
                                        <form action="{{ route('cash.confirmation', ['orderId' => $order->id]) }}"
                                            method="POST" class="d-flex gap-1">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-flex flex-column">
                                                {{-- <label for="form-control">Выберите метод</label> --}}
                                                <select class="form-select" name="payment_method_id">
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">
                                                            {{ $payment_method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="d-flex flex-column">
                                                {{-- <label for="form-control">Наличный</label> --}}
                                                <input style="width: 100px;" type="number" class="form-control"
                                                    name="amount1" placeholder="Наличный">
                                            </div>
                                            <div class="d-flex flex-column">
                                                {{-- <label for="form-control">Пластик</label> --}}
                                                <input style="width: 100px;" type="number" class="form-control"
                                                    name="amount2" placeholder="Пластик">
                                            </div>

                                            <button onclick="return confirm('Вы уверены что хотите подтвердить платеж?')"
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
                                    @if ($order->paid_status_id == 1)
                                        <form action="{{ route('cash.invoice', ['id' => $order->id]) }}" method="POST"
                                            class="d-flex gap-1">
                                            @csrf
                                            <input type="hidden" name="created_at" value="{{ $order->created_at }}">
                                            <button class="btn btn-info text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    <path
                                                        d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('cash.return', ['returnId' => $order->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button onclick="return confirm('Вы уверены что хотите вернуть платеж?')"
                                            class="btn btn-danger text-white" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
