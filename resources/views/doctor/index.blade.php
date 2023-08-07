@extends('layouts.doctor')

@section('title', 'Доктор')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-6">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество Услугов</h4>
                    <div class="stats-figure">{{ $doctor_orders_count }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('doctor.index') }}"></a>
            </div>
        </div>
        <div class="col-6 col-lg-6">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество оказанных услуг</h4>
                    <div class="stats-figure">{{ $doctor_patients_count }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('doctor.orders') }}"></a>
            </div>
        </div>
    </div>
@endsection
