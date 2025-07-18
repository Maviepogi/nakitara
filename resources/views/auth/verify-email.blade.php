@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Verify Your Email Address</h4>
                </div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="alert alert-info" role="alert">
                        <strong>Almost there!</strong> We've sent a verification link to your email address.
                    </div>

                    <p>Before you can access your dashboard, please verify your email address by clicking the verification link we sent to <strong>{{ auth()->user()->email }}</strong>.</p>

                    <div class="mt-4">
                        <p>Didn't receive the email? Check your spam folder or request a new verification link:</p>
                        
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Resend Verification Email
                            </button>
                        </form>
                    </div>

                    <div class="mt-4">
                        <p>Want to use a different email address?</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link">
                                Logout and try again
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection