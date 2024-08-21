@extends('layouts.app')
@section('title')
    {{ __('register.title') }}
@endsection

@section('style')
    <!-- Your CSS Here -->
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-75 mt-5">
        <form class="text-center w-50" style="max-width: 400px;" method="POST">
            @csrf
            <h1 class="h3 mb-3 fw-normal">{{ __('register.title') }}</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-floating mt-1">
                <input type="email" class="form-control" id="floatingInput" placeholder="{{ __('register.email') }}"
                    name="email" value="{{ old('email') }}" required>
                <label for="floatingInput">{{ __('register.email') }}</label>
            </div>

            <div class="form-floating mt-1">
                <input type="text" class="form-control" id="floatingName" placeholder="{{ __('register.name') }}"
                    name="name" value="{{ old('name') }}" required>
                <label for="floatingName">{{ __('register.name') }}</label>
            </div>

            <div class="form-floating mt-1">
                <input type="password" class="form-control" id="floatingPassword"
                    placeholder="{{ __('register.password') }}" name="password" required>
                <label for="floatingPassword">{{ __('register.password') }}</label>
            </div>

            <div class="form-floating mt-1">
                <select class="form-control" id="floatingGender" name="gender" required>
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>{{ __('register.select_gender') }}</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>{{ __('register.male') }}</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>{{ __('register.female') }}</option>
                </select>
                <label for="floatingGender">{{ __('register.gender') }}</label>
            </div>

            <div class="form-floating mt-1">
                <input type="text" class="form-control" id="floatingLinkedIn"
                    placeholder="{{ __('register.linkedin') }}" pattern="https://www.linkedin.com/in/[a-zA-Z0-9-]+"
                    title="{{ __('register.linkedin') }}" name="linkedin" value="{{ old('linkedin') }}" required>
                <label for="floatingLinkedIn">{{ __('register.linkedin') }}</label>
            </div>

            <div class="form-floating mt-1">
                <input type="tel" class="form-control" id="floatingMobile" placeholder="{{ __('register.mobile') }}"
                    pattern="\d+" title="{{ __('register.mobile') }}" name="phone" value="{{ old('phone') }}" required>
                <label for="floatingMobile">{{ __('register.mobile') }}</label>
            </div>

            <div class="form-floating mt-2 mb-1">
                <div class="row">
                    @php
                        $fields = App\Models\Field::all();
                        $fields = $fields->sortBy('name');
                    @endphp
                    @for ($i = 0; $i < 3; $i++)
                        <div class="col-md-4">
                            <select class="form-control" name="fields[]" required>
                                <option value="" disabled {{ old("fields.$i") ? '' : 'selected' }}>{{ __('register.select_fields') }}</option>
                                @foreach ($fields as $field)
                                    <option value="{{ $field->id }}" {{ old("fields.$i") == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="form-floating mt-1">
                <input type="text" name="job" class="form-control" placeholder="{{ __('register.job') }}"
                    value="{{ old('job') }}" required>
                <label for="floatingJob">{{ __('register.job') }}</label>
            </div>

            <div class="form-floating mt-1 mb-3">
                <input type="text" class="form-control" id="floatingCost"
                    placeholder="{{ __('register.registration_cost') }}" name="cost"
                    value="{{ old('cost', rand(100000, 125000)) }}">
                <label for="floatingCost">{{ __('register.registration_cost') }}</label>
            </div>

            <div class="text-start my-3 mx-0 p-0 m-0">
                <a href="{{ route('auth.login') }}" style="color: black">Have an account? Login</a>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">{{ __('register.register') }}</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017-2024</p>
        </form>
    </div>
@endsection

@section('script')
@endsection
