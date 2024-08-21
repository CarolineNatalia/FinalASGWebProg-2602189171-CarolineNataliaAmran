@extends('layouts.app')
@section('title')
    {{ __('login.title') }}
@endsection

@section('style')
    <style>
        /* Existing styles here */
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <form class="text-center w-50" style="max-width: 400px;" method="POST">

            <h1 class="h3 mb-3 fw-normal">{{ __('login.title') }}</h1>
            @csrf

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                <label for="floatingInput">{{ __('login.email_address') }}</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="{{ __('login.password') }}" name="password">
                <label for="floatingPassword">{{ __('login.password') }}</label>
            </div>

            <div class="form-check text-start my-3 mx-0 p-0 m-0">
                <a href="{{ route('auth.register') }}" style="color: black" >
                    {{ __('login.no_account') }}
                </a>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">{{ __('login.sign_in') }}</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017-2024</p>
        </form>
    </div>
@endsection

@section('script')
@endsection
