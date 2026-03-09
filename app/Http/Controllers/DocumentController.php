<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Document;
use App\Models\Service;
use App\Services\DocumentUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('full_name')->get();
        return view('documents.index', compact('clients'));
    }
    public function ajax(Request $request)
    {
        $query = Document::with(['client','clientService']);

        if ($request->service_id) {
            $query->whereHas('clientService', function ($q) use ($request) {
                $q->where('service_id', $request->service_id);
            });
        }
        if ($request->search) {
            $search = $request->search;

            $query->where(function($q) use ($search){
                $q->where('file_name','like','%'.$search.'%')
                ->orWhereHas('client', function($q2) use ($search){
                    $q2->where('full_name','like','%'.$search.'%')
                    ->orWhere('cnic','like','%'.$search.'%');
                });
            });
        }

        if ($request->document_date) {
            $query->whereDate('documentdate', $request->document_date);
        }

        if ($request->upload_date) {
            $query->whereDate('created_at', $request->upload_date);
        }

        $documents = $query->orderBy('documentdate','desc')->paginate(12);

        return view('documents.partials.table',compact('documents'))->render();
    }

    public function services(Request $request)
    {
        $services = Service::select('id', 'name')->get()
            ->map(function($s) {
                return [
                    'id' => $s->id,
                    'service_name' => $s->name ?? 'General',
                ];
            });

        return response()->json($services);
    }
    public function download($id)
    {
        $doc = Document::findOrFail($id);

        if (!Storage::disk('public')->exists($doc->file_path)) {
            abort(404, "File not found.");
        }

      $extension = pathinfo($doc->file_path, PATHINFO_EXTENSION);
        return Storage::disk('public')->download($doc->file_path, $doc->file_name . '.' . $extension);
    }

    public function uploaddocuments(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'service_id' => 'required|exists:services,id',
            'documents' => 'required|array',
            'documents.*.file' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv,txt|max:10240',
            'documents.*.document_date' => 'nullable|date',
        ]);

        $clientService = ClientService::where('client_id', $request->client_id)
            ->where('service_id', $request->service_id)
            ->first();

        if (!$clientService) {
            return back()->withInput()->withErrors([
                'error' => 'The selected client is not assigned to the selected service.'
            ]);
        }

        $client = Client::findOrFail($request->client_id);
        $service = Service::findOrFail($request->service_id);

        try {

            DB::transaction(function () use ($request, $clientService, $client, $service) {

                $cleanName = Str::slug($client->full_name);
                $cleanService = Str::slug($service->name);

                $folderPath = "documents/{$client->id}-{$cleanName}/{$cleanService}";

                $uploader = new DocumentUploadService();

                foreach ($request->documents as $doc) {

                    if (!isset($doc['file'])) {
                        continue;
                    }

                    $file = $doc['file'];
                    $originalName = $file->getClientOriginalName();

                    $path = $uploader->upload($file, $folderPath);

                    Document::create([
                        'client_id' => $request->client_id,
                        'client_service_id' => $clientService->id,
                        'file_name' => $doc['document_name'] ?? $originalName,
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getClientMimeType(),
                        'uploaded_by' => Auth::id(),
                        'documentdate' => $doc['document_date'] ?? null,
                    ]);
                }
            });

            return back()->with('success', 'Documents uploaded successfully.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function create(){
        $clients = Client::select('id', 'full_name', 'cnic')->get();
        return view('documents.create', compact('clients'));
    }
}
