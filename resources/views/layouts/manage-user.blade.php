@extends('layouts.app')

@section('content')
    <div class="d-flex ms-auto me-auto" style="width: 70%">
        <div class="" style="width: 20%">
            <ul class="list-unstyled">
                <li class="mb-2"><a
                        class="btn w-100 text-start @if (Route::currentRouteName() != 'users.index-roles') btn-outline-primary
                    @else 
                    btn-primary @endif"
                        href="{{ route('users.index-roles') }}" role="button">Users</a></li>
                <li class="mb-2"><a
                        class="btn w-100 text-start @if (Route::currentRouteName() != 'users.roles') btn-outline-primary
                    @else 
                    btn-primary @endif"
                        href="{{ route('users.roles') }}" role="button">Roles</a></li>
                <li class="mb-2"><a
                        class="btn w-100 text-start @if (Route::currentRouteName() != 'users.permissions') btn-outline-primary
                    @else 
                    btn-primary @endif"
                        href="{{ route('users.permissions') }}" role="button">Permissions</a>
                </li>
            </ul>
        </div>
        <div class="flex-grow-1 rounded-3 border border-primary p-3 ms-2">
            @yield('content-users')
        </div>
    </div>
@endsection
