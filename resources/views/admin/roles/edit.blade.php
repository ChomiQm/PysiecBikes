@extends('layouts.app')

@section('content')
    @vite(['resources/sass/role_form.scss'])
    <div class="container">
        <div class="card">
            <h1>Edytuj Rolę: {{ $role->name }}</h1>
            <form action="{{ route('admin.roles.update', $role->uuid) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nazwa Roli:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                    @if($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Zaktualizuj Rolę</button>
            </form>
        </div>
    </div>
@endsection
