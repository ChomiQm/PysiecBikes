@extends('layouts.app')

@section('content')
    @vite(['resources/sass/editor.scss'])
    <div class="container-fluid editor-container d-flex justify-content-center align-items-start">
        <div class="row w-100">
            <div class="col-md-3 list-group-container me-4">
                <div class="card">
                    <div class="card-header">
                        Lista dokumentów
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach ($documents as $doc)
                            <a href="{{ route('documents.edit', $doc->id) }}" class="list-group-item list-group-item-action {{ $doc->id == $document->id ? ' active' : '' }}">
                                {{ $doc->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card editor-form">
                    <div class="card-header editor-header">
                        Edytor Dokumentów
                    </div>
                    <div class="card-body">
                        <form action="{{ route('documents.store', $document->id ?? null) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Nazwa dokumentu</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $document->name ?? '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="editor">Treść dokumentu</label>
                                <textarea class="form-control" id="editor" name="content" rows="10" required>{{ $content }}</textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Zapisz</button>
                                <a href="{{ route('documents.create') }}" class="btn btn-success">Dodaj nowy dokument</a>
                                @if(isset($document->id))
                                    <a href="{{ route('documents.showPdf', $document->id) }}" class="btn btn-secondary">Podgląd PDF</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('editor');
        });
    </script>
@endpush
