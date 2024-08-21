@extends('layouts.app')
@section('title', __('auth_payment.title'))

@section('style')
@endsection

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-50">
        <form class="text-center w-50" style="max-width: 400px;" method="POST" onsubmit="return confirmPayment();">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-3 fw-normal">{{ __('auth_payment.title') }}</h1>
                    <p>{{ __('auth_payment.amount_to_pay', ['cost' => auth()->user()->registration_cost]) }}</p>
                    <div class="form-floating mt-1">
                        <input type="text" class="form-control" id="pay" placeholder="{{ __('auth_payment.input_money_placeholder') }}" name="pay" required>
                        <label for="pay">{{ __('auth_payment.amount') }}</label>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="w-100 btn btn-lg btn-primary" type="submit">{{ __('auth_payment.pay_button') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function confirmPayment() {
            const registrationCost = {{ auth()->user()->registration_cost }};
            const payAmount = parseFloat(document.getElementById('pay').value);
            let lang = '{{ App::getLocale() }}';

            let message = `{{ __('auth_payment.confirm_excess_message', ['excess' => '${excessAmount}']) }}`;
            if (payAmount > registrationCost) {
                const excessAmount = payAmount - registrationCost;
                return confirm(message.replace(':excess', excessAmount));
            }

            return true;
        }
    </script>
@endsection
