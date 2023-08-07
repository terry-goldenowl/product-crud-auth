@extends('layouts.manage-user')

@section('content-users')
    <h2>Roles</h2>

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
                <td>Permission</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if (count($role->getPermissionNames()) > 0)
                            @foreach ($role->getPermissionNames() as $permission)
                                <div>{{ $permission }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm addPermissionsBtn">Choose
                            permissions</button>

                        {{-- Choose permission modal --}}
                        <div class="modal fade" id="choosePermissionModal{{ $role->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="choosePermissionLabel">
                            <div class="modal-dialog" role="document">
                                <form class="modal-content" id="choosePermissionForm{{ $role->id }}" method="POST"
                                    action="{{ route('add-permissions-to-role', ['id' => $role->id]) }}">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Choose permissions
                                        </h5>
                                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="fs-4">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" name="permissions[]" type="checkbox"
                                                    value="{{ $permission->id }}"
                                                    id="role{{ $role->id }}-per{{ $permission->id }}"
                                                    @if (in_array($permission->name, array_values($role->getPermissionNames()->toArray()))) @checked(true) @endif>
                                                <label class="form-check-label"
                                                    for="role{{ $role->id }}-per{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">
                                            Done
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form action="{{ route('delete-role', ['id' => $role->id]) }}" method="post" class="ms-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-end">
        <button class="btn btn-primary" id="addRoleBtn">Add role</button>
    </div>

    {{-- Add role modal --}}
    <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form class="modal-content" id="addRoleForm" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Add role
                    </h5>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fs-4">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mt-2">
                        <label for="name">Role name</label>
                        <input type="text" class="form-control" name="name"
                            id="name"placeholder="Enter role name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Add role
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/roles.js') }}"></script>
@endpush
