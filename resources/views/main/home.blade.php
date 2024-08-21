@extends('layouts.app')
@section('title')
@endsection

@section('style')
@endsection

@section('content')
    <div class="container py-3">
        <h1>{{ __('home.title') }}</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('dashboard', ['locale' => App::getLocale()]) }}" class="mb-4">
            <div class="row g-2">
                <!-- Search Field -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('home.search_placeholder') }}" value="{{ request('search') }}">
                </div>

                <!-- Field Selection -->
                <div class="col-md-4">
                    <select name="field" class="form-select">
                        <option value="">{{ __('home.select_field') }}</option>
                        @foreach($allFields as $field)
                            <option value="{{ $field->id }}" {{ request('field') == $field->id ? 'selected' : '' }}>
                                {{ $field->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Gender Selection -->
                <div class="col-md-2">
                    <select name="gender" class="form-select">
                        <option value="">{{ __('home.select_gender') }}</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>{{ __('home.male') }}</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>{{ __('home.female') }}</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">{{ __('home.search_button') }}</button>
                </div>
            </div>
        </form>

        @if (auth()->user())
            <div class="container"style="overflow-y: scroll; height: 80vh;">
                @foreach ($users as $user)
                    <div class="card mt-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('profile/' . $user->picture) }}" alt="profile" class="rounded-circle"
                                    width="200" height="200">
                                <div class="ms-3">
                                    <h5 class="card-title">{{ $user->name }}</h6>
                                    <h6 class="card-subtitle mb-1 text-muted">{{ Str::Title($user->gender) }}</h6>
                                    <h6 class="card-subtitle mb-1 text-muted">{{ $user->email }}</h6>
                                    <p class="card-text p-0 m-0 text-strong fw-bold">{{ __('home.job_label') }}: {{ $user->job }}</p>
                                    @foreach ($user->fields as $item)
                                        <span class="badge bg-primary">{{ $item->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @php
                                $friend = auth()
                                    ->user()
                                    ->friends->where('id', $user->id)
                                    ->first();
                            @endphp
                            @if ($friend)
                                <form action="{{ route('remove_friend', ['locale' => app()->getLocale()]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                    <button class="text-dark" style="background:none; border:none;">
                                        <i class="bi bi-hand-thumbs-up-fill fs-3 text-primary"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('add_friend', ['locale' => app()->getLocale()]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                    <button class="text-dark" style="background:none; border:none;">
                                        <i class="bi bi-hand-thumbs-up fs-3"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="container"style="overflow-y: scroll; height: 80vh;">
                @foreach ($users as $user)
                    <div class="card mt-2">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('profile/' . $user->picture) }}" alt="profile" class="rounded-circle"
                                    width="200" height="200">
                                <div class="ms-3">
                                    <h5 class="card-title">{{ $user->name }}</h5>
                                    <h6 class="card-subtitle mb-1 text-muted">{{ Str::Title($user->gender) }}</h6>
                                    <h6 class="card-subtitle mb-1 text-muted">{{ $user->email }}</h6>
                                    <p class="card-text p-0 m-0 text-strong fw-bold">{{ __('home.job_label') }}: {{ $user->job }}</p>
                                    @foreach ($user->fields as $item)
                                        <span class="badge bg-primary">{{ $item->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <form action="{{ route('add_friend') }}" method="POST">
                                @csrf
                                <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                <button class="text-dark" style="background:none; border:none;">
                                    <i class="bi bi-hand-thumbs-up fs-3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('script')
@endsection
