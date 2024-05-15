<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(): View|Factory|Application
    {
        $documents = Document::all();
        $document = new Document;
        $content = '';
        return view('documents.editor', compact('documents', 'document', 'content'));
    }

    public function downloadPdf($documentId): \Illuminate\Http\Response
    {
        $document = Document::findOrFail($documentId);
        $content = $document->currentVersion ? Storage::get($document->currentVersion->file_path) : '';

        $pdf = PDF::loadView('documents.pdf', compact('document', 'content'));
        return $pdf->download($document->name . '.pdf');
    }

    public function showPdf($documentId): View|Factory|Application
    {
        $document = Document::findOrFail($documentId);
        $content = $document->currentVersion ? Storage::get($document->currentVersion->file_path) : '';
        $pdf = Pdf::loadView('documents.pdf', compact('document', 'content'))->output();
        $pdfBase64 = base64_encode($pdf);
        return view('documents.show_pdf', compact('document', 'pdfBase64'));
    }

    public function edit($documentId = null): View|Factory|Application
    {
        $documents = Document::all();  // Pobieranie wszystkich dokumentów
        $document = $documentId ? Document::findOrFail($documentId) : new Document;
        $content = $document->currentVersion ? Storage::get($document->currentVersion->file_path) : '';
        return view('documents.editor', compact('documents', 'document', 'content'));
    }

    public function store(Request $request, $documentId = null): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($documentId) {
            $document = Document::findOrFail($documentId);
            $document->name = $request->input('name');
            $document->save();
        } else {
            $document = Document::create([
                'id' => (string) Str::uuid(),
                'name' => $request->input('name')
            ]);
        }

        $version = $document->versions()->create([
            'id' => (string) Str::uuid(),
            'version_number' => $document->versions()->count() + 1,
            'file_path' => '',
            'checksum' => md5($request->input('content')),
            'created_by' => auth()->id()
        ]);

        $path = 'documents/' . $version->id . '.html';
        Storage::put($path, $request->input('content'));
        $version->file_path = $path;
        $version->save();

        // Ustawienie current_version_id w dokumencie
        $document->current_version_id = $version->id;
        $document->save();

        return redirect()->route('documents.edit', ['documentId' => $document->id])->with('success', 'Dokument został zapisany.');
    }

    public function show($documentId): View|Factory|Application
    {
        $document = Document::findOrFail($documentId);
        $content = $document->currentVersion ? Storage::get($document->currentVersion->file_path) : '';
        return view('documents.show', compact('document', 'content'));
    }

    public function destroy($documentId): RedirectResponse
    {
        $document = Document::findOrFail($documentId);
        foreach ($document->versions as $version) {
            Storage::delete($version->file_path);
            $version->delete();
        }
        $document->delete();
        return redirect()->route('documents.create')->with('success', 'Dokument został usunięty.');
    }
}
