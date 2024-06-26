@extends('layouts.app')

@section('content')
    @vite(['resources/sass/role.scss'])
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Role</h1>
                <a href="{{ route('admin.roles.create') }}" class="btn add-role-button">Dodaj nową rolę</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{ route('admin.roles.edit', $role->uuid) }}" class="btn btn-primary btn-sm">Edytuj</a>
                                <form action="{{ route('admin.roles.destroy', $role->uuid) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Czy na pewno chcesz usunąć tę rolę?')">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- Paginacja -->
                <div class="pagination">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
