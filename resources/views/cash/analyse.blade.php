@extends('layouts.cash')

@section('title', 'Анализ')
@section('content')
    <div class="row">
        <div class="col col-md-12 col-lg-6 mb-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Количество заказов в последних 7 дней</h4>
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-4">
                    <div class="chart-container">
                        <canvas id="chart-line"></canvas>
                    </div>
                </div>
                <!--//app-card-body-->
            </div>
        </div>
        <div class="col col-md-12 col-lg-6 mb-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Количество отменённых заказов в последних 7 дней</h4>
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-4">
                    <div class="chart-container">
                        <canvas id="chart-line-2"></canvas>
                    </div>
                </div>
                <!--//app-card-body-->
            </div>
        </div>
        <div class="col col-md-12 col-lg-6 mb-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Сумма в последних 7 дней - {{ $total_sum }} сум</h4>
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
        <div class="col col-md-12 col-lg-6 mb-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3 border-0">
                    <h4 class="app-card-title">Возвращенная сумма в последних 7 дней - {{ $returned_sum }} сум</h4>
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-4">
                    <div class="chart-container">
                        <canvas id="chart-doughnut-2"></canvas>
                    </div>
                </div>
                <!--//app-card-body-->
            </div>
        </div>
    </div>
    @include('cash.charts')
@endsection
