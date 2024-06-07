@extends('layouts.app')

@section('content')
    @vite(['resources/sass/permission_form.scss'])
    <div class="container">
        <div class="card">
            <h1>Edytuj Uprawnienie: {{ $permission->name }}</h1>
            <form action="{{ route('admin.permissions.update', $permission->uuid) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nazwa Uprawnienia:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
                    @if($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Zaktualizuj Uprawnienie</button>
            </form>
        </div>
    </div>
@endsection
