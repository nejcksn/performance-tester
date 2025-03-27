@extends('adminlte::page')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
@endpush

@section('title', 'Users')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Users List</h1>
        @if(auth()->user()->hasRole(['admin', 'super_admin']))
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#giveRoleModal">
                <i class="fas fa-user-tag"></i> Manage Roles
            </button>
        @endif
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">All Users</h3>
            <div class="ml-auto btn-group">
                <a href="{{ route('admin.users.index', ['role' => 'all']) }}"
                   class="btn btn-outline-primary {{ request('role', 'all') === 'all' ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}"
                   class="btn btn-outline-primary {{ request('role') === 'admin' ? 'active' : '' }}">
                    Admins
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name . " " . $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span>{{ ucwords(str_replace('_', ' ', $role->name)) }}{{ $loop->last ? '' : ', ' }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if (!$user->hasRole('admin|super_admin'))
                                    <button class="btn btn-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-type="user"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }} {{ $user->surname }}"
                                            data-route="{{ route('admin.users.destroy', '') }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Role Modal -->
    <div class="modal fade" id="giveRoleModal" tabindex="-1" aria-labelledby="giveRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="giveRoleModalLabel">Assign a Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assignRoleForm">
                        @csrf

                        <div class="form-group">
                            <label for="userList" class="font-weight-bold">Select User</label>
                            <select id="userList" name="user_id" class="form-control w-100"></select>
                        </div>

                        <div class="form-group">
                            <label for="roleSelect" class="font-weight-bold">Select Role to Assign</label>
                            <select id="roleSelect" name="role" class="form-control w-100">
                                <option value="">Choose role</option>
                                @foreach($roles as $role)
                                    @if($role->name !== 'super_admin' && (auth()->user()->hasRole('super_admin') || $role->name !== 'admin'))
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Assign Role</button>
                    </form>

                    <hr>

                    <h5 class="font-weight-bold">Current Roles:</h5>
                    <ul id="userRolesList" class="list-group">
                        <li class="list-group-item">Select a user to view roles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('components.deleteModal')
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let roleList = $('#userRolesList');
            let assignRoleForm = $('#assignRoleForm');

            // Инициализация Select2 для пользователей
            $('#userList').select2({
                placeholder: "Choose user",
                allowClear: true,
                width: '100%',
                minimumInputLength: 2,
                theme: 'bootstrap-4',
                ajax: {
                    url: '/admin/users/search',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {q: params.term};
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(user => ({
                                id: user.id,
                                text: `${user.name} ${user.surname} (${user.email})`
                            }))
                        };
                    }
                },
                dropdownParent: $("#giveRoleModal")
            });

            // Инициализация Select2 для ролей
            $('#roleSelect').select2({
                placeholder: "Choose role",
                allowClear: true,
                theme: 'bootstrap-4',
                width: '100%',
                dropdownParent: $("#giveRoleModal")
            });

            // Обработчик выбора пользователя
            $('#userList').on('change', function () {
                let userId = $(this).val();
                if (!userId) {
                    roleList.html('<li class="list-group-item">Select a user to view roles</li>');
                    return;
                }
                loadUserRoles(userId);
            });

            // Функция загрузки ролей пользователя
            function loadUserRoles(userId) {
                $.get(`/admin/users/${userId}/roles`, function (data) {
                    roleList.html('');

                    if (!data.roles.length) {
                        roleList.html('<li class="list-group-item">No roles assigned</li>');
                    } else {
                        data.roles.forEach(role => {
                            let formattedRoleName = role.name
                                .replace(/_/g, ' ')  // Заменяет все символы _ на пробелы
                                .replace(/\b\w/g, char => char.toUpperCase());  // Преобразует первую букву каждого слова в верхний регистр

                            let li = $(`
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    ${formattedRoleName}
                                    <button class="btn btn-danger btn-sm remove-role" data-role="${role.name}" data-user-id="${userId}">Remove</button>
                                </li>
                            `);
                            roleList.append(li);
                        });
                    }
                }).fail(function () {
                    console.error('Error fetching roles');
                });
            }

            // Функция назначения роли
            assignRoleForm.on('submit', function (event) {
                event.preventDefault();

                let userId = $('#userList').val();
                let role = $('#roleSelect').val();

                if (!userId || !role) {
                    alert('Please select a user and a role.');
                    return;
                }

                $.ajax({
                    url: '/admin/users/assignRole',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    contentType: 'application/json',
                    data: JSON.stringify({user_id: userId, role: role}),
                    success: function (data) {
                        if (data.success) {
                            loadUserRoles(userId);
                            alert('Role assigned successfully');
                        } else {
                            alert(data.message || 'Error assigning role');
                        }
                    },
                    error: function () {
                        console.error('Error assigning role');
                    }
                });
            });

            // Удаление роли
            roleList.on('click', '.remove-role', function () {
                let role = $(this).data('role');
                let userId = $(this).data('user-id');

                $.ajax({
                    url: `/admin/users/${userId}/roles/${role}`,
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        if (data.success) {
                            loadUserRoles(userId);
                        } else {
                            alert(data.error || 'Error removing role');
                        }
                    },
                    error: function () {
                        console.error('Error removing role');
                    }
                });
            });
        });
    </script>
@endsection
