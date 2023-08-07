@extends('layouts.auth')

@section('title', 'Логин')

@section('content')
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="{{ route('login') }}">
                            <img class="logo-icon me-2" src="assets/images/app-logo.svg" alt="logo">
                        </a>
                    </div>
                    <h2 class="auth-heading text-center mb-5">Вход в панель</h2>
                    <div class="auth-form-container text-start">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="auth-form login-form" action="{{ route('authenticate') }}" method="POST">
                            @csrf
                            <div class="email mb-3">
                                <label class="sr-only">Логин</label>
                                <input name="login" type="text" class="form-control signin-email" placeholder="Логин"
                                    required="required">
                            </div>
                            <div class="password mb-3">
                                <label class="sr-only">Пароль</label>
                                <input name="password" type="password" class="form-control signin-password"
                                    placeholder="Пароль" required="required">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">
                                    Вход
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder">
            </div>
            <div class="auth-background-mask"></div>
            <div class="auth-background-overlay p-3 p-lg-5">
                <div class="d-flex flex-column align-content-end h-100">
                    <div class="h-100"></div>
                </div>
            </div>
            <!--//auth-background-overlay-->
        </div>
        <!--//auth-background-col-->

    </div>
@endsection
