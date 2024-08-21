@extends('layouts.app')
@section('title')
    {{ __('coin_index.title') }}
@endsection

@section('style')
    <style>
        .jumbotron-custom {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
            background-color: #e9ecef;
            border-radius: 0.3rem;
        }

        .jumbotron-custom h1 {
            font-size: 2.5rem;
        }

        .jumbotron-custom p {
            font-size: 1.25rem;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="jumbotron-custom">
            <h1 class="display-4">{{ __('coin_index.title') }}</h1>
            <p class="lead">{!! __('coin_index.your_coin', ['coins' => auth()->user()->coins]) !!}</p>
        </div>

        <div class="card col-md-4">
            <div class="card-body">
                <h5 class="card-title">{{ __('coin_index.top_up_title') }}</h5>
                <p class="card-text">
                    {!! __('coin_index.top_up_description', ['total' => auth()->user()->coins + 100]) !!}
                </p>
                <p class="card-text">
                    {!! __('coin_index.total_coins_after_top_up', ['total' => auth()->user()->coins + 100])!!}
                </p>
                <form action="{{ route('coins.topup', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" value="100">
                    <button type="submit" class="btn btn-primary">{{ __('coin_index.top_up_button') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
