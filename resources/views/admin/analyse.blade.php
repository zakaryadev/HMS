@extends('layouts.admin')

@section('title', 'Отчет')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="app-card p-3 overflow-hidden shadow-sm">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="row">
                    <div class="col-11">
                        <form class="row p-3 align-items-center" action="{{ route('admin.filter') }}" method="POST">
                            @csrf
                            <div class="col-3 mb-3">
                                <label class="form-label">Начало периода</label>
                                <input value="{{ $start_date ?? '' }}" type="date" class="form-control"
                                    placeholder="Начало периода" name="start_date">
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">Конец периода</label>
                                <input value="{{ $end_date ?? '' }}" type="date" class="form-control"
                                    placeholder="Конец периода" name="end_date">
                            </div>
                            <div class="col-2 mb-3">
                                <label class="form-label">Врач</label>
                                <select class="form-select" name="doctor_id">
                                    <option value="0">Все</option>
                                    @foreach ($doctors as $doctor)
                                        @if ($doctor_id)
                                            @if ($doctor_id == $doctor->id)
                                                <option value="{{ $doctor->id }}" selected>
                                                    {{ $doctor->user->first_name . ' ' . $doctor->user->last_name }}
                                                </option>
                                            @endif
                                            @if ($doctor_id != $doctor->id)
                                                <option value="{{ $doctor->id }}">
                                                    {{ $doctor->user->first_name . ' ' . $doctor->user->last_name }}
                                                </option>
                                            @endif
                                        @else
                                            <option value="{{ $doctor->id }}">
                                                {{ $doctor->user->first_name . ' ' . $doctor->user->last_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 d-flex flex-column mb-3">
                                <label class="form-label">Действия</label>
                                <a href="{{ route('admin.analyse') }}" class="btn btn-secondary">Отменить филтер</a>
                            </div>
                            <div class="col-2 d-flex flex-column mb-3">
                                <label class="form-label">Действия</label>
                                <button type="submit" class="btn app-btn-primary">Применить</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-1">
                        <form class="row py-3 align-items-center" action="{{ route('admin.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="start_date" value="{{ $start_date ?? '' }}">
                            <input type="hidden" name="end_date" value="{{ $end_date ?? '' }}">
                            <input type="hidden" name="doctor_id" value="{{ $doctor_id }}">
                            <div class="col-12 d-flex flex-column mb-3">
                                <label class="form-label">
                                    Экспорт
                                </label>
                                <button title="Export to Excel" type="submit" class="btn app-btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                        <path
                                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-3 px-3">
                    <div class="col-3 border rounded-2 text-center p-3 bg-success text-white d-flex flex-column">
                        <h4 class="text-white">Наличный</h4>
                        <h4 class="text-white text-end">{{ $paper_money ?? null }} сум</h4>
                    </div>
                    <div class="col-3 border rounded-2 text-center p-3 bg-info text-white d-flex flex-column">
                        <h4 class="text-white">Пластик карта</h4>
                        <h4 class="text-white text-end">{{ $card ?? null }} сум</h4>
                    </div>
                    <div class="col-3 border rounded-2 text-center p-3  bg-warning text-white d-flex flex-column">
                        <h4 class="text-white">Обшая сумма</h4>
                        <h4 class="text-white text-end">{{ $paper_money + $card ?? null }} сум</h4>
                    </div>
                    @if ($doctors_money)
                        <div class="col-3 border rounded-2 text-center p-3 bg-primary text-white d-flex flex-column">
                            <h4 class="text-white">Доля врача</h4>
                            <h4 class="text-white text-end">{{ $doctors_money }} сум</h4>
                        </div>
                    @endif
                </div>
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
    </div>
@endsection
