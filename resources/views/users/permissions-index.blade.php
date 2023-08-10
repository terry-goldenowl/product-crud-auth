@extends('layouts.manage-user')

@section('content-users')
    <h2>Permissions</h2>

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
                <td>Roles</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        @if (count($permission->getRoleNames()) > 0)
                            @foreach ($permission->getRoleNames() as $permissionName)
                                <div>{{ $permissionName }}</div>
                            @endforeach
                        @endif
                    </td>
                    {{-- <td class="d-flex">
                        <form action="{{ route('delete-permission', ['id' => $permission->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <div class="text-end">
        <button class="btn btn-primary" id="addPermissionBtn">Add permission</button>
    </div> --}}

    {{-- Add role modal --}}
    {{-- <div class="modal fade" id="addPermissionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form class="modal-content" id="addPermissionForm" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Add permission
                    </h5>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="fs-4">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mt-2">
                        <label for="name">Permission name</label>
                        <input type="text" class="form-control" name="name"
                            id="name"placeholder="Enter permission name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Add permission
                    </button>
                </div>
            </form>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script src="{{ asset('js/permissions.js') }}"></script>
@endpush
