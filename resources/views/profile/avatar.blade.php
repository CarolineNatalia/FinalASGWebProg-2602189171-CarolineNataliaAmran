@extends('layouts.app')
@section('title')
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
            <h1 class="display-4">{{ __('profile_avatar.coin_balance') }}</h1>
            <p class="lead">{{ __('profile_avatar.your_coin', ['coins' => auth()->user()->coins]) }}</p>
        </div>
        <a href="{{ route('avatars.index', ['locale' => app()->getLocale()]) }}" class="btn btn-info mb-2">{{ __('profile_avatar.avatar_shops') }}</a>
        <h1>{{ __('profile_avatar.my_avatars') }}</h1>
        <div class="row">
            @foreach (auth()->user()->avatars as $avatar)
                <div class="card col-md-4 mb-4">
                    <img src="{{ asset('profile/' . $avatar->avatar->image) }}" class="card-img-top"
                        alt="{{ $avatar->avatar->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $avatar->avatar->name }}</h5>
                        <p class="card-text">{{ __('profile_avatar.price', ['price' => $avatar->avatar->price]) }}</p>
                        <form action="{{ route('profile.avatar.use') }}" method="POST">
                            @csrf
                            <input type="hidden" name="avatar_id" value="{{ $avatar->avatar->id }}">
                            <button type="submit" class="btn btn-primary">
                                {{ __('profile_avatar.use_as_profile_picture') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('script')
@endsection
