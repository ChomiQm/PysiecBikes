@extends('layouts.app')

@section('content')
    @vite(['resources/sass/permission_form.scss'])
    <div class="container">
        <div class="card">
            <h1>Dodaj Nowe Uprawnienie</h1>
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nazwa Uprawnienia:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @if($errors->has('name'))
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="form-group mt-3">
                    <label for="role">Wybierz Rolę:</label>
                    <select name="role_uuid" id="role" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->uuid }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Dodaj Uprawnienie</button>
            </form>
        </div>
    </div>
@endsection
