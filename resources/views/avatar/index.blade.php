@extends('layouts.app')
@section('title', __('avatar_index.title'))

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
            <h1 class="display-4">{{ __('avatar_index.your_coin_balance') }}</h1>
            <p class="lead">{{ __('avatar_index.your_coin', ['coins' => auth()->user()->coins]) }}</p>
        </div>
        <a href="{{ route('profile.avatar', ['locale' => app()->getLocale()]) }}" class="btn btn-warning mb-2">{{ __('avatar_index.my_avatars') }}</a>
        <h1>{{ __('avatar_index.title') }}</h1>
        <div class="row">
            @foreach($avatars as $avatar)
                <div class="card col-md-4 mb-4">
                    <img src="{{ asset('profile/' . $avatar->image) }}" class="card-img-top" alt="{{ $avatar->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $avatar->name }}</h5>
                        <p class="card-text">{{ __('avatar_index.price', ['price' => $avatar->price]) }}</p>
                        @php
                            $owned = \App\Models\UserAvatar::where('user_id', auth()->id())
                                ->where('avatar_id', $avatar->id)
                                ->exists();
                        @endphp
                        <form action="" method="POST">
                            @csrf
                            <input type="hidden" name="avatar_id" value="{{ $avatar->id }}">
                            <button type="submit" class="btn btn-primary"
                                @if($owned) disabled @endif>
                                @if($owned)
                                    {{ __('avatar_index.owned') }}
                                @else
                                    {{ __('avatar_index.buy') }}
                                @endif
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
