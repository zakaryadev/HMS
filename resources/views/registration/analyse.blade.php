@extends('layouts.registration')

@section('title', 'Анализ')
@section('content')
    <div class="row">
        <div class="col col-md-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Зарегистированных пациенты в последних 7 дней</h4>
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-4">
                    <div class="chart-container">
                        <canvas id="chart-doughnut"></canvas>
                    </div>
                </div>
                <!--//app-card-body-->
            </div>
        </div>
        <div class="col-auto">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Количество пациенты</h4>
                    <div class="stats-figure">
                        <h1>{{ $total_patients }}</h1>
                    </div>
                    <div class="stats-meta">
                        <h3 class="text-{{ $upPercent == 0 ? 'danger' : 'success' }}">
                            {{ $upPercent == 0 ? '-' . $minusPercent : $upPercent }}%
                        </h3>
                    </div>
                </div>
                <!--//app-card-body-->
                <a class="app-card-link-mask" href="{{ route('registration.index') }}"></a>
            </div>
        </div>
    </div>
    @include('registration.charts')
@endsection
