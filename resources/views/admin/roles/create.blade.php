{{-- resources/views/admin/roles/create.blade.php --}}
@extends('layouts.app')

@section('content')
    @vite(['resources/sass/role_form.scss'])
    <div class="container">
        <h1>Dodaj Nową Rolę</h1>
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nazwa Roli:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @if($errors->has('name'))
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary mt-3">Dodaj Rolę</button>
        </form>
    </div>
@endsection
