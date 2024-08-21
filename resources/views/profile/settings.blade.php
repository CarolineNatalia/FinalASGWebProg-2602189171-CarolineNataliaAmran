@extends('layouts.app')

@section('title', __('profile_settings.profile_settings'))

@section('style')
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ __('profile_settings.user_summary') }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Profile Image -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('profile/' . auth()->user()->picture) }}" alt="{{ __('profile_settings.profile_image') }}"
                                class="rounded-circle" style="width: 150px; height: 150px;">
                        </div>

                        <!-- Editable User Information -->
                        <form method="POST" action="{{ route('profile.settings.update') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __('profile_settings.name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ auth()->user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">{{ __('profile_settings.email') }}</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ auth()->user()->email }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">{{ __('profile_settings.gender') }}</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>
                                                {{ __('profile_settings.male') }}</option>
                                            <option value="female"
                                                {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>
                                                {{ __('profile_settings.female') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone">{{ __('profile_settings.phone') }}</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ auth()->user()->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="job">{{ __('profile_settings.job') }}</label>
                                        <input type="text" class="form-control" id="job" name="job"
                                            value="{{ auth()->user()->job }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">{{ __('profile_settings.username') }}</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ auth()->user()->username }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                @php
                                    $all_fields = \App\Models\Field::all();
                                    $all_fields = $all_fields->sortBy('name');
                                @endphp
                                @foreach (auth()->user()->fields as $field)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="field_{{ $field->id }}">{{ __('profile_settings.field') }}</label>
                                            <select name="fields[]" id="" class="form-select">
                                                <option value="{{ $field->id }}" selected>{{ $field->name }}</option>
                                                @foreach ($all_fields as $temp)
                                                    <option value="{{ $temp->id }}">{{ $temp->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">{{ __('profile_settings.update_profile') }}</button>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Reset Password -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ __('profile_settings.reset_password') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.settings.update_password') }}">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">{{ __('profile_settings.current_password') }}</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="new_password">{{ __('profile_settings.new_password') }}</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="confirm_password">{{ __('profile_settings.confirm_password') }}</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">{{ __('profile_settings.update_password') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Visibility -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('profile_settings.change_visibility') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.settings.update_visibility') }}">
                            @csrf
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="visibility" name="visibility"
                                    {{ auth()->user()->visibility ? 'checked' : '' }}>

                                <label class="form-check-label" for="visibility">
                                    {{ __('profile_settings.make_profile_visible') }}
                                </label>
                                @if (auth()->user()->visibility)
                                    <p style="visibility: 80%;">{{ __('profile_settings.pay_coins_invisible', ['amount' => 50]) }}</p>
                                @else
                                    <p style="visibility: 80%;">{{ __('profile_settings.pay_coins_visible', ['amount' => 5]) }}</p>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('profile_settings.update_visibility') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Add custom scripts here if needed -->
@endsection
