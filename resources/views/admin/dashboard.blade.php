@extends('layouts.app')

@section('content')
    @vite(['resources/sass/admin_dashboard.scss'])
    <div class="container admin-dashboard">
        <h1>Panel Administracyjny</h1>

        <!-- Formularz wyszukiwania -->
        <form method="GET" action="{{ route('admin.dashboard') }}" class="search-form">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Szukaj..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary">Szukaj</button>
            </div>
        </form>

        <!-- Tabela użytkowników -->
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nazwa użytkownika</th>
                <th>Imię i nazwisko</th>
                <th>Role</th>
                <th>Uprawnienia</th>
                <th>Akcje</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->user_data->first_name ?? '' }} {{ $user->user_data->last_name ?? '' }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            <span class="badge badge-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($user->getAllPermissions() as $permission)
                            <span class="badge badge-info">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="actions">
                            <!-- Formularze do przypisywania/usuwania ról -->
                            <form action="{{ route('admin.users.assign-role', $user->id) }}" method="POST" class="form-inline d-inline-block">
                                @csrf
                                <select name="role" class="form-select form-select-sm">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Przypisz Rolę</button>
                            </form>
                            <form action="{{ route('admin.users.remove-role', $user->id) }}" method="POST" class="form-inline d-inline-block">
                                @csrf
                                <select name="role" class="form-select form-select-sm">
                                    @foreach ($user->roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-danger btn-sm">Usuń Rolę</button>
                            </form>

                            <!-- Formularze do przypisywania/usuwania uprawnień -->
                            <form action="{{ route('admin.users.assign-permission', $user->id) }}" method="POST" class="form-inline d-inline-block">
                                @csrf
                                <select name="permission" class="form-select form-select-sm">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Przypisz Uprawnienie</button>
                            </form>
                            <form action="{{ route('admin.users.remove-permission', $user->id) }}" method="POST" class="form-inline d-inline-block">
                                @csrf
                                <select name="permission" class="form-select form-select-sm">
                                    @foreach ($user->getAllPermissions() as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-danger btn-sm">Usuń Uprawnienie</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Paginacja -->
        <div class="pagination-container">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
