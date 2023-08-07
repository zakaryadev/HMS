@extends('layouts.admin')

@section('title', 'Главная')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество пациентов</h4>
                    <div class="stats-figure">{{ $count_patients }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.patients_index') }}"></a>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество позиций</h4>
                    <div class="stats-figure">{{ $count_positions }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.positions_index') }}"></a>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество услуг</h4>
                    <div class="stats-figure">{{ $count_services }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.services_index') }}"></a>
            </div>
        </div>

    </div>
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество врачей</h4>
                    <div class="stats-figure">{{ $count_doctors }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.doctors_index') }}"></a>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество кассиров</h4>
                    <div class="stats-figure">{{ $count_cashiers }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.cashiers_index') }}"></a>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество регистраторов</h4>
                    <div class="stats-figure">{{ $count_registrars }}</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.registrars_index') }}"></a>
            </div>
        </div>
    </div>
@endsection
