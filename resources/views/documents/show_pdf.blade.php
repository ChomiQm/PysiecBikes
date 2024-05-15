@extends('layouts.app')

@section('content')
    @vite(['resources/sass/show_pdf.scss'])
    <div class="pdf-container">
        <h1>{{ $document->name }}</h1>
        <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}"></iframe>
    </div>
@endsection
