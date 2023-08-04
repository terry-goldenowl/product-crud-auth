@extends('layouts.app')

@section('content')
    <div class="w-25 p-4 border border-primary ms-auto me-auto rounded">
        <div class="heading pb-2">
            <h2 class="text-center fs-3">Login</h2>
        </div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            @foreach ($errors->all() as $error)
                <p class="text-danger fs-6 mt-0">{{ $error }}</p>
            @endforeach
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

            <div class="w-full flex items-center mt-4">
                <input type="checkbox" name="remember" id="remember" class="rounded-sm w-4 h-4">
                <label for="remember" class="text-secondary">Remember me?</label>
            </div>
            <div class="text-center mt-1">
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="fs-6 mt-2">Not have account?<a href="{{ route('show-register') }}" class="ms-2 font-bold">Register
                        one</a></p>
            </div>
        </form>
    </div>
@endsection
