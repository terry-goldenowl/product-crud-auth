@extends('layouts.manage-user')

@section('content-users')
    <h2>Users with roles</h2>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }} </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <p class="mb-sm-2">Errors:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="mb-0">
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
                {{-- <td>Email</td> --}}
                <td>Roles</td>
                <td>Permissions (Manually set)</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    {{-- <td>{{ $user->email }}</td> --}}
                    <td>
                        @if (count($user->getRoleNames()) > 0)
                            @foreach ($user->getRoleNames() as $role)
                                <p>{{ $role . ' ' }}</p>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if (count($user->getPermissionNames()) > 0)
                            @foreach ($user->getPermissionNames() as $permission)
                                <p>{{ $permission . ' ' }}</p>
                            @endforeach
                        @endif
                    </td>
                    <td class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm text-nowrap assignRolesBtn">Assign Role</button>

                        {{-- Assign roles modal --}}
                        <div class="modal fade" id="assignRolesModal{{ $user->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="assignRoleLabel">
                            <div class="modal-dialog" role="document">
                                <form class="modal-content" id="assignRolesForm{{ $user->id }}" method="POST"
                                    action="{{ route('users.roles.assign', ['id' => $user->id]) }}">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Assign Roles
                                        </h5>
                                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="fs-4">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input" name="roles[]" type="checkbox"
                                                    value="{{ $role->id }}"
                                                    id="user{{ $user->id }}-role{{ $role->id }}"
                                                    @if (in_array($role->name, array_values($user->getRoleNames()->toArray()))) @checked(true) @endif>
                                                <label class="form-check-label"
                                                    for="user{{ $user->id }}-role{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">
                                            Done
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm text-nowrap ms-1 givePermissionsBtn">Give
                            Permissions</button>

                        {{-- Give permissions modal --}}
                        <div class="modal fade" id="givePermissionsModal{{ $user->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="givePermissionLabel">
                            <div class="modal-dialog" role="document">
                                <form class="modal-content" id="givePermissionsForm{{ $user->id }}" method="POST"
                                    action="{{ route('users.permissions.give', ['id' => $user->id]) }}">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Give permissions
                                        </h5>
                                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="fs-4">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" name="permissions[]" type="checkbox"
                                                    value="{{ $permission->id }}"
                                                    id="user{{ $user->id }}-permission{{ $permission->id }}"
                                                    @if (in_array($permission->name, array_values($user->getPermissionNames()->toArray()))) @checked(true) @endif>
                                                <label class="form-check-label"
                                                    for="user{{ $user->id }}-permission{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">
                                            Done
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <form action="{{ route('users.delete', ['id' => $user->id]) }}" method="post" class="ms-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
    <script src="{{ asset('js/users-roles.js') }}"></script>
@endpush
