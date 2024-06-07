@extends('layouts.app')

@section('content')
    @vite(['resources/sass/permission.scss'])
    <div class="container">
        <div class="card">
            <h1>Uprawnienia</h1>

            <!-- Formularz wyszukiwania -->
            <form method="GET" action="{{ route('admin.permissions.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Szukaj..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Szukaj</button>
                    </div>
                </div>
            </form>

            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary mb-3">Dodaj nowe uprawnienie</a>

            <table class="table mt-3">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Przypisane Role</th>
                    <th>Akcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>
                            @foreach ($permission->roles as $role)
                                {{ $role->name }},
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.permissions.edit', $permission->uuid) }}" class="btn btn-primary btn-sm">Edytuj</a>
                            <form action="{{ route('admin.permissions.destroy', $permission->uuid) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Paginacja -->
            <div class="pagination">
                {{ $permissions->links('vendor.pagination.simple-bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
