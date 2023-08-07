@extends('layouts.cash')

@section('title', 'Долг')

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
                            <th width="10%">Сумма</th>
                            <th width="5%">Оплаченная сумма</th>
                            <th width="5%">Оставшееся сумма</th>
                            <th width="12%">Статус платежа</th>
                            <th width="20%">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @if (count($order->debts) == 0)
                                <tr>
                                    <td scope="row">{{ $loop->index + 1 }}</td>
                                    <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}</td>
                                    <td>{{ $order->service->name }}</td>
                                    <td>{{ $order->service->price }}</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>
                                        <span class="badge {{ badgeStatus($order) }}">
                                            {{ $order->paid_status->name }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-1">
                                        {{-- @if ($order->paid_status_id != 1) --}}
                                        <form action="{{ route('cash.debts.confirmation', ['id' => $order->id]) }}"
                                            method="POST" class="d-flex gap-1">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <div class="d-flex flex-column">
                                                <select class="form-select" name="payment_method_id">
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">
                                                            {{ $payment_method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input style="width: 100px;" type="number" class="form-control" name="amount"
                                                placeholder="Наличный">
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
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                            @endif
                            @if (count($order->debts) == 1)
                                <tr>
                                    <td scope="row">{{ $loop->index + 1 }}</td>
                                    <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}</td>
                                    <td>{{ $order->service->name }}</td>
                                    <td>{{ $order->service->price }}</td>
                                    <td>{{ $order->debts[0]->paid_amount }}</td>
                                    <td>{{ $order->debts[0]->owed_amount }}</td>
                                    <td>
                                        <span class="badge {{ badgeStatus($order) }}">
                                            {{ $order->paid_status->name }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-1">
                                        {{-- @if ($order->paid_status_id != 1) --}}
                                        <form action="{{ route('cash.debts.confirmation', ['id' => $order->id]) }}"
                                            method="POST" class="d-flex gap-1">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <div class="d-flex flex-column">
                                                <select class="form-select" name="payment_method_id">
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">
                                                            {{ $payment_method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <input type="number" class="form-control" name="amount"
                                                    placeholder="Сумма">
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
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                            @endif
                            @if (count($order->debts) > 1)
                                <tr>
                                    <td scope="row">{{ $loop->index + 1 }}</td>
                                    <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}
                                    </td>
                                    <td>{{ $order->service->name }}</td>
                                    <td>{{ $order->service->price }}</td>
                                    <td>{{ $order->debts[1]->paid_amount }}</td>
                                    <td>{{ $order->debts[1]->owed_amount }}</td>
                                    <td>
                                        <span class="badge {{ badgeStatus($order) }}">
                                            {{ $order->paid_status->name }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-1">
                                        {{-- @if ($order->debts[1]->owed_amount != 0) --}}
                                        <form action="{{ route('cash.debts.confirmation', ['id' => $order->id]) }}"
                                            method="POST" class="d-flex gap-1">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <div class="d-flex flex-column">
                                                <select class="form-select" name="payment_method_id">
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">
                                                            {{ $payment_method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <input type="number" class="form-control" name="amount"
                                                    placeholder="Сумма">
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
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row">{{ $loop->index + 1 }}</td>
                                    <td>{{ $order->patient->first_name . ' ' . $order->patient->last_name }}</td>
                                    <td>{{ $order->service->name }}</td>
                                    <td>{{ $order->service->price }}</td>
                                    <td>{{ $order->debts[0]->paid_amount }}</td>
                                    <td>{{ $order->debts[0]->owed_amount }}</td>
                                    <td>
                                        <span class="badge {{ badgeStatus($order) }}">
                                            {{ $order->paid_status->name }}
                                        </span>
                                    </td>
                                    <td class="d-flex gap-1">
                                        {{-- @if ($order->debts[1]->owed_amount != 0) --}}
                                        <form action="{{ route('cash.debts.confirmation', ['id' => $order->id]) }}"
                                            method="POST" class="d-flex gap-1">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <div class="d-flex flex-column">
                                                <select class="form-select" name="payment_method_id">
                                                    @foreach ($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">
                                                            {{ $payment_method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <input type="number" class="form-control" name="amount"
                                                    placeholder="Сумма">
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
                                        {{-- @endif --}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
