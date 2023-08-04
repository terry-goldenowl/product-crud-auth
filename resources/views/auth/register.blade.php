@extends('layouts.app')

@section('content')
    <div class="w-25 p-4 border border-primary ms-auto me-auto rounded">
        <div class="heading pb-2">
            <h2 class="text-center fs-3">Register</h2>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group mt-2">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name"placeholder="Enter your name">
            </div>
            <p class="fs-6 text-danger font-italic text-end">{{ $errors->first('name') }}</p>

            <div class="form-group mt-2">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email"placeholder="Enter your email">
            </div>
            <p class="fs-6 text-danger font-italic text-end">{{ $errors->first('email') }}</p>

            <div class="form-group mt-2">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password"placeholder="Enter your password">
            </div>
            <p class="fs-6 text-danger font-italic text-end">{{ $errors->first('password') }}</p>

            <div class="form-group mt-2">
                <label for="password-confirm">Password Confirm</label>
                <input type="password" class="form-control" name="password_confirmation"
                    id="password-confirm"placeholder="Confirm your password">
            </div>

            <div class="d-flex flex-column align-items-center mt-4 gap-3">
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <p class="text-sm fs-6">Already registered?<a href="{{ route('show-login') }}"
                        class="ms-2 font-bold">Login</a></p>
            </div>
        </form>
    </div>
@endsection
